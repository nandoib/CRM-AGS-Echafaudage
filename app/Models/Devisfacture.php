<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Devisfacture extends Model
{
    protected $fillable = ['date','montant','facture_ou_devis','commentaire','remise'];
    
    protected $dates = [
        'created_at',
        'updated_at'
        ];

    public function status()
    { 
        return $this->hasMany(Statutdevis::class,'id_devis'); 
    }

    public function client()
    { 
        return $this->belongsTo(Client::class, 'id_client'); 
    }
    
    public function commercial()
    {
        return $this->belongsTo(User::class,'id_user');
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class,'article_devisfacture','devisfacture_id','article_id')
        ->withPivot('quantite','prix')
        ->withTimestamps();
    }


}
