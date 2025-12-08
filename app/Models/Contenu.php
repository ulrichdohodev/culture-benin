<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contenu extends Model
{
    use HasFactory;

    protected $table = 'contenus';
    protected $primaryKey = 'id_contenu';
    public $timestamps = true;

    protected $fillable = [
        'titre',
        'texte',
        'statut',
        'date_validation',
        'parent_id',
        'id_region',
        'id_langue',
        'id_type_contenu',
        'id_auteur',
        'id_moderateur'
    ];

    protected $casts = [
        'date_creation' => 'datetime',
        'date_validation' => 'datetime',
    ];

    /**
     * Relation avec la région
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'id_region', 'id_region');
    }

    /**
     * Relation avec la langue
     */
    public function langue(): BelongsTo
    {
        return $this->belongsTo(Langue::class, 'id_langue', 'id_langue');
    }

    /**
     * Relation avec le type de contenu
     */
    public function typeContenu(): BelongsTo
    {
        return $this->belongsTo(TypeContenu::class, 'id_type_contenu', 'id_type_contenu');
    }

    /**
     * Relation avec l'auteur (utilisateur)
     */
    public function auteur(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'id_auteur', 'id_utilisateur');
    }

    /**
     * Relation avec le modérateur (utilisateur)
     */
    public function moderateur(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'id_moderateur', 'id_utilisateur');
    }

    /**
     * Relation avec le contenu parent
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Contenu::class, 'parent_id', 'id_contenu');
    }

    /**
     * Relation avec les contenus enfants
     */
    public function enfants(): HasMany
    {
        return $this->hasMany(Contenu::class, 'parent_id', 'id_contenu');
    }

    /**
     * Relation avec les médias
     */
    public function medias(): HasMany
    {
        return $this->hasMany(Media::class, 'id_contenu', 'id_contenu');
    }

    /**
     * Relation avec les commentaires
     */
    public function commentaires(): HasMany
    {
        return $this->hasMany(Commentaire::class, 'id_contenu', 'id_contenu');
    }

    /**
     * Scope pour les contenus approuvés
     */
    public function scopeApprouves($query)
    {
        return $query->where('statut', 'valide');
    }

    /**
     * Scope pour les contenus en attente
     */
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    /**
     * Scope pour les contenus d'un auteur spécifique
     */
    public function scopeDeUtilisateur($query, $userId)
    {
        return $query->where('id_auteur', $userId);
    }
}