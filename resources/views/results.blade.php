@extends('layouts.app')

@section('title', 'Risultati')

@section('content')
<div class="col-md-10 col-md-offset-1">
    <h1>Risultati ricerca: "{{$searchInput}}"</h1>
    <h3>Ricette:</h3>
    @if($recipesMatches->isEmpty() == false)
    <table class="table">
        <th>AUTORE</th><th>TITOLO</th><th>PROCEDURA</th><th>DATA INSERIMENTO</th>
         @foreach($recipesMatches as $recipe)
         <tr>
             <td>{!! $recipe->user->name !!}</td><td>{!! $recipe->title !!}</td>
             @if(strpos($recipe->procedure,$searchInput) == 21)
                 <td>{!! substr($recipe->procedure,0,45) !!}...</td>
             @else
                 <td>...{!! substr($recipe->procedure,(strpos($recipe->procedure,$searchInput)-34+strlen($searchInput)),50) !!}...</td>
             @endif
             <td>{!! $recipe->created_at !!}</td>
                <td><a class="btn btn-success" href="recipes/{{ $recipe->id }}" role="button">Mostra Ricetta</a></td>
            </tr>
         </tr>
         @endforeach
    </table>
    @else
        <i>Nessuna ricetta trovata con la parola chiave inserita</i>
    @endif
    
    <h3>Ingredienti:</h3>
    @if($ingredientsMatches->isEmpty() == false)
    <table class="table">
        <th>INGREDIENTE</th><th>TITOLO</th><th>PROCEDURA</th><th>DATA INSERIMENTO</th>
         @foreach($ingredientsMatches as $ingredient)
             @foreach($ingredient->recipes as $recipe)
             <tr>
                 <td>{!! $ingredient->name !!}</td><td>{!! $recipe->title !!}</td><td>{!! substr($recipe->procedure,0,20) !!}...</td><td>{!! $recipe->created_at !!}</td>
                    <td><a class="btn btn-success" href="recipes/{{ $recipe->id }}" role="button">Mostra Ricetta</a></td>
                </tr>
             </tr>
             @endforeach
         @endforeach
    </table>
    @else
        <i>Nessuna ricetta trovata con la parola chiave inserita</i>
    @endif
    
    <h3>Utenti:</h3>
    @if($usersMatches->isEmpty() == false )
    <table class="table">
        <th>NOME</th><th>EMAIL</th><th>RUOLO</th><th>RICETTE INSERITE</th>
        @foreach($usersMatches as $userMatch)
        <tr>
            <td>{!! $userMatch->name !!}</td>
            <td>{!! $userMatch->email !!}</td>
            <td>
                @if ($userMatch->isAdmin == 1)
                    Admin
                @else
                    Utente
                @endif
            </td>
            <td>{!! $userMatch->recipes->count() !!}</td>
        </tr>
        @endforeach
    </table>
    @else
        <i>Nessun utente trovato con la parola chiave inserita</i>
    @endif
</div>    
@endsection