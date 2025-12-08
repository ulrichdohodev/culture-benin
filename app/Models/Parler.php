<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Parler extends Model
{
    use HasFactory;

    protected $table = 'parler';
    public $timestamps = true;

    protected $fillable = [
        'id_region',
        'id_langue'
    ];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'id_region');
    }

    public function langue(): BelongsTo
    {
        return $this->belongsTo(Langue::class, 'id_langue');
    }
}