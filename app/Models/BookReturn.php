<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookReturn extends Model
{
    protected $fillable = ['book_issue_id', 'returned_at'];

    public function issue()
    {
        return $this->belongsTo(BookIssue::class, 'book_issue_id');
    }
}
