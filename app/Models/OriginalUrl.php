<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OriginalUrl extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'shortened_url_id',
        'url',
    ];

    public function shortened_url()
    {
        return $this->belongsTo(ShortenedUrl::class);
    }
}
