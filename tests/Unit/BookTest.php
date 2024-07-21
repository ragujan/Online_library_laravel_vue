<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\BookGenre;
use Log;
use Tests\TestCase;


class BookTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_book_insert(): void
    {
        $book = Book::create([
            "title" => "test1",
            "description" => "description1",
            "generated_id" => "1111",
            "is_taken" => false,
            "book_genre_id" => 1

        ]);
        $this->assertEquals("test1", $book->title);
        $this->assertEquals("description1", $book->description);
        $this->assertEquals("1111", $book->generated_id);
        $this->assertFalse($book->is_taken, false);
        $this->assertEquals(1, $book->book_genre_id);

        // after insertion just delete the row
        $book->delete();

        // book deletion confirmation
        $this->assertNull(Book::find($book->id));
    }
    public function test_insert_book_genre(): void
    {
        $bookGenre = BookGenre::create([
            'name' => "test1"
        ]);
        $this->assertEquals("test1", $bookGenre->name);

        // after insertion just delete the row
        $bookGenre->delete();

        // book genre deletion confirmation
        $this->assertNull(BookGenre::find($bookGenre->id));
    }
    public function test_book_retrieval()
    {
        $request = ["search_genre" => "Fiction", "page" => 1];
        $receivedPageNumber = 1;

        $isTitleReceived = false;
        $isDescriptionReceived = false;
        $isGenreReceived = false;


        // $isTitleReceived = true;
        // $isDescriptionReceived = true;
        $isGenreReceived = true;

        $model = new Book();

        if ($isTitleReceived) {
            $searchTitle = $request["search_title"];
            $model = $model->where('title', 'like', '%' . $searchTitle . '%');
        }
        if ($isDescriptionReceived) {
            $searchDescription = $request["search_description"];
            $model = $model->where('description', 'like', '%' . $searchDescription . '%');
        }
        if ($isGenreReceived) {
            $genreName = $request["search_genre"];
            $genreId = BookGenre::where('name', $genreName)->first()->id;
            $model = $model->where('book_genre_id', $genreId);
        }
        $paginator = $model->orderBy("title")->paginate(20);
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
        $this->assertEquals(4, count($templateArray));
    }
}