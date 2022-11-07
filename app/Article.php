<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Handle;

class Article extends Model
{
    protected $guarded = [];

    public function changeEtat($etat){
        $this->update([
            'état' => $etat
        ]);
    }
    public function fiche_renseignement()
    {
        return $this->belongsTo('App\FicheRenseignement');
    }
    /**
     * Get the handle that owns the Article
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function handle()
    {
        return $this->belongsTo(Handle::class);
    }
}
