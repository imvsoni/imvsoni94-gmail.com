<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    protected $table = 'format';
    
    /**
     * The format that belong to the book.
     */
    public function book()
    {
        return $this->belongsTo('App\Book');
    }

}
