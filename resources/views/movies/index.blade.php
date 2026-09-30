@extends('layouts.app')

@section('title', 'Movie List')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Movie List</h2>
        <a href="{{ route('movies.create') }}" class="btn btn-success">+ Add Movie</a>
    </div>

    {{-- Active filter status --}}
    @if($genre || $year)
        <div class="alert alert-info d-flex align-items-center gap-2 mb-3">
            <strong>Active filters:</strong>
            @if($genre)
                <span class="badge bg-primary">Genre: {{ $genre }}</span>
            @endif
            @if($year)
                <span class="badge bg-secondary">Year: {{ $year }}</span>
            @endif
            <a href="{{ route('movies.index') }}" class="btn btn-sm btn-outline-danger ms-auto">
                ✕ Clear All Filters
            </a>
        </div>
    @endif

    {{-- Genre filter links --}}
    <div class="mb-2">
        <span class="fw-semibold me-2">Genre:</span>
        @foreach(['Action', 'Science Fiction', 'Superhero'] as $g)
            <a href="{{ route('movies.index', array_filter(['genre' => $g, 'year' => $year])) }}"
               class="btn btn-sm me-1 {{ $genre === $g ? 'btn-primary' : 'btn-outline-primary' }}">
                {{ $g }}
            </a>
        @endforeach
    </div>

    {{-- Year filter links --}}
    <div class="mb-4">
        <span class="fw-semibold me-2">Year:</span>
        @foreach([1999, 2008, 2010, 2014, 2021] as $y)
            <a href="{{ route('movies.index', array_filter(['genre' => $genre, 'year' => $y])) }}"
               class="btn btn-sm me-1 {{ (string)$year === (string)$y ? 'btn-secondary' : 'btn-outline-secondary' }}">
                {{ $y }}
            </a>
        @endforeach
    </div>

    <table class="table table-striped table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Genre</th>
                <th>Year</th>
                <th>Director</th>
                <th>Rating</th>
                <th>Duration</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($items as $movie)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <a href="{{ route('movies.show', $movie['id']) }}" class="fw-bold text-decoration-none">
                            {{ $movie['title'] }}
                        </a>
                    </td>
                    <td>{{ $movie['genre'] }}</td>
                    <td>{{ $movie['year'] }}</td>
                    <td>{{ $movie['director'] }}</td>
                    <td>
                        {{ $movie['rating'] }}
                        @if ($movie['rating'] >= 8.5)
                            <span class="badge bg-success">Top Rated</span>
                        @endif
                    </td>
                    <td>{{ $movie['duration'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No movies found yet — add some to see them here.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection