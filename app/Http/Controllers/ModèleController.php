<?php

namespace App\Http\Controllers;
use App\Type;
use App\Modèle;
use App\ModèleType;
use App\Moteur;
use Illuminate\Http\Request;
use App\TypeMoteur;

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
        if($request->moteur){
            $moteur = Moteur::create([
                'nom' => $request->moteur,
                'marque_id' => $request->marque['id']
            ]);
        }
        if($request->type && $modèle){
            ModèleType::create([
                'modèle_id' => $modèle->id,
                'type_id' => $request->type['id']
            ]);
            if($moteur){
                TypeMoteur::create([
                    'moteur_id' => $moteur->id,
                    'type_id' => $request->type['id']
                ]);
            }

        }
    }
}
