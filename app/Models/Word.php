<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Word extends Model
{
    use HasFactory;

    protected $fillable = [
        'english',
        'japanese',
        'memo'
    ];

    public function Book()
    {
        return $this->belongsTo(Book::class);
    }
}
