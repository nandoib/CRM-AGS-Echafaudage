<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $dates = [
        'created_at',
        'updated_at'
        ];

    protected $fillable = 
    [
        'designation',
        'prix',
        'poids',
        'reference',
        'stock'
    ];

    public function devisfactures()
    {
        return $this->belongsToMany(DevisFacture::class,'article_devisfacture','article_id','devisfacture_id')
        ->withPivot('quantite','prix')
        ->withTimestamps();
    }
}
