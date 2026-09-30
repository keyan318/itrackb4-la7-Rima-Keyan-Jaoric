<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MovieController extends Controller
{

  private function getItems()
{
    return json_decode(file_get_contents(storage_path('app/movies.json')), true);
}

private function saveMovies($all)
{
    file_put_contents(storage_path('app/movies.json'), 
    json_encode($all, JSON_PRETTY_PRINT));
}

    public function index(Request $request)
{
    $genre = $request->query('genre', '');
    $year  = $request->query('year', '');

    $allItems = $this->getItems();
    $items = [];

    foreach ($allItems as $item) {
        if ($genre !== '' && $item['genre'] !== $genre) {
            continue;
        }
        if ($year !== '' && (string)$item['year'] !== $year) {
            continue;
        }
        $items[] = $item;
    }

    return view('movies.index', [
        'items' => $items,
        'genre' => $genre,
        'year'  => $year,
    ]);
}



    public function create()
    {
        return view('movies.create');
    }


    public function store(Request $request)
    {
        $validated=$request->validate([
            'title' =>'required|string|min:10|max:100',
            'genre' =>'required|in:Action,Science Fiction,Superhero',
            'year' =>'required|integer|min:1888|max:2100',
            'director'=>['required','string','min:10','max:100','regex:/^[A-Za-z .,\'-]+$/'],
            'rating'=>'required|numeric|min:0|max:10',
            'duration'=>['required','regex:/^\d{1,2}h\s?\d{1,2}m$/'],
        ],[
            'title.min' =>'The title must be at least 10 characters.',
            'title.max' =>'The title must not be longer than 100 characters.',
            'director.min' =>'The director must be at least 10 characters.',
            'director.regex' =>'The director may only contain letters, spaces, periods, commas, apostrophes and hyphens.',
            'duration.regex' =>'The duration must look like 2h 28m.',
        ]);

        $validated['year']=(int)$validated['year'];
        $validated['rating']=(float)$validated['rating'];

        $all=$this->getItems();
        $nextId=$all ? max(array_keys($all))+1 : 1;
        $validated['id']=$nextId;
        $all[$nextId]=$validated;
        $this->saveMovies($all);

        return redirect()
        ->route('movies.index')
        ->with('success', 'Movie added successfully.');
    }


    public function show(string $id)
    {
       $items=$this->getItems();

       if(!isset($items[$id])){
        abort(404);
       }
       return view('movies.show', ['item'=>$items[$id]]);
    }


    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function featured(){
        $items=$this->getItems();
        return view('movies.show',  ['item'=>$items[1]]);
    }
    
}

