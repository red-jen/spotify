@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card border-danger">
        <div class="card-header bg-danger text-white">
            <h3>Delete Design: {{ $design->title }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset('storage/designs/'.$design->filename) }}" class="img-fluid" alt="{{ $design->title }}">
                </div>
                <div class="col-md-8">
                    <h4>Are you sure you want to delete this design?</h4>
                    <p class="text-danger">This action cannot be undone. All associated data including sales history will remain in the database but will no longer be linked to this design.</p>
                    
                    <dl class="row">
                        <dt class="col-sm-3">Title</dt>
                        <dd class="col-sm-9">{{ $design->title }}</dd>
                        
                        <dt class="col-sm-3">Price</dt>
                        <dd class="col-sm-9">${{ number_format($design->price, 2) }}</dd>
                        
                        <dt class="col-sm-3">Uploaded</dt>
                        <dd class="col-sm-9">{{ $design->created_at->format('F d, Y') }}</dd>
                        
                        <dt class="col-sm-3">Status</dt>
                        <dd class="col-sm-9">{{ $design->is_active ? 'Active' : 'Inactive' }}</dd>
                    </dl>
                    
                    <form action="{{ route('designs.destroy', $design) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="d-flex">
                            <button type="submit" class="btn btn-danger me-2">Yes, Delete Design</button>
                            <a href="{{ route('designs.edit', $design) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
