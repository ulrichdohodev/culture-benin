<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Region extends Model
{
    use HasFactory;

    protected $table = 'regions';
    protected $primaryKey = 'id_region';
    public $timestamps = true;

    protected $fillable = [
        'nom_region',
        'description',
        'population',
        'superficie',
        'localisation'
    ];

    public function contenus(): HasMany
    {
        return $this->hasMany(Contenu::class, 'id_region');
    }

    public function langues(): BelongsToMany
    {
        return $this->belongsToMany(Langue::class, 'parler', 'id_region', 'id_langue');
    }
}