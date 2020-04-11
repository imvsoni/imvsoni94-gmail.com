<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subject';

    protected $hidden = ['pivot'];
    /**
     * The book that belong to the subject.
     */
    public function book()
    {
        return $this->belongsToMany('App\Book', 'book_subjects', 'subject_id', 'book_id');
    }

}
