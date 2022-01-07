<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appel extends Model
{
    protected $dates = [
        'created_at',
        'updated_at'
        ];
        
    protected $fillable = ['motif','entrant_ou_sortant','temperature','date'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
