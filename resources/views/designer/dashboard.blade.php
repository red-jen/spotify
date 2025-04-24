@extends('layouts.app')
@section('content')
<div class="container">
    <h1 class="mb-4">Designer Dashboard</h1>
    
    <div class="row">
        <!-- Statistics Cards -->
        <div class="col-md-3 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <h5 class="card-title">Total Designs</h5>
                    <p class="display-4">{{ $stats['total_designs'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <h5 class="card-title">Total Sales</h5>
                    <p class="display-4">{{ $stats['total_sales'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <h5 class="card-title">Total Revenue</h5>
                    <p class="display-4">${{ number_format($stats['total_revenue'], 2) }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <h5 class="card-title">Avg. Rating</h5>
                    <p class="display-4">{{ number_format($stats['avg_rating'], 1) }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Recent Activity -->
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Recent Activity</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @forelse($activities as $activity)
                            <div class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">{{ $activity->type }}</h6>
                                    <p>{{ $activity->description }}</p>
                                    <p class="text-muted small">{{ $activity->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">No recent activity</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="{{ route('designs.create') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-upload me-2"></i> Upload New Design
                        </a>
                        <a href="{{ route('designs.index') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-images me-2"></i> Manage Designs
                        </a>
                        <a href="{{ route('designer.orders') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-shopping-cart me-2"></i> View Orders
                        </a>
                        <a href="{{ route('designer.earnings') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-dollar-sign me-2"></i> View Earnings
                        </a>
                        <a href="{{ route('designer.profile.edit') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-user-edit me-2"></i> Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
