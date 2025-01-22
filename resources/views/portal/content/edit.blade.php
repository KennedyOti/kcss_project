@extends('layouts.portal')

@section('content')
    <script src="https://cdn.ckeditor.com/4.18.0/standard/ckeditor.js"></script>
    <div class="container">
        <h2>Edit Page</h2>
        <form action="{{ route('pages.update', $page) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Page Title</label>
                <input type="text" name="title" class="form-control" value="{{ $page->title }}" required>
            </div>
            <div class="mb-3">
                <label for="meta_title" class="form-label">Meta Title</label>
                <input type="text" name="meta_title" class="form-control" value="{{ $page->meta_title }}">
            </div>
            <div class="mb-3">
                <label for="meta_description" class="form-label">Meta Description</label>
                <textarea name="meta_description" class="form-control">{{ $page->meta_description }}</textarea>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea name="content" id="contentEditor" class="form-control">{{ $page->content }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
    <script>
        CKEDITOR.replace('contentEditor');
    </script>
@endsection
