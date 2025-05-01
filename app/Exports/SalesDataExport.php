<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\Design;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class SalesDataExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    use Exportable;

    protected $startDate;
    protected $endDate;
    protected $userId;
    protected $designId;

    /**
     * @param string $startDate
     * @param string $endDate
     * @param int|null $userId
     * @param int|null $designId
     */
    public function __construct($startDate = null, $endDate = null, $userId = null, $designId = null)
    {
        $this->startDate = $startDate ? Carbon::parse($startDate) : Carbon::now()->subMonth();
        $this->endDate = $endDate ? Carbon::parse($endDate) : Carbon::now();
        $this->userId = $userId ?? auth()->id();
        $this->designId = $designId;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Order::query()
            ->whereHas('design', function ($query) {
                $query->where('user_id', $this->userId);
                
                if ($this->designId) {
                    $query->where('id', $this->designId);
                }
            })
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->with(['design', 'user'])
            ->orderBy('created_at', 'desc');
            
        return $query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Order ID',
            'Order Date',
            'Customer Name',
            'Customer Email',
            'Design Title',
            'Paper Type',
            'Quantity',
            'Unit Price',
            'Designer Earnings',
            'Total',
            'Status',
        ];
    }

    /**
     * @param Order $order
     * @return array
     */
    public function map($order): array
    {
        return [
            $order->order_number,
            $order->created_at->format('Y-m-d H:i:s'),
            $order->user->name,
            $order->user->email,
            $order->design->title,
            $order->paper_type->name ?? 'N/A',
            $order->quantity,
            $order->unit_price,
            $order->designer_earnings,
            $order->total,
            $order->status,
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return void
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],
        ];
    }
}

// Usage in controller
// return (new SalesDataExport($startDate, $endDate))
//     ->download('sales-' . Carbon::now()->format('Y-m-d') . '.xlsx');

