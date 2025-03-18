@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Upload New Design</h1>
    <form method="POST" action="{{ route('designs.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="design-file">Design File</label>
            <input type="file" class="form-control" id="design-file" name="design_file" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload Design</button>
    </form>
</div>
@endsection
