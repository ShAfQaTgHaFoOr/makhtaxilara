<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourPackage extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /** Trip legs as a clean array (one per line, blanks removed). */
    public function tripLines(): array
    {
        return array_values(array_filter(array_map(
            'trim',
            preg_split('/\r\n|\r|\n/', (string) $this->trips)
        ), fn ($line) => $line !== ''));
    }
}
