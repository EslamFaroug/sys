<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Teacher;
use \App\Book;
use \App\Auth;
use \App\User;
class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {
        if($id == null)
        {
            $teachers = Teacher::all();
            $books    = Book::all();
            return view('books.index', compact('teachers','books'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tr_name          = $request->teacher_id;
        $book_title       = $request->title;
        $book_isbn        = $request->isbn;
        $book_publisher   = $request->publisher;
        $book_ed_f        = $request->f_edition;
        $book_ed_l        = $request->l_edition;

       // $file              = $request->file('book_file')->storeAS('books',time());

        $book             = new Book();

        $book->teacher_id = $tr_name;
        $book->title      = $book_title;
        $book->isbn       = $book_isbn;
        $book->publisher  = $book_publisher;
        $book->f_edition  = $book_ed_f;
        $book->l_edition  = $book_ed_l;
       // $book->book_file  = $file;
        if (request()->hasFile('file')) {
            $book->book_file= upload_file($request,'/storage/books',date("h_i_sa"),"","");
        }
        $book->save();

            return back()->with('success','data Saved Successfly');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
         $book    = Book::find($id);
        return view('books.view', compact('teachers','book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
            $teachers = Teacher::all();
            $books    = Book::find($id);
                return view('books.edit', compact('teachers','books'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

       // $file             = $request->file('book_file')->storeAS('books',time());

        $book             = Book::find($id);
        $book->teacher_id = $request->teacher_id;
        $book->title      = $request->title;
        $book->isbn       = $request->isbn;
        $book->publisher  = $request->publisher;
        $book->f_edition  = $request->f_edition;
        $book->l_edition  = $request->l_edition;
       // $book->book_file  = $request->file;
        if (request()->hasFile('file')) {
            $book->book_file = upload_file($request,'/storage/books',date("h_i_sa"),$book->book_file,"");
        }
        if($book->save()){
            return response("done");

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Book::find($id)->delete();
        return response("done");
    }
}
