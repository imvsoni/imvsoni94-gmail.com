<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $table = 'author';

    protected $hidden = ['pivot'];

    /**
     * The book that belong to the author.
     */
    public function book()
    {
        return $this->belongsToMany('App\Book', 'book_authors', 'author_id', 'book_id');
    }

}


