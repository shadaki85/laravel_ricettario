@extends('layouts.app')

@section('title', 'Pagina Admin')

@section('content')
<div class="col-md-10 col-md-offset-1">
    <h1>Ciao, {{ Auth::user()->name }}. Ecco la lista di tutti gli ingredienti presenti!</h1>
    <table class="table">
        <tr>
            <th>ID</th><th>NOME</th><th>TIPO</th><th>DATA CREAZIONE</th>
        </tr>
        @foreach($ingredients as $ingredient)
            <tr>
                {!! Form::open(['url'=>['ingredient',$ingredient->id], 'method'=>'put']) !!}
                <td>{{ $ingredient->id }}</td>
                <td>{!! Form::text('name',$ingredient->name) !!}</td>
                <td>{!! Form::select('type', ['cl' => 'cl', 'gr' => 'gr', 'unita' => 'unità'],$ingredient->type);!!}</td>
                <td>{{ $ingredient->created_at }}</td>
                <td>{!! Form::submit('Modifica',['class'=>'btn btn-success']) !!}</td>
                {!! Form::close() !!}
                {!! Form::open(['url'=>['ingredient',$ingredient->id], 'method'=>'delete']) !!}
                <td>{!! Form::submit('Elimina Ingrediente',['class'=>'btn btn-danger']) !!}</td>
                {!! Form::close() !!}
            </tr>
        @endforeach
    </table> 
</div>    
@endsection