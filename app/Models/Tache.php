<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
   protected $fillable = ['type','commentaire','datefinale','titre'];

   protected $dates = [
    'created_at',
    'updated_at'
    ];

   public function user()
    {
        return $this->belongsTo(User::class,'id_user');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }
}