<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\HargaBeli;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use App\Models\HargaBeliPembelian;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index()
    {
        $pembelians = Pembelian::all();
        return view('livewire.index', compact('pembelians'));
    }

    public function barang()
    {
        $barangs = Barang::all();
        return response()->json($barangs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('livewire.create-multiple');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
    {
        $noPembelian = $request->input('no_pembelian');
        $tglPembelian = $request->input('tgl_pembelian');
        $selectedBarangs = $request->input('selectedBarangs');

        $pembelian = Pembelian::create([
            'no_pembelian' => $noPembelian,
            'tgl_pembelian' => $tglPembelian,
        ]);

        foreach ($selectedBarangs as $barang) {
            $hargaBeli = HargaBeli::create([
                'id_barang' => $barang['id_barang'],
                'harga_beli' => $barang['harga_beli'],
            ]);

            HargaBeliPembelian::create([
                'id_harga_beli' => $hargaBeli->id,
                'id_pembelian' => $pembelian->id,
            ]);
        }

        return response()->json(['message' => 'Pembelian berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pembelian = Pembelian::with(['hargaBeli.barang'])->findOrFail($id);
        $barangs = Barang::all();
        return view('livewire.edit-multiple', compact('pembelian', 'barangs'));
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
        $pembelian = Pembelian::findOrFail($id);
        $pembelian->no_pembelian = $request->input('no_pembelian');
        $pembelian->tgl_pembelian = $request->input('tgl_pembelian');
        $pembelian->save();

        $selectedBarangs = collect($request->input('selectedBarangs'));

        $updatedBarangIds = $selectedBarangs->pluck('id_barang')->toArray();

        $pembelian->hargaBeli()->whereNotIn('id_barang', $updatedBarangIds)->get()->each(function($hargaBeli) {
            HargaBeliPembelian::where('id_harga_beli', $hargaBeli->id)->delete();
            $hargaBeli->delete();
        });

        foreach ($selectedBarangs as $barang) {
            $hargaBeli = HargaBeli::updateOrCreate(
                ['id_barang' => $barang['id_barang']],
                ['harga_beli' => $barang['harga_beli']]
            );

            HargaBeliPembelian::updateOrCreate(
                ['id_harga_beli' => $hargaBeli->id, 'id_pembelian' => $pembelian->id]
            );
        }

        return response()->json(['message' => 'Pembelian berhasil diperbarui']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pembelian = Pembelian::with('hargaBeli')->findOrFail($id);

        HargaBeliPembelian::where('id_pembelian', $id)->delete();

        foreach ($pembelian->hargaBeli as $hargaBeli) {
            $hargaBeli->delete();
        }

        $pembelian->delete();

        return response()->json(['message' => 'Pembelian dan data terkait berhasil dihapus']);
    }
}
