<?php

namespace App\Http\Controllers;

use App\ModèleType;
use Illuminate\Http\Request;

class ModèleTypeController extends Controller
{
    public function enregistrer(Request $request){
        ModèleType::create([
            'modèle_id' => $request->modèle['id'],
            'type_id' => $request->type['id']
        ]);
    }
}
