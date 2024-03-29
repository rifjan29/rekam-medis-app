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
        $query = PeminjamanModel::with('pasien','user')->when($search,function($query) use ($search) {
            $query
                 ->where('kode_peminjam','like','%'.$search.'%')
                 ->orWhere('kode_peminjam','like','%'.$search.'%');
        });
        if ($request->has('kategori')) {

            $query->where('status_pengembalian',$kategori);
        }
        $param['data'] = $query->orderBy('created_at','DESC')->paginate(10);

        return view('laporan.index',$param);
    }

    public function export() {
        $param['data'] = PeminjamanModel::with('pasien','user')->get();
        return view('laporan.pdf',$param);
    }

}
