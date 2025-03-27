@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Design Metadata</h1>
    <form method="POST" action="{{ route('designs.update', $design->id) }}">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="title">Design Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $design->title }}" required>
        </div>
        
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ $design->description }}</textarea>
        </div>
        
        <div class="form-group">
            <label for="price">Price (USD)</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ $design->price }}" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Update Metadata</button>
    </form>
</div>
@endsection
