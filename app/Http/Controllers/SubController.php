<?php

namespace App\Http\Controllers;

use App\Sub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

class SubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subs = Sub::latest()->get();
        return view('sub.index', compact('subs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reporting()
    {
        $subs = json_decode(Redis::get('subs_with_products'), true);
        $subs = collect($subs)->map(function ($item) {
            // Transforme chaque produit en collection pour pouvoir

            $t = collect($item);
            $t->produit = $item['produit'];
            // Trier et retourner les donnees  ci-dessous
            return $t;
        });
        // return $subs;
        $total = 0;
        foreach ($subs as $sub) {
            if (isset($sub->produit) && isset($sub->produit->price_including_tax)) {
                $total += $sub->produit->price_including_tax;
            }
        }
        // return $total;

        return view('sub.reporting', compact('subs', 'total'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $created_sub = Sub::create([
            'product_id' => $request->id,
            'quantité' => 1,
            'nom' => $request->variant_name,
        ]);

        $subs = json_decode(Redis::get('subs_with_products'), true);
        $subs = collect($subs)->map(function ($item) {
            // Transforme chaque produit en collection pour pouvoir
            $t = collect($item);
            $t->produit = $item['produit'];
            // Trier et retourner les donnees  ci-dessous
            return $t;
        });
        $products = json_decode(Redis::lrange('pulled_products', -1000000, 1000000)[0], true);

        $found = array_filter($products, function ($product) use ($created_sub) {
            return $product['id'] === $created_sub->product_id;
        });

        $created_sub->produit = collect(array_values($found));
        $subs->push($created_sub);

        Redis::del('subs_with_products');
        Redis::set('subs_with_products', $subs);
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
