<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    use UsesUuid;

    protected $table = 'books';

    protected $fillable = [
        'author_id',
        'isbn',
        'title',
        'price'
    ];

    /**
     * The categories that belong to the book
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_category');
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
