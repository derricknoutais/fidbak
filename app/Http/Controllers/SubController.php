<?php

namespace App\Http\Controllers;

use App\Sub;
use Illuminate\Http\Request;

class SubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subs = Sub::with('produit')->get();
        return view('sub.index', compact('subs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Sub::create([
            'product_id' => $request->id,
            'quantité' => 1,
            'nom' => $request->variant_name,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sub  $sub
     * @return \Illuminate\Http\Response
     */
    public function show(Sub $sub)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sub  $sub
     * @return \Illuminate\Http\Response
     */
    public function edit(Sub $sub)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sub  $sub
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sub $sub)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sub  $sub
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sub $sub)
    {
        //
    }
}
