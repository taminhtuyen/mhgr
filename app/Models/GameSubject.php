<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class GameSubject extends Model
{
    use HasFactory;

    protected $table = 'game_subjects';

    protected $fillable = [
        'name',
        'slug',
        'icon_url',
        'is_active',
        'position',
    ];

}