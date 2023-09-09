<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShortenedUrl extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'hash',
        'max_clicks',
        'expired_at',
    ];

    protected $appends = [
        'shortened_url',
    ];

    public function urls()
    {
        return $this->hasMany(OriginalUrl::class);
    }

    public function clicks()
    {
        return $this->hasMany(Click::class);
    }

    public function getShortenedUrlAttribute()
    {
        return url($this->hash);
    }
}
