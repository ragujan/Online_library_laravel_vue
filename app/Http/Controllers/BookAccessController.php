<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookGenre;
use App\Rules\AllowedNameTitles;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookAccessController extends Controller
{
    private $itemsPerPage = 3;

    public function retrieveBooks(Request $request)
    {


        $receivedPageNumber = $request->page;
        if ($request->page != null && $request->page != "") {
            $receivedPageNumber = $request->page;
            $request->validate([
                'page' => ['numeric'],
            ]);

        } else {
            $receivedPageNumber = 1;
        }
        $isTitleReceived = false;
        $isDescriptionReceived = false;
        $isGenreReceived = false;

        // check if the values are received
        if (isset($request->search_title) && $request->search_title != "") {
            $request->validate([
                'search_title' => [new AllowedNameTitles(), 'string'],
            ]);
            $isTitleReceived = true;
        }

        if (isset($request->search_description) && $request->search_description != "") {
            $request->validate([
                'search_description' => [new AllowedNameTitles(), 'string'],
            ]);
            $isDescriptionReceived = true;
        }

        if (isset($request->search_genre) && $request->search_genre != "") {
            $request->validate([
                'search_genre' => ['exists:book_genre,name'],
            ]);
            $isGenreReceived = true;
        }
        $model = new Book();

        if ($isTitleReceived) {
            $searchTitle = $request->search_title;
            $model = $model->where('title', 'like', '%' . $searchTitle . '%');
        }
        if ($isDescriptionReceived) {
            $searchDescription = $request->search_description;
            $model = $model->where('description', 'like', '%' . $searchDescription . '%');
        }
        if ($isGenreReceived) {
            $genreName = $request->search_genre;
            $genreId = BookGenre::where('name', $genreName)->first()->id;
            $model = $model->where('book_genre_id', $genreId);
        }
        $paginator = $model->orderBy("title")->paginate($this->itemsPerPage);
        $totalPages = $paginator->lastPage();
        $items = $paginator->items();

        $templateArray = [];

        foreach ($items as $item) {
            $array = [
                "id" => $item->generated_id,
                'book_genre' => $item->bookGenre->name,
                'title' => $item->title,
                'description' => $item->description,
            ];
            array_push($templateArray, $array);
        }

        $bookGenres = BookGenre::get();
        $bookGenreArray = [];

        foreach ($bookGenres as $genre) {
            $array = [
                "id" => $genre->id,
                'name' => $genre->name,
            ];
            array_push($bookGenreArray,$array);
        }

        return Inertia::render('Home', [

            "page_number" => $receivedPageNumber,
            "total_pages" => $totalPages,
            'data' => $templateArray,
            'book_genres'=>$bookGenreArray
        ]);
    }

}
