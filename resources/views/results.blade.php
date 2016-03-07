@extends('layouts.app')

@section('title', 'Risultati')

@section('content')
<div class="col-md-10 col-md-offset-1">
    <h1>Risultati ricerca:</h1>
    <h5>Ricette:</h5>
    <ul>
        @foreach($titlesMatches as $titleMatch)
        <li>{{ $titleMatch }}</li>
        @endforeach
    </ul>
    <h5>Utenti:</h5>
    <ul>
        @foreach($usersMatches as $userMatch)
        <li><table><tr><td>{{ $userMatch->name }}</td></tr></table>{{ $userMatch->isAdmin }}</li>
        @endforeach
    </ul>
</div>    
@endsection