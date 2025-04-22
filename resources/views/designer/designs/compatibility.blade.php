@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Paper Compatibility: {{ $design->title }}</h1>
    <p class="text-muted">Select which paper types are compatible with this design.</p>
    
    <form method="POST" action="{{ route('designs.compatibility.update', $design) }}">
        @csrf
        @method('PUT')
        
        <div class="row">
            @foreach($paperTypes as $paperType)
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-header">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="paper_types[]" 
                                    value="{{ $paperType->id }}" id="paper-{{ $paperType->id }}"
                                    {{ in_array($paperType->id, $design->paperTypes->pluck('id')->toArray()) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="paper-{{ $paperType->id }}">
                                    {{ $paperType->name }}
                                </label>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ $paperType->description }}</p>
                            <ul class="list-unstyled">
                                <li><small class="text-muted">Material: {{ $paperType->material }}</small></li>
                                <li><small class="text-muted">Finish: {{ $paperType->finish }}</small></li>
                                <li><small class="text-muted">Weight: {{ $paperType->weight }}gsm</small></li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Save Compatibility Settings</button>
            <a href="{{ route('designs.edit', $design) }}" class="btn btn-outline-secondary">Back to Edit</a>
        </div>
    </form>
</div>
@endsection
