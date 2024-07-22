<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrlShortener extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'original_url',
        'shortened_url',
    ];

    /**
     * Scope a query to check url shorten code.
     */
    public function scopeWhereShorten(Builder $query, string $shortenUrl): void
    {
        $query->where('shortened_url', $shortenUrl);
    }
}
