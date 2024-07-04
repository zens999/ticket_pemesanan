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
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to continue');
        }
    
        if ($request->category) {
            $category = Category::find($request->category);
            if (!$category) {
                Log::error('Category not found', ['category_id' => $request->category]);
                return redirect()->back()->with('error', 'Category not found!');
            }
            $data = [
                'start' => $request->start,
                'end' => $request->end,
                'category' => $category->id,
                'waktu' => $request->waktu,
            ];
            $data = Crypt::encrypt($data);
            return redirect()->route('show', ['id' => $category->slug, 'data' => $data]);
        } else {
            $this->validate($request, [
                'rute_id' => 'required',
                'waktu' => 'required',
            ]);
    
            $huruf = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
            $kodePemesanan = strtoupper(substr(str_shuffle($huruf), 0, 7));
    
            $rute = Rute::with('transportasi.category')->find($request->rute_id);
            if (!$rute) {
                Log::error('Rute not found', ['rute_id' => $request->rute_id]);
                return redirect()->back()->with('error', 'Rute not found!');
            }
    
            $waktu = $request->waktu . " " . $rute->jam;
    
            Pemesanan::create([
                'kode' => $kodePemesanan,
                'waktu' => $waktu,
                'total' => $rute->harga,
                'rute_id' => $rute->id,
                'penumpang_id' => Auth::user()->id
            ]);
    
            return redirect()->back()->with('success', 'Pemesanan Tiket ' . $rute->transportasi->category->name . ' Success!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $data)
    {
        $data = Crypt::decrypt($data);
        $category = Category::find($data['category']);
        $rute = Rute::with('transportasi')->where('start', $data['start'])->where('end', $data['end'])->get();
        $dataRute = []; // Inisialisasi $dataRute sebagai array kosong
    
        if ($rute->count() > 0) {
            foreach ($rute as $val) {
                $pemesanan = Pemesanan::where('rute_id', $val->id)->where('waktu')->count();
                if ($val->transportasi) {
                    $kursi = Transportasi::find($val->transportasi_id)->jumlah - $pemesanan;
                    if ($val->transportasi->category_id == $category->id) {
                        $dataRute[] = [
                            'harga' => $val->harga,
                            'start' => $val->start,
                            'end' => $val->end,
                            'tujuan' => $val->tujuan,
                            'transportasi' => $val->transportasi->name,
                            'kode' => $val->transportasi->kode,
                            'kursi' => $kursi,
                            'waktu' => $data['waktu'],
                            'id' => $val->id,
                        ];
                    }
                }
            }
        }
    
        // Tambahkan pengecekan apakah $dataRute sudah diisi sebelum sort()
        if (!empty($dataRute)) {
            sort($dataRute);
        }
    
        $id = $category->name;
        return view('client.show', compact('id', 'dataRute'));
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Crypt::decrypt($id);
        $rute = Rute::find($data['id']);
        $transportasi = Transportasi::find($rute->transportasi_id);
        return view('client.kursi', compact('data', 'transportasi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function pesan($kursi, $data)
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Please login to continue');
    }

    $d = Crypt::decrypt($data);
    $huruf = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
    $kodePemesanan = strtoupper(substr(str_shuffle($huruf), 0, 7));

    $rute = Rute::with('transportasi.category')->find($d['id']);
    if (!$rute) {
        Log::error('Rute not found in pesan method', ['rute_id' => $d['id']]);
        return redirect()->back()->with('error', 'Rute not found!');
    }

    $waktu = $d['waktu'] . " " . $rute->jam;

    Pemesanan::create([
        'kode' => $kodePemesanan,
        'kursi' => $kursi,
        'waktu' => $waktu,
        'total' => $rute->harga,
        'rute_id' => $rute->id,
        'penumpang_id' => Auth::user()->id
    ]);

    return redirect()->route('pemesanan.index')->with('success', 'Pemesanan Tiket ' . $rute->transportasi->category->name . ' Berhasil!');
}

}
