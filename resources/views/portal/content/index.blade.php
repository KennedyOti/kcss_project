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

        <!-- Filter Form -->
        <form method="GET" action="{{ route('pages.index') }}" class="mb-4">
            <div class="row g-2">
                <div class="col-md-4">
                    <input type="text" name="title" class="form-control" placeholder="Search by Title"
                        value="{{ $filters['title'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <input type="text" name="meta_title" class="form-control" placeholder="Search by Meta Title"
                        value="{{ $filters['meta_title'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>

        <!-- Pages Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Meta Title</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pages as $page)
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
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No pages found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if ($pages->hasPages())
            <div class="mt-3">
                {{ $pages->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
