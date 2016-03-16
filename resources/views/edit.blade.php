@extends('layouts.app')

@section('title', 'Modifica')

@section('content')
<div class="col-md-10 col-md-offset-1">
    @if(Auth::user()->id == $recipe->user_id || Auth::user()->isAdmin == 1)
                {!! Form::open(['url'=>['recipes',$recipe->id],'class'=>'form-inline','method'=>'put']) !!}
                <h1>{!! Form::text('title',$recipe->title)!!}</h1>
                <h3>Ingredienti:</h3>
                <ul>
                <?php $i=1; ?>
                @foreach($recipe->ingredients as $ingredient)
                    <li>
                    {!! Form::text('name'.$i,$ingredient->name)!!}
                    {!! Form::text('quantity'.$i,$ingredient->pivot->quantity)!!}
                    {{ ucfirst($ingredient->type) }}
                    </li>
                    <?php $i++; ?>
                @endforeach
                </ul>
        <table>
            <tr> 
                <h3>Procedura:</h3>
                {!! Form::textarea('procedure',$recipe->procedure,['rows'=>'20','cols'=>'100'])!!}
                <td>{!! Form::submit('Modifica',['class'=>'btn btn-success']) !!}</td>
                {!! Form::close() !!}
                
                {!! Form::open(['url'=>['recipes',$recipe->id], 'method'=>'delete']) !!}
                <td>{!! Form::submit('Elimina',['class'=>'btn btn-danger','onclick'=>'return confirm("Sei sicuro di voler cancellare la ricetta?");']) !!}</td>
                {!! Form::close() !!}
            </tr>
        </table>
    @endif
</div>    
@endsection