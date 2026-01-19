<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;


class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $fillable = [
        'url',
        'type',
        'alt_text',
        'caption',
        'filename_original',
        'size_kb',
        'status',
        'meta',
        'uploaded_by_user_id',
    ];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

}