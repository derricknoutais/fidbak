<?php

namespace App\Http\Controllers;
use App\TypeMoteur;
use Illuminate\Http\Request;

class TypeMoteurController extends Controller
{
    public function enregistrer(Request $request){

        $modèle_moteur = TypeMoteur::create([
            'type_id' => $request->type['id'],
            'moteur_id' => $request->moteur['id']
        ]);
    }
}
