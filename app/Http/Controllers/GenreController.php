<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\Book;
class GenreController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:genres,name']);

        $genre = Genre::create($request->only('name'));

        return response()->json([
            'message' => 'Genre created successfully.',
            'data' => $genre],
            201);
    }

    public function attachGenres(Request $request, Book $book)
    {
        $request->validate(['genre_ids' => 'required|array']);

        $book->genres()->syncWithoutDetaching($request->genre_ids);

        return response()->json(['message' => 'Genres attached to the book successfully.']);
    }
}
