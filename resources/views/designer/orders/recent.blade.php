@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Recent Orders</h1>
    
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Order History</h5>
            <a href="{{ route('designer.orders.index') }}" class="btn btn-sm btn-outline-primary">View All Orders</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Order ID</th>
                            <th scope="col">Customer</th>
                            <th scope="col">Design</th>
                            <th scope="col">Date</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td>#{{ $order->order_number }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->design->title }}</td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td>${{ number_format($order->total, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->status_color }}">{{ $order->status }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('designer.orders.show', $order) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">No recent orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="mt-4">
        <h2>Order Statistics</h2>
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <h5 class="card-title">Total Orders</h5>
                        <p class="display-4">{{ $stats['total_orders'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-4">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <h5 class="card-title">This Month</h5>
                        <p class="display-4">{{ $stats['month_orders'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-4">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <h5 class="card-title">Avg. Order Value</h5>
                        <p class="display-4">${{ number_format($stats['avg_order_value'], 2) }}</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-4">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <h5 class="card-title">Pending Orders</h5>
                        <p class="display-4">{{ $stats['pending_orders'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
