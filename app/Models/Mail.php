<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    protected $fillable = ['entrant_ou_sortant','objet',];
    
    protected $dates = [
        'created_at',
        'updated_at'
        ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
