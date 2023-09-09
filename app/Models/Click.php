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
        'user_agent',
    ];

    public function shortened_url()
    {
        return $this->belongsTo(ShortenedUrl::class);
    }
}
