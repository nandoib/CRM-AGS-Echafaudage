<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'nom',
            'prenom',
            'adresse',
            'telephone',
            'commentaire',
            'source',
            'temperature',
            'id_user_dest',
            'id_user_exp'
    ];
    
    protected $dates = [
        'created_at',
        'updated_at'
        ];

    public function users()
    {
        return $this->belongsToMany(User::class,'client_user','id_client','id_user_dest')
        ->withPivot('valide','commentaire','motif','id_user_exp')
        ->withTimestamps();
    }
    
    public function createur()
    {
        return $this->belongsTo(User::class, 'id_createur');
    }

    public function mails()
    { 
        return $this->hasMany(Mail::class); 
    }

    public function appels()
    { 
        return $this->hasMany(Appel::class); 
    }
}
