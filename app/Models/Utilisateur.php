<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Utilisateur extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'utilisateurs';
    protected $primaryKey = 'id_utilisateur';
    public $timestamps = true;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'mot_de_passe',
        'sexe',
        'date_naissance',
        'statut',
        'photo',
        'id_role',
        'id_langue'
    ];

    protected $hidden = [
        'mot_de_passe',
        'remember_token',
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'date_inscription' => 'datetime',
        'email_verified_at' => 'datetime',
        'mot_de_passe' => 'hashed',
    ];

    // Important: Spécifier le champ du mot de passe
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'id_role');
    }

    public function langue(): BelongsTo
    {
        return $this->belongsTo(Langue::class, 'id_langue');
    }

    public function contenus(): HasMany
    {
        return $this->hasMany(Contenu::class, 'id_auteur', 'id_utilisateur');
    }

    public function contenusModeres(): HasMany
    {
        return $this->hasMany(Contenu::class, 'id_moderateur');
    }

    public function commentaires(): HasMany
    {
        return $this->hasMany(Commentaire::class, 'id_utilisateur');
    }

    // Vérifier si l'utilisateur est administrateur
    public function isAdmin()
    {
        if ($this->relationLoaded('role') || $this->role) {
            $name = strtolower($this->role->nom_role ?? '');
            return in_array($name, ['administrateur', 'admin']);
        }

        return $this->id_role === 1; // fallback numérique
    }

    // Vérifier si l'utilisateur est modérateur
    public function isModerator()
    {
        if ($this->relationLoaded('role') || $this->role) {
            $name = strtolower($this->role->nom_role ?? '');
            return in_array($name, ['modérateur', 'moderateur', 'moderator']);
        }

        return $this->id_role === 2; // fallback numérique
    }

    // Vérifier si l'utilisateur est contributeur
    public function isContributor()
    {
        if ($this->relationLoaded('role') || $this->role) {
            $name = strtolower($this->role->nom_role ?? '');
            return in_array($name, ['contributeur', 'contributor']);
        }

        return $this->id_role === 3; // fallback numérique
    }

    // Vérifier si l'utilisateur est utilisateur standard
    public function isUser()
    {
        if ($this->relationLoaded('role') || $this->role) {
            $name = strtolower($this->role->nom_role ?? '');
            return in_array($name, ['utilisateur', 'user']);
        }

        return $this->id_role === 4; // fallback numérique
    }

    // Vérifier les permissions
    public function canManageUsers()
    {
        return $this->isAdmin();
    }

    public function canModerateContent()
    {
        return $this->isAdmin() || $this->isModerator();
    }

    public function canCreateContent()
    {
        return $this->isAdmin() || $this->isModerator() || $this->isContributor();
    }

    // Méthode pour le middleware role
    public function hasRole($role)
    {
        $roles = is_array($role) ? $role : array_map('trim', explode(',', $role));

        // If role relation exists, compare by role name (more reliable)
        $currentRoleName = null;
        if ($this->relationLoaded('role') || $this->role) {
            $currentRoleName = strtolower($this->role->nom_role ?? '');
        }

        foreach ($roles as $r) {
            $r = strtolower(trim($r));

            // allow numeric ids
            if (is_numeric($r) && (int)$r === (int)$this->id_role) {
                return true;
            }

            // map common tokens to expected role names
            $map = [
                'admin' => ['administrateur', 'admin'],
                'administrator' => ['administrateur', 'admin'],
                'moderator' => ['modérateur', 'moderateur', 'moderator'],
                'contributor' => ['contributeur', 'contributor'],
                'user' => ['utilisateur', 'user'],
            ];

            if (isset($map[$r])) {
                if ($currentRoleName && in_array($currentRoleName, $map[$r])) {
                    return true;
                }
            }

            // direct name comparison (allow French role names)
            if ($currentRoleName && $r === $currentRoleName) {
                return true;
            }
        }

        return false;
    }
}