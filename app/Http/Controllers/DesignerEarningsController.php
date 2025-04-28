<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Design;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DesignerEarningsController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $period = $request->get('period', 'month');
        
        // Get designs by the authenticated designer
        $designIds = Design::where('user_id', $user->id)->pluck('id');
        
        // Base query for orders with the designer's designs
        $ordersQuery = Order::whereIn('design_id', $designIds)
            ->where('status', 'completed');
            
        // Filter by time period
        switch ($period) {
            case 'week':
                $startDate = Carbon::now()->subWeek();
                break;
            case 'month':
                $startDate = Carbon::now()->subMonth();
                break;
            case 'quarter':
                $startDate = Carbon::now()->subQuarter();
                break;
            case 'year':
                $startDate = Carbon::now()->subYear();
                break;
            default:
                $startDate = Carbon::now()->subMonth();
        }
        
        $ordersQuery->where('created_at', '>=', $startDate);
        
        // Get earnings summary
        $earnings = $ordersQuery->select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(designer_earnings) as daily_earnings'),
            DB::raw('COUNT(*) as orders_count')
        )
        ->groupBy('date')
        ->orderBy('date')
        ->get();
        
        // Calculate totals
        $totalEarnings = $earnings->sum('daily_earnings');
        $totalOrders = $earnings->sum('orders_count');
        $avgOrderValue = $totalOrders > 0 ? $totalEarnings / $totalOrders : 0;
        
        // Prepare chart data
        $chartData = [
            'labels' => $earnings->pluck('date')->toArray(),
            'earnings' => $earnings->pluck('daily_earnings')->toArray(),
            'orders' => $earnings->pluck('orders_count')->toArray(),
        ];
        
        // Get top performing designs
        $topDesigns = Order::whereIn('design_id', $designIds)
            ->where('status', 'completed')
            ->where('created_at', '>=', $startDate)
            ->select('design_id', DB::raw('COUNT(*) as sales_count'), DB::raw('SUM(designer_earnings) as total_earnings'))
            ->groupBy('design_id')
            ->orderByDesc('total_earnings')
            ->take(5)
            ->with('design')
            ->get();
        
        return view('designer.earnings.index', compact(
            'earnings', 
            'totalEarnings', 
            'totalOrders', 
            'avgOrderValue',
            'chartData',
            'topDesigns',
            'period'
        ));
    }
    
    public function downloadReport(Request $request)
    {
        $user = auth()->user();
        $period = $request->get('period', 'month');
        
        // Similar logic to index method to gather data
        // ...
        
        // Generate CSV or PDF file based on request
        $format = $request->get('format', 'csv');
        
        if ($format === 'csv') {
            return $this->generateCsvReport($user, $period);
        } else {
            return $this->generatePdfReport($user, $period);
        }
    }
    
    private function generateCsvReport($user, $period)
    {
        // CSV generation logic
        // ...
    }
    
    private function generatePdfReport($user, $period)
    {
        // PDF generation logic
        // ...
    }
}
