<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserTookBook extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $table = 'user_took_book';

    protected $fillable = [
        'taken_at',
        'books_id',
        'user_id',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, "books_id");
    }

}
