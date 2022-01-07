<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'prenom',
        'nom',
        'email',
        'telephone',
        'role',
        'id_user_dest'
        
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
        ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
    public function clients()
    {
        return $this->belongsToMany(Client::class, 'client_user','id_user_dest','id_client' )
        ->withPivot('valide','commentaire','motif','id_user_exp')
        ->withTimestamps();
    }

    public function mails()
    { 
        return $this->hasMany(Mail::class); 
    }

    public function appels()
    { 
        return $this->hasMany(Appel::class); 
    }

    public function clientscrees() 
    { 
        return $this->hasMany(Client::class, 'id_user'); 
    }

    public function devis()
    {
        return $this->hasMany(Devisfacture::class);
    }
}