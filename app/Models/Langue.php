<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Langue extends Model
{
    use HasFactory;

    protected $table = 'langues';
    protected $primaryKey = 'id_langue';
    
    protected $fillable = [
        'nom_langue',
        'code_langue',
        'description'
    ];

    // Relation avec la table parler (si elle existe)
    public function parler()
    {
        return $this->hasMany(Parler::class, 'id_langue');
    }

    // Ou si vous avez une relation directe avec les régions
    public function regions()
    {
        return $this->belongsToMany(Region::class, 'parler', 'id_langue', 'id_region');
    }

    // Relation avec les contenus (si elle existe)
    public function contenus()
    {
        return $this->hasMany(Contenu::class, 'id_langue');
    }
}