@extends('designer.widgets.base')
@section('widget_content')
<div class="sales-overview-widget">
    <h5 class="widget-title">Sales Overview</h5>
    
    <div class="chart-container mb-3" style="position: relative; height:250px;">
        <canvas id="salesChart"></canvas>
    </div>
    
    <div class="row text-center">
        <div class="col-4">
            <div class="p-2 border-end">
                <h6 class="small text-muted mb-1">This Month</h6>
                <p class="mb-0 fw-bold">${{ number_format($monthSales, 2) }}</p>
            </div>
        </div>
        <div class="col-4">
            <div class="p-2 border-end">
                <h6 class="small text-muted mb-1">This Week</h6>
                <p class="mb-0 fw-bold">${{ number_format($weekSales, 2) }}</p>
            </div>
        </div>
        <div class="col-4">
            <div class="p-2">
                <h6 class="small text-muted mb-1">Today</h6>
                <p class="mb-0 fw-bold">${{ number_format($todaySales, 2) }}</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($salesData['labels']) !!},
            datasets: [{
                label: 'Sales',
                data: {!! json_encode($salesData['values']) !!},
                borderColor: '#4c51bf',
                backgroundColor: 'rgba(76, 81, 191, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value;
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return '$' + context.parsed.y;
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection
