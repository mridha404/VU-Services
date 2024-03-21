@extends('layouts.app-master')

@section('content')
    <div class="card-body">
        <table class="table table-bordered border-success">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Title</th>
                    <th scope="col">Release Date</th>
                    <th scope="col">Vote Average</th>
                    <th scope="col">Vote Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($movies as $movie)
                    <tr>
                        <th scope="row">{{ $movie['id'] }}</th>
                        <td>{{ $movie['title'] }}</td>
                        <td>{{ $movie['release_date'] }}</td>
                        <td>{{ $movie['vote_average'] }}</td>
                        <td>{{ $movie['vote_count'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination links -->
        <div class="d-flex justify-content-center">
            {{ $movies->links() }}
        </div>
    </div>
@endsection
