<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Moteur;
use App\Type;
class MoteurController extends Controller
{
    public function all(){
        return Moteur::orderBy('nom')->get();
    }
    public function chercheMoteurs($type){
        return Type::where('id', $type)->with(['moteurs', 'modèles'])->first();
    }
    public function enregistrer(Request $request){
        Moteur::create([
            'marque_id' => $request->marque['id'],
            'nom' => $request->moteur
        ]);
    }
}
