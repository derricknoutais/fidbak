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
    public function all()
    {
        return Modèle::orderBy('nom')->get();
    }
    public function chercheModèle($type)
    {
        return Type::where('id', $type)
            ->with('modèles')
            ->first();
    }
    public function enregistrer(Request $request)
    {
        if (
            $request->modèle &&
            !($modèle = Modèle::where([
                'nom' => $request->modèle,
                'marque_id' => $request->marque['id'],
            ])->first())
        ) {
            $modèle = Modèle::create([
                'nom' => $request->modèle,
                'marque_id' => $request->marque['id'],
            ]);
        }
        if (
            $request->moteur &&
            !($moteur = Moteur::where([
                'nom' => $request->moteur,
                'marque_id' => $request->marque['id'],
            ])->first())
        ) {
            $moteur = Moteur::create([
                'nom' => $request->moteur,
                'marque_id' => $request->marque['id'],
            ]);
        }
        if (
            $request->type &&
            isset($modèle) &&
            !ModèleType::where([
                'modèle_id' => $modèle->id,
                'type_id' => $request->type['id'],
            ])->first()
        ) {
            ModèleType::create([
                'modèle_id' => $modèle->id,
                'type_id' => $request->type['id'],
            ]);
        }
        if (
            $request->type &&
            isset($moteur) &&
            !TypeMoteur::where([
                'moteur_id' => $moteur->id,
                'type_id' => $request->type['id'],
            ])->first()
        ) {
            TypeMoteur::create([
                'moteur_id' => $moteur->id,
                'type_id' => $request->type['id'],
            ]);
        }
    }
}
