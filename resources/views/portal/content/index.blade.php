@extends('layouts.portal')

@section('content')
    <div class="container">
        <h2>Content Pages</h2>
        <a href="{{ route('pages.create') }}" class="btn btn-primary mb-3">Create New Page</a>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Meta Title</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pages as $page)
                    <tr>
                        <td>{{ $page->title }}</td>
                        <td>{{ $page->meta_title }}</td>
                        <td>
                            <a href="{{ route('pages.show', $page) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('pages.edit', $page) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('pages.destroy', $page) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
