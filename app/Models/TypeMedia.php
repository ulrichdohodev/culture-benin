<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeMedia extends Model
{
    use HasFactory;

    protected $table = 'type_media';
    protected $primaryKey = 'id_type_media';
    public $timestamps = true;

    protected $fillable = [
        'nom_type_media',
        'description'
    ];

    public function media(): HasMany
    {
        return $this->hasMany(Media::class, 'id_type_media');
    }

    /**
     * Alias pluriel attendu par withCount('medias')
     */
    public function medias(): HasMany
    {
        return $this->hasMany(Media::class, 'id_type_media');
    }
}