<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookGenre;
use App\Models\UserTookBook;
use App\Rules\AllowedNameTitles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Database\Eloquent\Builder;

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
        $model = $model->where('is_taken', false);

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
            array_push($bookGenreArray, $array);
        }

        return Inertia::render('BrowseBooks', [

            "page_number" => $receivedPageNumber,
            "total_pages" => $totalPages,
            'data' => $templateArray,
            'book_genres' => $bookGenreArray
        ]);
    }
    public function retrieveBorrowedBooks(Request $request)
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
        $model = new UserTookBook();
        $query = $model::query();
        $user = Auth::getUser();
        $userId = $user->id;
         
        $query->where('user_id',$userId);

        if ($isTitleReceived) {
            $searchTitle = $request->search_title;
            // $model = $query->where('title', 'like', '%' . $searchTitle . '%');
            $query->whereHas('book', function ($query) use ($searchTitle) {
                $query->where('title', 'like', '%' . $searchTitle . '%');
            });
        }
        if ($isDescriptionReceived) {
            $searchDescription = $request->search_description;
            // $model = $model->where('description', 'like', '%' . $searchDescription . '%');
            $query->whereHas('book', function ($query) use ($searchDescription) {
                $query->where('description', 'like', '%' . $searchDescription . '%');
            });
        }
        if ($isGenreReceived) {
            $genreName = $request->search_genre;
            $genreId = BookGenre::where('name', $genreName)->first()->id;
            $query->whereHas('book', function ($query) use ($genreId) {
                $query->where('book_genre_id', $genreId);
            });
        }
        // order by
        $query->whereHas('book', function ($query) {
            $query->orderBy("title");
        });
        $paginator = $query->paginate($this->itemsPerPage);
        $totalPages = $paginator->lastPage();
        $items = $paginator->items();

        $templateArray = [];

        foreach ($items as $item) {
            $array = [
                "id" => $item->book->generated_id,
                'book_genre' => $item->book->bookGenre->name,
                'title' => $item->book->title,
                'description' => $item->book->description,
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
            array_push($bookGenreArray, $array);
        }

        return Inertia::render('UserBooks', [

            "page_number" => $receivedPageNumber,
            "total_pages" => $totalPages,
            'data' => $templateArray,
            'book_genres' => $bookGenreArray
        ]);
    }
}
