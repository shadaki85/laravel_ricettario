@extends('layouts.app')

@section('title', 'Tutte le ricette')

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
</div>    
@endsection