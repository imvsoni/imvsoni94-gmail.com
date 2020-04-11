<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'language';
    
    protected $hidden = ['pivot'];

    /**
     * The book that belong to the language.
     */
    public function book()
    {
        return $this->belongsToMany('App\Book', 'book_languages', 'language_id', 'book_id');
    }

}
