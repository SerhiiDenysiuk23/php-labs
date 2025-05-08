<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookIssue extends Model
{
    protected $fillable = ['book_id', 'reader_id', 'issued_at'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function reader()
    {
        return $this->belongsTo(Reader::class);
    }

    public function return()
    {
        return $this->hasOne(BookReturn::class);
    }
}
