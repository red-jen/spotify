@extends('layouts.app')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>My Designs</h1>
        <a href="{{ route('designs.create') }}" class="btn btn-primary">Upload New Design</a>
    </div>
    
    <div class="row">
        @forelse($designs as $design)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ asset('storage/designs/'.$design->filename) }}" class="card-img-top" alt="{{ $design->title }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $design->title }}</h5>
                        <p class="card-text">{{ Str::limit($design->description, 100) }}</p>
                        <div class="d-flex justify-content-between">
                            <span class="badge badge-primary">${{ number_format($design->price, 2) }}</span>
                            <span class="badge {{ $design->is_active ? 'badge-success' : 'badge-secondary' }}">
                                {{ $design->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('designs.edit', $design->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <a href="{{ route('designs.show', $design->id) }}" class="btn btn-sm btn-outline-secondary">View</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">You haven't uploaded any designs yet.</div>
            </div>
        @endforelse
    </div>
    
    <div class="d-flex justify-content-center">
        {{ $designs->links() }}
    </div>
</div>
@endsection
