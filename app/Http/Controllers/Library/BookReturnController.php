<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookIssuance;
use App\Models\Student;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class BookReturnController extends Controller
{
    //
    public function scan()
    {
        return view('library.book-return.scan');
    }
    public function postScan(Request $request)
    {
        $request->validate([
            'book_ref' => 'required',
        ]);

        session([
            'book_ref' => $request->book_ref,
        ]);
        return redirect()->route('library.book-return.confirm');
    }

    // return confirm
    public function confirm()
    {
        //
        $book_issuance = '';
        if (session('book_ref')) {
            $book_ref_parts = explode('-', session('book_ref'));

            $rack_no = $book_ref_parts[0];
            $book_id = (int)$book_ref_parts[1];
            $copy_no = (int) $book_ref_parts[2];

            $book = Book::findOrFail($book_id);

            if ($book) {
                //check forgery in each fragment of book ref
                if ($rack_no != $book->rack->label || $copy_no < 1 || $copy_no > $book->num_of_copies)
                    $warning_message = "Book reference seems to be forged!";
                else {
                    // book ref correct, no forgery
                    $bookIssuance = BookIssuance::where('book_id', $book->id)
                        ->where('copy_no', $copy_no)
                        ->whereNull('return_date')->first();
                    if ($bookIssuance) {
                        return view('library.book-return.confirm', compact('bookIssuance'));
                    } else {
                        $warning_message = "Book already in rack!";
                    }
                }
            } else {
                $warning_message = "Book reference - invalid";
            }
        } else {
            $warning_message = "Book reference missing";
        }
        // if there exists warning
        return view('library.book-return.warning', compact('warning_message'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function postConfirm(Request $request, $id)
    {
        //
        $request->validate([
            'book_issuance_id' => 'required',
        ]);
        $book_issuance = BookIssuance::findOrFail($id);
        try {
            $book_issuance->return_date = date('Y/m/d');
            $book_issuance->update();
            return redirect()->route('library.book-return.scan')->with('success', 'Book has been returned successfully ');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
}
