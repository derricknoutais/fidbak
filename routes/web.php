<?php

use App\Article;
use App\Sub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  X-CSRF-TOKEN, X-Requested-With, Content-Type, X-Auth-Token, Origin, Authorization');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/api')->group(function () {
    Route::get('/handles', function () {
        return DB::table('handles')->get();
    });
});

Route::view('/fiche-renseignement/renseigner', 'fiche-renseignement.create');
Route::prefix('/fiche-renseignement')->group(function () {
    Route::get('reporting', 'FicheRenseignementController@reporting');
    Route::get('/', 'FicheRenseignementController@répertoire');
    Route::get('/{fiche}', 'FicheRenseignementController@show');

    Route::prefix('/api')->group(function () {
        Route::get('/all', 'FicheRenseignementController@all');
        Route::get('/supprimer/{fiche}', 'FicheRenseignementController@supprimer');
        Route::post('/enregistrer', 'FicheRenseignementController@enregistrer');
        Route::post('/update', 'FicheRenseignementController@update');
        Route::post('/articles/commander/{article}', 'ArticleController@modifier');
        Route::post('/articles/changer-etat/{article}', 'ArticleController@changerEtat');

        Route::post('/articles/{article}/store-the-stars', 'ArticleController@storeTheStars');
    });
    Route::prefix('/marque')->group(function () {
        Route::view('créer', 'fiche-renseignement.marque.créer');
        Route::prefix('/api')->group(function () {
            Route::get('/all', 'MarqueController@all');
            Route::post('/enregistrer', 'MarqueController@enregistrer');
        });
    });
    Route::prefix('/type')->group(function () {
        Route::get('/de-marque/{marque}', 'TypeController@chercheModèle');
        Route::prefix('/api')->group(function () {
            Route::get('/all', 'TypeController@all');
            Route::post('/enregistrer', 'TypeController@enregistrer');
        });
    });
    Route::prefix('/modèle')->group(function () {
        Route::get('/de-type/{type}', 'ModèleController@chercheModèle');
        Route::prefix('/api')->group(function () {
            Route::get('/all', 'ModèleController@all');
            Route::post('/enregistrer', 'ModèleController@enregistrer');
        });
    });
    Route::prefix('/type-moteur')->group(function () {
        Route::prefix('/api')->group(function () {
            Route::post('/enregistrer', 'TypeMoteurController@enregistrer');
        });
    });
    Route::prefix('/moteur')->group(function () {
        Route::get('/de-type/{type}', 'MoteurController@chercheMoteurs')->where('type', '[0-9]+');
        Route::prefix('/api')->group(function () {
            Route::get('/all', 'MoteurController@all');
            Route::post('/enregistrer', 'MoteurController@enregistrer');
        });
    });
    Route::prefix('/modèle-type')->group(function () {
        Route::prefix('/api')->group(function () {
            // Route::get('/all', 'MoteurController@all');
            Route::post('/enregistrer', 'ModèleTypeController@enregistrer');
        });
    });
});

Route::prefix('/subzero')->group(function () {
    Route::get('/', 'SubController@index');
    Route::get('/reporting', 'SubController@reporting');
    Route::post('/store', 'SubController@store');
});

Route::prefix('/article')->group(function () {
    Route::prefix('/api')->group(function () {
        Route::get('all', 'ArticleController@all');
        Route::get('non-commandé', 'ArticleController@nonCommandé');
        Route::get('changer-etat/{article_id}/{etat}', function ($article_id, $etat) {
            $article = App\Article::find($article_id);
            $updated = $article->update([
                'état' => $etat,
            ]);
            if ($updated) {
                return 'ok';
            }
        });
        Route::post('changer-etat/{etat}', function (Request $request, $etat) {
            return $request->all();
            $updated = DB::table('articles')
                ->whereIn('id', $request['ids'])
                ->update([
                    'état' => $etat,
                ]);

            if ($updated) {
                return 'ok';
            }
        });
        Route::get('/search/{query}', 'ArticleController@search');
        Route::post('/search', 'ArticleController@search_ids');

        Route::get('/{article}', function (Article $article) {
            return $article;
        });

        Route::post('/bulk-fetch', function (Request $request) {
            return Article::whereIn('id', $request->all())
                ->with('fiche_renseignement', 'fiche_renseignement.marque', 'fiche_renseignement.modèle', 'fiche_renseignement.type', 'fiche_renseignement.moteur')
                ->get();
        });
    });
    Route::put('', 'ArticleController@update');
});

Route::get('/test-pulldb', function () {
    $subs = Sub::all();
    $products = Http::get('https://pulldb.stapog.com/api/products')->json();
    Redis::ltrim('pulled_products', 1, 0);
    Redis::rpush('pulled_products', json_encode($products));

    // Recupere les produits recuperes de Vend stockes dans Redis ()
    $products = json_decode(Redis::lrange('pulled_products', -1000000, 1000000)[0], true);

    $subs->map(function ($sub) use ($products) {
        $found = array_filter($products, function ($product) use ($sub) {
            return $product['id'] === $sub->product_id;
        });
        return $sub->produit = collect(array_values($found));
    });
    Redis::del('subs_with_products');
    Redis::set('subs_with_products', $subs);
});
