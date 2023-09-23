<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Click extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'shortened_url_id',
        'ip_address',
        'referrer',
        'operating_system',
        'operating_system_version',
        'browser',
        'browser_version',
        'is_mobile',
        'is_tablet',
        'is_desktop',
        'is_phone',
        'country',
        'city',
        'region',
        'is_expired'
    ];

    public function shortened_url()
    {
        return $this->belongsTo(ShortenedUrl::class);
    }
}
