<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contenu;

class Media extends Model
{
    use HasFactory;

    protected $table = 'media';
    protected $primaryKey = 'id_media';

    protected $fillable = [
        'chemin', 'description', 'id_contenu', 'id_type_media'
    ];

    public function contenu()
    {
        return $this->belongsTo(Contenu::class, 'id_contenu', 'id_contenu');
    }

    public function type()
    {
        return $this->belongsTo(TypeMedia::class, 'id_type_media', 'id_type_media');
    }

    /**
     * Backwards-compatible alias expected by controllers/views
     */
    public function typeMedia()
    {
        return $this->type();
    }
}
