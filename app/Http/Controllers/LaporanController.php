<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanModel;
use App\Models\RekamMedisModel;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request) {
        $search = $request->get('search');
        $kategori = $request->get('kategori');
        $param['title'] = 'List Laporan';
        $query = PeminjamanModel::with('pasien')->when($search,function($query) use ($search) {
            $query
                 ->where('kode_peminjam','like','%'.$search.'%')
                 ->orWhere('kode_peminjam','like','%'.$search.'%')->latest();
        });
        if ($request->has('kategori')) {

            $query->where('status_pengembalian',$kategori)->latest();
        }
        $param['data'] = $query->paginate(10);

        return view('laporan.index',$param);
    }

    public function export() {
        $param['data'] = PeminjamanModel::with('pasien')->get();
        return view('laporan.pdf',$param);
    }

}
