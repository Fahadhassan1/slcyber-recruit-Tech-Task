<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Book extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'books';
    protected $fillable = ['title', 'author', 'rating'];

    protected $guarded = [];

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
}
