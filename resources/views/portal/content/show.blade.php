@extends('layouts.portal')

@section('content')
    <div class="container">
        <h2>{{ $page->title }}</h2>
        <p><strong>Meta Title:</strong> {{ $page->meta_title }}</p>
        <p><strong>Meta Description:</strong> {{ $page->meta_description }}</p>
        <div>
            <h4>Content:</h4>
            {!! $page->content !!}
        </div>
        <a href="{{ route('pages.index') }}" class="btn btn-secondary mt-3">Back to Pages</a>
    </div>
@endsection
