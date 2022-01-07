<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statutdevis extends Model
{
    protected $fillable = ['statut','temperature','date'];

    protected $dates = [
        'created_at',
        'updated_at'
        ];

    public function devi()
    {
        return $this->belongsTo(devisfacture::class, 'id_devis');
    }
}
