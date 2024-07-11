<?php

namespace App\Http\Controllers;

use App\Models\Rute;
use App\Models\Transportasi;
use Illuminate\Http\Request;

class RuteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transportasi = Transportasi::orderBy('kode')->orderBy('name')->get();
        $rute = Rute::with('transportasi.category')->orderBy('created_at', 'desc')->get();
        return view('server.rute.index', compact('rute', 'transportasi'));
    }
     public function edit($id)
    {
        $rute = Rute::find($id);
        $transportasi = Transportasi::orderBy('kode')->orderBy('name')->get();
        return view('server.rute.edit', compact('rute', 'transportasi'));
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
        $request->validate([
            'tujuan' => 'required|string|max:255',
            'start' => 'required|string|max:255',
            'end' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'jam' => 'required',
            'transportasi_id' => 'required|exists:transportasi,id',
        ]);

        $rute = Rute::findOrFail($id);
        $rute->update($request->all());

        return redirect()->route('rute.index')->with('success', 'Rute berhasil diupdate.');
    }



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


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Rute::find($id)->delete();
        return redirect()->back()->with('success', 'Success Delete Rute!');
    }
}
