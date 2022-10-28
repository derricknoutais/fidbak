<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Type;
class TypeController extends Controller
{
    public function all(){
        return Type::orderBy('nom')->get();
    }
    public function chercheModèle($marque){
        return Type::where('marque_id', $marque)->orderBy('nom')->get();
    }
    public function enregistrer(Request $request){
        return Type::create([
            'marque_id' => $request->marque['id'],
            'nom' => $request->type
        ]);
    }
}
