<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BookGenre extends Model
{
    use HasFactory;
    protected $table = "book_genre";
    protected $fillable = [
        'name',
    ];

    public function books():HasMany{
        return $this->hasMany(Book::class);
    }

}
