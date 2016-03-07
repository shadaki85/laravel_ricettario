@extends('layouts.app')

@section('title', 'Pagina Admin')

@section('content')
<div class="col-md-10 col-md-offset-1">
    <h1>Ciao, {{ Auth::user()->name }}. Sei nella tua pagina Admin!</h1>
    <h3>Ecco la lista di tutti gli utenti:</h3>
    <table class="table">
        <tr>
            <th>ID</th><th>USER</th><th>EMAIL</th><th>DATA CREAZIONE</th><th>NUMERO RICETTE</th><th>PERMESSI</th>
        </tr>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td><td>{{ $user->name }}</td><td>{{ $user->email }}</td><td>{{ $user->created_at }}</td><td>{{ $user->recipes->count() }}</td>
                <td>
                    @if ($user->isAdmin == 1)
                        Admin
                    @else
                        Utente
                    @endif
                </td>
                @if ($user->id != Auth::user()->id)
                {!! Form::open(['url'=>['user',$user->id], 'method'=>'delete']) !!}
                <td>{!! Form::submit('Elimina Utente',['class'=>'btn btn-danger','onclick'=>'return confirm("Sei sicuro di voler cancellare l\'utente?");']) !!}</td>
                {!! Form::close() !!}
                {!! Form::open(['url'=>['user',$user->id], 'method'=>'put']) !!}
                <td>{!! Form::submit('Modifica Permessi',['class'=>'btn btn-success']) !!}</td>
                {!! Form::close() !!}
                @else
                <td><button class="btn btn-danger" disabled>Elimina Utente</button></td>
                <td><button class="btn btn-success" disabled>Modifica Permessi</button></td>
                @endif
            </tr>
        @endforeach
    </table> 
</div>    
@endsection