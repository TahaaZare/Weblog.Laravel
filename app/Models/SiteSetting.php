<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'keywords',
        'author',
        'icon'
    ];
    protected function casts(): array
    {
        return [
            'keywords' => 'json',
        ];
    }
}
