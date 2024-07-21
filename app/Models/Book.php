<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{    public $timestamps = false;
    use HasFactory;
    protected $table = "book";
    protected $fillable = [
        'generated_id',
        'title',
        'description',
        'book_genre_id',
        'is_taken'
    ];

    public function bookGenre():BelongsTo{
        return $this->belongsTo(BookGenre::class,"book_genre_id");
    }

}
