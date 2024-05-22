<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanModel;
use App\Models\RekamMedisModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request) {
        $search = $request->get('search');
        $kategori = $request->get('kategori');
        $param['title'] = 'List Laporan';
        $start = Carbon::parse($request->start)->format('Y-m-d');
        $end = Carbon::parse($request->end)->format('Y-m-d');
        $query = PeminjamanModel::with('pasien','user')
        ->when($search,function($query) use ($search) {
            $query
                 ->where('kode_peminjam','like','%'.$search.'%')
                 ->orWhere('kode_peminjam','like','%'.$search.'%');
        })
        ->when($request->get('start'), function ($query) use ($start, $end) {
            $query->whereBetween('created_at', [$start, $end]);
        });
        if ($request->has('kategori')) {

            $query->where('status_pengembalian',$kategori);
        }
        $param['data'] = $query->orderBy('created_at','DESC')->paginate(10);

        return view('laporan.index',$param);
    }

    public function export(Request $request) {
        $start = Carbon::parse($request->start)->format('Y-m-d');
        $end = Carbon::parse($request->end)->format('Y-m-d');
        $param['data'] = PeminjamanModel::with('pasien','user')
        ->when($request->get('start'), function ($query) use ($start, $end) {
            $query->whereBetween('created_at', [$start, $end]);
        })->get();
        return view('laporan.pdf',$param);
    }

}
