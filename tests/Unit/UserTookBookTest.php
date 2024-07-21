<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\BookGenre;
use App\Models\User;
use App\Models\UserTookBook;
use Carbon\Carbon;
use Log;
use Tests\TestCase;


class UserTookBookTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_has_a_book(): void
    {
        $user = User::where('id', 1)->first();
        $email = $user->email;
        $this->assertEquals("rag@gmail.com", $email);

        $book = Book::where('id', 7)->first();
        $bookId = $book->id;
        $userId = $user->id;
        $createdAt = Carbon::now()->format('Y-m-d H:i:s');

        // create a new record
        $userHasBookEntry = UserTookBook::create([
            'books_id' => $bookId,
            "user_id" => $userId,
            "taken_id" => $createdAt
        ]);

        $userHasBooks = $user->userTookBook;

        $bookArray = [];
        foreach ($userHasBooks as $userHasBook) {
            $bookId = $userHasBook->books_id;
            array_push($bookArray, $bookId);
        }

        $firstBookId = $bookArray[0];
        $this->assertEquals($userHasBookEntry->books_id, $firstBookId);

        // delete the entry
        $userHasBookEntry->delete();
        // make the entry is deleted
        $this->assertNull(UserTookBook::find($userHasBookEntry->id));
    }

}