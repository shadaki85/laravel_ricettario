@extends('layouts.app')

@section('title', 'Pagina Admin')

@section('content')
<div class="col-md-10 col-md-offset-1">
    <h1>Ciao, {{ Auth::user()->name }}. Sei nella tua pagina Admin!</h1>
    <h3>Eccol la lista di tutti gli utenti:</h3>
    <table class="table">
        <tr>
            <th>ID</th><th>USER</th><th>DATA CREAZIONE</th><th>NUMERO RICETTE</th><th>PERMESSI</th>
        </tr>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td><td>{{ $user->name }}</td><td>{{ $user->created_at }}</td><td>{{ $user->recipes->count() }}</td>
                <td>
                    @if ($user->isAdmin == 1)
                        Admin
                    @else
                        Utente
                    @endif
                </td>
                <td><a class="btn btn-danger" href="users/{{ $user->id }}" role="button">Elimina Utente</a></td>
                <td><a class="btn btn-success" href="users/{{ $user->id }}" role="button">Modifica Permessi</a></td>
            </tr>
        @endforeach
    </table> 
</div>    
@endsection