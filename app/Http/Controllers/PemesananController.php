<?php

namespace App\Http\Controllers;

use App\Models\Rute;
use App\Models\Category;
use App\Models\Pemesanan;
use App\Models\Transportasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class PemesananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ruteAwal = Rute::orderBy('start')->get()->groupBy('start');
        if (count($ruteAwal) > 0) {
            foreach ($ruteAwal as $key => $value) {
                $data['start'][] = $key;
            }
        } else {
            $data['start'] = [];
        }
        $ruteAkhir = Rute::orderBy('end')->get()->groupBy('end');
        if (count($ruteAkhir) > 0) {
            foreach ($ruteAkhir as $key => $value) {
                $data['end'][] = $key;
            }
        } else {
            $data['end'] = [];
        }
        $category = Category::orderBy('name')->get();
        return view('client.index', compact('data', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


}
