@extends('layouts.app')

@section('title', 'Modifica')

@section('content')
<div class="col-md-10 col-md-offset-1">
    <h1>{{ $recipe->title }}</h1>
    <h5>Ingredienti:</h5>
    <ul>
        @foreach($recipe->ingredients as $ingredient)
        <li>{{ ucfirst($ingredient->name) }} - {{$ingredient->pivot->quantity}} {{ ucfirst($ingredient->type) }}</li>
        @endforeach
    </ul> 
    <p>{{ $recipe->procedure }}</p>
    @if(Auth::user()->id == $recipe->user || Auth::user()->isAdmin == 1)
        <table>
            <tr>
                {!! Form::open(['url'=>['recipes',$recipe->id], 'method'=>'put']) !!}
                <td>{!! Form::submit('Modifica',['class'=>'btn btn-danger']) !!}</td>
                {!! Form::close() !!}
                
                {!! Form::open(['url'=>['recipes',$recipe->id], 'method'=>'delete']) !!}
                <td>{!! Form::submit('Elimina',['class'=>'btn btn-danger','onclick'=>'return confirm("Sei sicuro di voler cancellare la ricetta?");']) !!}</td>
                {!! Form::close() !!}
            </tr>
        </table>
    @endif
</div>    
@endsection
@section('scripts')
    <script src="../../resources/js/scripts.js"></script>
@endsection