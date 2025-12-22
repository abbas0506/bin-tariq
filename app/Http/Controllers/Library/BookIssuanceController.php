<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Book;
use App\Models\BookIssuance;
use App\Models\BookReturnPolicy;
use App\Models\LibraryRule;
use App\Models\Profile;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class BookIssuanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function scan()
    {
        //
        return view('library.book-issuance.scan');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function postScan(Request $request)
    {
        $request->validate([
            'book_ref' => 'required',
            'user_cnic' => 'required',
        ]);

        session([
            'book_ref' => $request->book_ref,
            'user_cnic' => $request->user_cnic,
        ]);
        return redirect()->route('library.book-issuance.confirm');
    }

    public function confirm()
    {
        //
        $book = '';
        $copy_no = '';
        $warning_message = '';
        // if request contains book_ref and student reference sent 
        if (session('book_ref') && session('user_cnic')) {
            $book_ref_parts = explode('-', session('book_ref'));

            $rack_no = $book_ref_parts[0];
            $book_id = (int)$book_ref_parts[1];
            $copy_no = $book_ref_parts[2];

            $book = Book::findOrFail($book_id);

            if ($book) {
                //check forgery in each fragment of book ref
                if ($rack_no != $book->rack->label || $copy_no < 1 || $copy_no > $book->num_of_copies)
                    $warning_message = "Boof reference seems to be forged!";
                elseif (BookIssuance::where('book_id', $book->id)->where('copy_no', $copy_no)->whereNull('return_date')->exists()) {
                    //book has already been issued
                    $warning_message = "Requested book has already been issued!";
                } else {
                    //book can be issued
                    $reader = Student::where('bform', session('user_cnic'))->first();
                    if ($reader) {
                        $readerType = 'App\Models\Student';
                        return view('library.book-issuance.confirm', compact('book', 'copy_no', 'reader', 'readerType'));
                    } else {
                        $reader = Profile::where('cnic', session('user_cnic'))->first();
                        if ($reader) {
                            $readerType = 'App\Models\Teacher';
                            return view('library.book-issuance.confirm', compact('book', 'copy_no', 'reader', 'readerType'));
                        } else {
                            $warning_message = "Reader reference - invalid";
                        }
                    }
                }
            } else {
                $warning_message = "Book reference - invalid";
            }
        } else {
            $warning_message = "Book reference or student reference missing";
        }
        // if there exists warning
        return view('library.book-issuance.warning', compact('warning_message'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function postConfirm(Request $request)
    {
        //
        $request->validate([
            'book_id' => 'required',
            'copy_no' => 'required',
            'user_id' => 'required',
            'user_type' => 'required',
        ]);
        //
        $user = User::findOrFail($request->user_id);
        $libraryRule = LibraryRule::where('user_type', $request->user_type)->first();
        $request->merge([
            'due_date' => Carbon::now()->addDays($libraryRule->max_days)->format('Y/m/d'),
        ]);
        try {
            $bookIssuance = BookIssuance::create($request->all());
            return redirect()->route('library.book-issuance.scan')->with('success', 'Book has been issued successfully ');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /* books that have been issued
    *  but have not been returned
    */
    public function  issued()
    {
        $bookIssuances = BookIssuance::whereNull('return_date')->get();
        return view('library.book-issuance.issued', compact('bookIssuances'));
    }
    /* books that have been issued
    *  due time has been over
    */
    public function  delayed()
    {
        $bookIssuances = BookIssuance::whereNull('return_date')->where('due_date', '<', today())->get();
        return view('library.book-issuance.delayed', compact('bookIssuances'));
    }
    /* defaulters list
    *  due time has been over
    */
    public function  default()
    {
        $defaulters_array = BookIssuance::whereNull('return_date')->where('due_date', '<', today())->pluck('user_id')->toArray();
        $defaulters = User::whereIn('id', $defaulters_array)->get();
        return view('library.book-issuance.defaulters', compact('defaulters'));
    }
}
