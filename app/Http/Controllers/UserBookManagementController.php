<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\UserTookBook;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBookManagementController extends Controller
{
    public function borrowBookToUser(Request $request)
    {

        // book id shouldn't be there in the user took book table
        $request->validate([
            'book_id' => 'required|exists:book,generated_id'
        ]);

        $user = Auth::getUser();
        $userId = $user->id;
        $generatedId = $request->book_id;
        $book = Book::where('generated_id', $generatedId)->first();
        $bookid = $book->id;
        $createdAt = Carbon::now()->format('Y-m-d H:i:s');

        // check if the book id exists in the user took book table
        $isInUserTookBook = UserTookBook::where('books_id', $bookid)->exists();
        if ($isInUserTookBook || $book->is_taken) {
            return "error" . $book->is_taken . " book in user took table " . $isInUserTookBook . " generated id " . $generatedId;
            // return redirect()->back()->withErrors(["common_error" => "book already has been taken"], "book_error");
        }
        // create a new record
        $userHasBookEntry = UserTookBook::create([
            'books_id' => $bookid,
            "user_id" => $userId,
            "taken_at" => $createdAt
        ]);
        // update the book status
        $book->is_taken = true;
        $book->save();

        $userName = $user->name;
        return redirect()->back()->with('message', ['message_id' => "user_borrowed_book_success", 'success' => 'The book has been borrowed by user ' . $userName]);

    }


    public function returnBook(Request $request)
    {

        //  return "ok";
        // book id shouldn't be there in the user took book table
        $request->validate([
            'book_id' => 'required|exists:book,generated_id'
        ]);

        $user = Auth::getUser();
        $userId = $user->id;
        $generatedId = $request->book_id;
        $book = Book::where('generated_id', $generatedId)->first();
        $bookid = $book->id;

        // check if the book id exists in the user took book table
        $isInUserTookBook = UserTookBook::where('books_id', $bookid)->exists();
        if (!$isInUserTookBook) {
            return redirect()->back()->withErrors(["common_error" => "book not in the user account"], "book_error");
        }
        $userBook = UserTookBook::where('books_id', $bookid)->where('user_id', $userId)->first();
        // delete record from the user took book table
        $userBook->delete();

        // update the book status
        $book->is_taken = false;
        $book->save();

        $userName = $user->name;
        return redirect()->back()->with('message', ['message_id' => "user_returned_book_success", 'success' => 'The book has been returned by user ' . $userName]);

    }
}
