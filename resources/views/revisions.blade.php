@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Article Revisions</h1>

    <h2>{{ $article->title }}</h2>
    <p>{{ $article->description }}</p>

    <h3>Revision History</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($revisions as $revision)
            <tr>
                <td>{{ $revision->title }}</td>
                <td>{{ $revision->description }}</td>
                <td>{{ $revision->updated_at }}</td>
                <td>
                    <a href="{{ route('revisions.show', ['article' => $article->id, 'revision' => $revision->id]) }}" class="btn btn-info">View</a>
                    <form action="{{ route('revisions.revert', ['article' => $article->id, 'revision' => $revision->id]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-warning">Revert</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
