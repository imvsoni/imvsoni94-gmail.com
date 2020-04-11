<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{	
    protected $table = 'book';

    /**
     * The author that belong to the book.
     */
    public function author()
    {
        return $this->belongsToMany('App\Author', 'book_authors', 'book_id', 'author_id');
    }

    /**
     * The language that belong to the book.
     */
    public function language()
    {
        return $this->belongsToMany('App\Language', 'book_languages', 'book_id', 'language_id')->select('code');
    }

    /**
     * The subject that belong to the book.
     */
    public function subject()
    {
        return $this->belongsToMany('App\Subject', 'book_subjects', 'book_id', 'subject_id');
    }

    /**
     * The bookshelf that belong to the book.
     */
    public function bookshelf()
    {
        return $this->belongsToMany('App\BookShelf', 'book_bookshelves', 'book_id', 'bookshelf_id');
    }

    /**
     * The format that belong to the book.
     */
    public function format()
    {
        return $this->hasMany('App\Format');
    }
}


