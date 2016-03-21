@extends('layouts.app')

@section('title', 'Inserisci nuova Ricetta')

@section('content')
<div class="col-md-10 col-md-offset-1">
    <h1>Ciao {{ Auth::user()->name }}, aggiungi una ricetta!</h1>
        {!! Form::open(['url'=>'recipes', 'method'=>'post', 'id'=>'form', 'class'=>'form-inline']) !!}
        <div class="form-group">
            {!! Form::text('title',null,['class'=>'form-control','placeholder'=>'Titolo','id'=>'title']) !!}<br />
            {!! Form::textarea('procedure',null,['class'=>'form-control pull-left','placeholder'=>'Procedura','id'=>'procedure','rows'=>'20','cols'=>'80']) !!}
            <ul style="float:left;" id='selected'></ul>
            <br />
            {!! Form::label('ingredients','Seleziona gli ingredienti necessari:') !!}
            <br />
            {!! Form::select('ingredients', [],null,['placeholder'=>'Seleziona...','class'=>'form-control','id'=>'ingredients']) !!}
            {!! Form::text('ingrQuantity',null,['class'=>'form-control', 'id'=>'ingrQuantity','placeholder'=>'Quantità']) !!}
            {!! Form::select('type', ['gr'=>'gr','cl'=>'cl','unità'=>'unità'],null,['class'=>'form-control','id'=>'type']) !!}
            <br />
            {!! Form::button('Aggiungi',['class'=>'btn btn-default','id'=>'selectIngredientButton']) !!}
            <br />
            <p id='already'></p>
            {!! Form::label('newingredient','Non trovi gli ingredienti necessari? Aggiungili tu:') !!}
            <br />
            {!! Form::text('newingredient',null,['class'=>'form-control', 'id'=>'newingredient']) !!}
            {!! Form::text('newIngrQuantity',null,['class'=>'form-control', 'id'=>'newIngrQuantity','placeholder'=>'Quantità']) !!}
            {!! Form::select('type', ['gr'=>'gr','cl'=>'cl','unità'=>'unità'],null,['class'=>'form-control','id'=>'typeNew']) !!}
            <br />
            {!! Form::button('Aggiungi',['class'=>'btn btn-default','id'=>'newIngredientButton']) !!}
            <p id='already2'></p>
        </div>
        <div style="height:20px;"></div>
        <table>
            <tr>
                <td>
                    {!! Form::close() !!}
                    <a id="inviaButton" type="new" class="btn btn-success" data-token="{!! csrf_token() !!}">Invia</a>
                </td>
                <td>
                    <a class="btn btn-danger" href="recipes" role="button">Back</a></td>
                </td>
            </tr>    
        </table>
        
            <ul id="validatorErrorList">
            
            </ul>
       
</div>        
@endsection