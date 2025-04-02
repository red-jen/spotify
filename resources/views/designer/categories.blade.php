@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Assign Categories and Tags</h1>
    <form method="POST" action="{{ route('designs.categories.update', $design->id) }}">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label>Categories</label>
            <div class="category-checkboxes">
                @foreach($categories as $category)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="categories[]" 
                            value="{{ $category->id }}" id="category-{{ $category->id }}"
                            {{ in_array($category->id, $design->categories->pluck('id')->toArray()) ? 'checked' : '' }}>
                        <label class="form-check-label" for="category-{{ $category->id }}">
                            {{ $category->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        
        <div class="form-group">
            <label for="tags">Tags (comma separated)</label>
            <input type="text" class="form-control" id="tags" name="tags" 
                value="{{ $design->tags->pluck('name')->implode(', ') }}">
        </div>
        
        <button type="submit" class="btn btn-primary">Save Categories & Tags</button>
    </form>
</div>
@endsection
