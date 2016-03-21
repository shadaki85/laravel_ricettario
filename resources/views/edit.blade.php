@extends('layouts.app')

@section('title', 'Modifica')

@section('content')
<div class="col-md-10 col-md-offset-1">
    @if(Auth::user()->id == $recipe->user_id || Auth::user()->isAdmin == 1)
        {!! Form::open(['url'=>'recipes', 'method'=>'put', 'id'=>'form', 'class'=>'form-inline']) !!}
        <div class="form-group">
            
            <h4>Titolo:</h4>
            <h1>{!! Form::text('title',$recipe->title,['id'=>'title'])!!}</h1>
            <h4>Procedura:</h4>
            {!! Form::textarea('procedure',$recipe->procedure,['class'=>'form-control pull-left','id'=>'procedure','rows'=>'20','cols'=>'80'])!!}
            <ul style="float:left;" id='selected'>
                @foreach($recipe->ingredients as $ingredient)
                    <li id="{{$ingredient->name}}" quantity="{{ $ingredient->pivot->quantity}}" type="{{ $ingredient->type }}">
                    {{ $ingredient->name}} {{ $ingredient->pivot->quantity}} {{ ucfirst($ingredient->type) }}
                    <a id="cancelButton" data-val="{{ $ingredient->name}}" class="fa fa-times cancelButton"></a>
                    </li>
                @endforeach
            </ul>
            <br />
            {!! Form::label('ingredients','Aggiungi gli ingredienti mancanti:') !!}
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
                    <a id="inviaButton" type="edit" rec_id="{{$recipe->id}}" class="btn btn-success" data-token="{!! csrf_token() !!}">Modifica</a>
                </td>
                {!! Form::open(['url'=>['recipes',$recipe->id], 'method'=>'delete']) !!}
                <td>{!! Form::submit('Elimina',['class'=>'btn btn-danger','onclick'=>'return confirm("Sei sicuro di voler cancellare la ricetta?");']) !!}</td>
                {!! Form::close() !!}
                <td>
                    <a class="btn btn-default" href="recipes" role="button">Back</a></td>
                </td>
            </tr>    
        </table>
        
            <ul id="validatorErrorList">
            
            </ul>
    @endif       
</div>        
@endsection