<?php

namespace App\Http\Controllers;

use App\Models\TtdModel;
use Illuminate\Http\Request;

class TtdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $param['data'] = TtdModel::latest()->first();
        $param['title'] = 'Setting Tanda Tangan';
        return view('ttd.index',$param);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required',
            'nama' => 'required',
        ]);
        $ttd = new TtdModel;
        $ttd->nip = $request->get('nip');
        $ttd->nama = $request->get('nama');
        $ttd->save();
        alert()->success('Sukses','Berhasil menambahkan data.');
        return redirect()->route('ttd.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nip' => 'required',
            'nama' => 'required',
        ]);
        $ttd = TtdModel::find($id);
        $ttd->nip = $request->get('nip');
        $ttd->nama = $request->get('nama');
        $ttd->save();
        alert()->success('Sukses','Berhasil mengganti data.');
        return redirect()->route('ttd.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
