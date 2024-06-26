<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanModel;
use App\Models\RekamMedisModel;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $param['title'] = 'List Peminjaman';
        if (Auth::user()->role == 'admin') {
            $query = PeminjamanModel::with('pasien','user')->when($search,function($query) use ($search) {
                $query->where('kode_peminjam','like','%'.$search.'%')
                     ->orWhere('kode_peminjam','like','%'.$search.'%');
            })->latest();
        }else{

            $query = PeminjamanModel::with('pasien','user')->when($search,function($query) use ($search) {
                $query->where('kode_peminjam','like','%'.$search.'%')
                     ->orWhere('kode_peminjam','like','%'.$search.'%');
            })->latest();
        }
               $param['data'] = $query->paginate(10);
        $title = 'Delete Peminjaman!';
        $text = "Are you sure you want to delete?";
        $param['users'] = User::where('role','petugas-peminjam')->get();
        $peminjaman = PeminjamanModel::where('status_rm','dipinjam')->pluck('id_rm');
        if (count($peminjaman) > 0) {
            $param['rekam_medis'] = RekamMedisModel::latest()->whereNotIn('id',$peminjaman)->get();
        }else{
            $param['rekam_medis'] = RekamMedisModel::latest()->get();
        }
        confirmDelete($title, $text);
        return view('peminjam.index',$param);
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
        // Rawat Jalan 1x24 jam
        // Rawat Inap 2x24 jam

        $validateData = Validator::make($request->all(),[
            'no_rm' => 'required|not_in:0',
            'tgl_pinjam' => 'required',
            'keperluan' => 'required',
        ]);
        if ($validateData->fails()) {
            $html = "<ol class='max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400'>";
            foreach($validateData->errors()->getMessages() as $error) {
                $html .= "<li>$error[0]</li>";
            }
            $html .= "</ol>";

            alert()->html('Terjadi kesalahan eror!', $html, 'error')->autoClose(5000);
            return redirect()->route('peminjaman.index');
        }
        $tanggal = $request->get('tgl_pinjam');
        $tanggal_pinjam = Carbon::parse($tanggal);
        $unit = $request->get('unit');
        if ($unit == 'rawat-inap') {
            $tanggal_kembali = $tanggal_pinjam->addDays(2); // Rawat inap 2x24 jam
        } else {
            $tanggal_kembali = $tanggal_pinjam->addDays(1); // Rawat jalan 1x24 jam
        }
        try {
            $tambah = new PeminjamanModel;
            $tambah->kode_peminjam = $this->generateKode();
            $tambah->id_rm = $request->get('no_rm');
            $tambah->unit_default = $request->has('unit') ? $request->get('unit') : null;
            $tambah->tanggal_peminjaman = Carbon::parse($tanggal)->format('Y-m-d');
            $tambah->keperluan = $request->get('keperluan');
            $tambah->status_rm = 'pending';
            if (Auth::user()->role == 'petugas-rm') {
                $tambah->user_id = $request->get('peminjam');
                $tambah->is_verifikasi = 'petugas-peminjam';
            } elseif (Auth::user()->role == 'petugas-peminjam') {
                $tambah->is_verifikasi = 'petugas-rm';
                $tambah->user_id = Auth::user()->id;
            } else {
                $tambah->is_verifikasi = 'admin';
                $tambah->user_id = Auth::user()->id;
            }
            $tambah->tanggal_pengembalian = $tanggal_kembali->format('Y-m-d');
            $tambah->status_pengembalian = 'pending';
            $tambah->save();
            alert()->success('Sukses','Berhasil menambahkan data.');
            return redirect()->route('peminjaman.index');
        } catch (Exception $e) {
            alert()->error('Error','Terjadi Kesalahan');
            return redirect()->route('peminjaman.index');
        } catch (QueryException $e) {
            alert()->error('Error','Terjadi Kesalahan');
            return redirect()->route('peminjaman.index');
        }
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
    public function edit(Request $request, string $id)
    {
        $data = PeminjamanModel::with('pasien','user')->find($request->id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateData = Validator::make($request->all(),[
            'no_rm' => 'required|not_in:0',
            'tgl_pinjam' => 'required',
            'keperluan' => 'required',
        ]);
        if ($validateData->fails()) {
            $html = "<ol class='max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400'>";
            foreach($validateData->errors()->getMessages() as $error) {
                $html .= "<li>$error[0]</li>";
            }
            $html .= "</ol>";

            alert()->html('Terjadi kesalahan eror!', $html, 'error')->autoClose(5000);
            return redirect()->route('peminjaman.index');
        }
        $tanggal = $request->get('tgl_pinjam');
        $tanggal_pinjam = Carbon::parse($tanggal);
        if ($request->has('unit')) {
            if ($request->get('unit') == 'igd') {
                $unit = $request->get('unit_igd');
                if ($unit == 'rawat-inap') {
                    $tanggal_kembali = $tanggal_pinjam->addDays(2); // Rawat inap 2x24 jam
                } else {
                    $tanggal_kembali = $tanggal_pinjam->addDays(1); // Rawat jalan 1x24 jam
                }
            }else{
                $tanggal_kembali = $tanggal_pinjam->addDays(1); // Rawat jalan 1x24 jam
            }
        }else{
            $tanggal_kembali = $tanggal_pinjam->addDays(1); // Rawat jalan 1x24 jam
        }
        try {
            $update = PeminjamanModel::find($request->get('id'));
            $update->kode_peminjam = $this->generateKode();
            $update->id_rm = $request->get('no_rm');
            $update->unit_default = $request->has('unit') ? $request->get('unit') : null;
            $update->tanggal_peminjaman = Carbon::parse($tanggal)->format('Y-m-d');
            $update->keperluan = $request->get('keperluan');
            $update->status_rm = 'pending';
            if (Auth::user()->role == 'petugas-rm') {
                $update->user_id = $request->get('peminjam');
                $update->is_verifikasi = 'petugas-peminjam';
            } elseif (Auth::user()->role == 'petugas-peminjam') {
                $update->is_verifikasi = 'petugas-rm';
                $update->user_id = Auth::user()->id;
            } else {
                $update->is_verifikasi = 'admin';
                $update->user_id = Auth::user()->id;
            }
            $update->tanggal_pengembalian = Carbon::parse($tanggal_kembali)->format('Y-m-d');
            $update->status_pengembalian = 'pending';
            $update->update();
            alert()->success('Sukses','Berhasil mengganti data.');
            return redirect()->route('peminjaman.index');
        } catch (Exception $e) {
            alert()->error('Error','Terjadi Kesalahan');
            return redirect()->route('peminjaman.index');
        } catch (QueryException $e) {
            alert()->error('Error','Terjadi Kesalahan');
            return redirect()->route('peminjaman.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        PeminjamanModel::find($id)->delete();
        alert()->success('Sukses','Berhasil dihapus.');
        return redirect()->route('peminjaman.index');
    }

    public function verifikasi(Request $request) {
        try {
            $verifikasi = PeminjamanModel::find($request->get('id'));
            $current_verifikasi = PeminjamanModel::where('id_rm',$verifikasi->id_rm)->where('status_rm','dipinjam')->get();
            $count_verifikasi = PeminjamanModel::where('id_rm',$verifikasi->id_rm)->where('status_rm','dipinjam')->count();

            if ($count_verifikasi >= 1) {
                if (isset($current_verifikasi)) {
                    alert()->warning('Warning','Data masih dalam peminjaman.');
                    return redirect()->route('peminjaman.index');
                }else{
                    $verifikasi = PeminjamanModel::find($request->get('id'));
                    $verifikasi->status_rm = 'dipinjam';
                    $verifikasi->update();
                    alert()->success('Sukses','Berhasil verifikasi data.');
                    return redirect()->route('peminjaman.index');
                }
            }else{
                $verifikasi = PeminjamanModel::find($request->get('id'));
                $verifikasi->status_rm = 'dipinjam';
                $verifikasi->update();
                alert()->success('Sukses','Berhasil verifikasi data.');
                return redirect()->route('peminjaman.index');
            }

        } catch (Exception $e) {
            alert()->error('Error','Terjadi Kesalahan');
            return redirect()->route('peminjaman.index');
        } catch (QueryException $e) {
            alert()->error('Error','Terjadi Kesalahan');
            return redirect()->route('peminjaman.index');
        }
    }

    public function setTanggal(Request $request) {
        $validateData = Validator::make($request->all(),[
            'tanggal_kembali' => 'required',
        ]);
        if ($validateData->fails()) {
            $html = "<ol class='max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400'>";
            foreach($validateData->errors()->getMessages() as $error) {
                $html .= "<li>$error[0]</li>";
            }
            $html .= "</ol>";

            alert()->html('Terjadi kesalahan eror!', $html, 'error')->autoClose(5000);
            return redirect()->route('peminjaman.index');
        }
        try {
            $tanggal = $request->get('tanggal_kembali');
            $tanggal_kembali = Carbon::parse($tanggal);

            $set = PeminjamanModel::find($request->get('id'));
            $set->status_rm = 'dipinjam';
            $set->tanggal_pengembalian = $tanggal_kembali->addDays(2);
            $set->update();

            alert()->success('Sukses','Berhasil set tanggal peminjaman.');
            return redirect()->route('peminjaman.index');
        } catch (Exception $e) {
            alert()->error('Error','Terjadi Kesalahan');
            return redirect()->route('peminjaman.index');
        } catch (QueryException $e) {
            alert()->error('Error','Terjadi Kesalahan');
            return redirect()->route('peminjaman.index');
        }
    }

    public function kembali(Request $request) {
        try {
            $kembali = PeminjamanModel::find($request->get('id'));
            $tanggal = Carbon::now()->translatedFormat('Y-m-d');
            if ($kembali->unit_default == 'rawat-inap') {
                if ($kembali->tanggal_pengembalian == null) {
                    alert()->warning('gagal','Pengembalian gagal harap set tanggal pengembalian.');
                    return redirect()->route('peminjaman.index');
                }
            }
            if ($tanggal == Carbon::parse($kembali->tanggal_pengembalian)) {
                $updateSukses = PeminjamanModel::find($request->get('id'));
                $updateSukses->status_pengembalian = 'sukses';
                $updateSukses->status_rm = 'tersedia';
                $updateSukses->verifikasi_tanggal = $tanggal;
                $updateSukses->status_pengembalian = 'sukses';
                $updateSukses->update();
            }else{
                $updateTerlambat = PeminjamanModel::find($request->get('id'));
                $updateTerlambat->status_pengembalian = 'terlambat';
                $updateTerlambat->status_rm = 'tersedia';
                $updateTerlambat->verifikasi_tanggal = $tanggal;
                $updateTerlambat->update();
            }
            alert()->success('Sukses','Berhasil pengembalian data.');
            return redirect()->route('peminjaman.index');
        } catch (Exception $e) {
            alert()->error('Error','Terjadi Kesalahan');
            return redirect()->route('peminjaman.index');
        } catch (QueryException $e) {
            alert()->error('Error','Terjadi Kesalahan');
            return redirect()->route('peminjaman.index');
        }
    }

    public function generateKode($length = 8)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $charactersLength = strlen($characters);
        $kode = '';

        // Generate random kode
        for ($i = 0; $i < $length; $i++) {
            $kode .= $characters[rand(0, $charactersLength - 1)];
        }

        // Check if kode already exists, if exists, regenerate kode
        while ($this->kodeExists($kode)) {
            $kode = '';
            for ($i = 0; $i < $length; $i++) {
                $kode .= $characters[rand(0, $charactersLength - 1)];
            }
        }

        return $kode;
    }
    private function kodeExists($kode)
    {
        return PeminjamanModel::where('kode_peminjam', $kode)->exists();
    }

    public function cetakTracer($id) {
        $param['title'] = 'Cetak Tracer';
        $param['data'] = PeminjamanModel::with('pasien')->find($id);
        return view('peminjam.cetak-tracer',$param);
    }

    public function cetakTracerPdf($id){
        $param['title'] = 'Cetak Tracer PDF     ';
        $param['data'] = PeminjamanModel::with('pasien')->find($id);
        return view('peminjam.cetak-tracer-pdf',$param);
    }
}
