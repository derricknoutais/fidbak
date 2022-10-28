<?php

namespace App\Http\Controllers;
use App\Type;
use App\Modèle;
use Illuminate\Http\Request;

class ModèleController extends Controller
{
    public function all(){
        return Modèle::orderBy('nom')->get();
    }
    public function chercheModèle($type){
        return Type::where('id', $type)->with('modèles')->first();
    }
    public function enregistrer(Request $request){
        $modèle = Modèle::create([
            'nom' => $request->modèle,
            'marque_id' => $request->marque['id']
        ]);
    }
}
