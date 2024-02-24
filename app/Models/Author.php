<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    use UsesUuid;

    protected $table = 'authors';

    protected $fillable = [
        'firstname',
        'surname',
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
