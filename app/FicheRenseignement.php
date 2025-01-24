<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FicheRenseignement extends Model
{
    protected $guarded = [];
    public function marque()
    {
        return $this->belongsTo('App\Marque', 'marque_id');
    }
    public function type()
    {
        return $this->belongsTo('App\Type', 'type_id');
    }
    public function modèle()
    {
        return $this->belongsTo('App\Modèle', 'modèle_id');
    }
    public function moteur()
    {
        return $this->belongsTo('App\Moteur', 'moteur_id');
    }
    public function articles()
    {
        return $this->hasMany('App\Article');
    }
    public function articles_commandés()
    {
        return $this->hasMany('App\Article')->where('état', '=', 'commandé');
    }
}
