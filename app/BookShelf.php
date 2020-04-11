<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookShelf extends Model
{
    protected $table = 'bookshelf';

    protected $hidden = ['pivot'];
    
    /**
     * The book that belong to the bookshelf.
     */
    public function book()
    {
        return $this->belongsToMany('App\Book', 'book_bookshelves', 'bookshelf_id', 'book_id');
    }

}
