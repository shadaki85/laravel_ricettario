@extends('layouts.app')

@section('title', 'Tutte le ricette')

@section('content')
<div class="col-md-10 col-md-offset-1">
    <h1>Ciao, {{ Auth::user()->name }}. Ecco la lista di tutte le ricette!</h1>
    <table class="table">
        <tr>
            <th>AUTORE</th><th>TITOLO</th><th>PROCEDURA</th><th>DATA INSERIMENTO</th>
        </tr>
        @foreach($recipes as $recipe)
            <tr>
                <td>{{ $recipe->user->name }}</td><td>{{ $recipe->title }}</td><td>{{ substr($recipe->procedure,0,20) }}...</td><td>{{ $recipe->created_at }}</td>
                @if(Auth::user()->id == $recipe->user->id || Auth::user()->isAdmin == 1)
                    <td><a class="btn btn-danger" href="recipes/{{ $recipe->id }}/edit" role="button">Modifica</a></td>
                @else
                    <td><button class="btn btn-danger" role="button" disabled>Modifica</a></td>
                @endif
                <td><a class="btn btn-success" href="recipes/{{ $recipe->id }}" role="button">Mostra Ricetta</a></td>
            </tr>
        @endforeach
    </table>
</div>    
@endsection