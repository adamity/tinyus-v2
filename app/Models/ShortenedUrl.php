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

    public function getByHash($hash)
    {
        return $this->where('hash', $hash)->first();
    }

    public function hasExpired()
    {
        // Expired condition 1: max_clicks is set and the number of clicks is greater than or equal to max_clicks
        if ($this->max_clicks && $this->clicks()->count() >= $this->max_clicks) {
            return true;
        }

        // Expired condition 2: expired_at is set and the current date is greater than expired_at
        if ($this->expired_at && strtotime($this->expired_at) < strtotime(date('Y-m-d H:i:s'))) {
            return true;
        }

        return false;
    }

    public function getShortenedUrlAttribute()
    {
        return url($this->hash);
    }
}
