@extends('layouts.app')

@section('title', 'Inserisci nuova Ricetta')

@section('content')
<div class="col-md-10 col-md-offset-1">
    <h1>Ciao {{ Auth::user()->name }}, aggiungi una ricetta!</h1>
        {!! Form::open(['url'=>'recipes', 'method'=>'post', 'id'=>'form']) !!}
        <div class="form-group">
            {!! Form::label('title','Titolo') !!}
            {!! Form::text('title',null,['class'=>'form-control','placeholder'=>'Titolo']) !!}
            {!! Form::label('procedure','Procedura') !!}
            {!! Form::textarea('procedure',null,['class'=>'form-control','placeholder'=>'Procedura']) !!}
            {!! Form::label('ingredients','Seleziona gli ingredienti necessari:') !!}
            <div id='selected'></div>
            {!! Form::select('ingredients', [],null,['placeholder'=>'Seleziona...','class'=>'form-control','id'=>'ingredients']) !!}
            {!! Form::button('Seleziona',['class'=>'btn btn-default','id'=>'selectIngredient']) !!}
            <br />
            {!! Form::label('newingredient','Non trovi gli ingredienti necessari? Aggiungili tu:') !!}
            {!! Form::text('newingredient',null,['class'=>'form-control', 'id'=>'newingredient']) !!}
            <p id='already'></p>
            {!! Form::button('Inserisci',['class'=>'btn btn-default','id'=>'newIngredientButton']) !!}
        </div>
        <table>
            <tr>
                <td>
                    {!! Form::submit('Invia',['class'=>'btn btn-success','data-token'=> csrf_token()]) !!}
                    {!! Form::close() !!}
                </td>
                <td>
                    <a class="btn btn-danger" href="../article" role="button">Back</a></td>
                </td>
            </tr>    
        </table>
        
        @if($errors->any())
            <ul class="alert alert-danger">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
</div>        
@endsection