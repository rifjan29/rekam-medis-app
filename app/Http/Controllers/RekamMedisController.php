<?php

namespace App\Http\Controllers;

use App\Models\RekamMedisModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $param['title'] = 'List Rekam Medis';
        $query = RekamMedisModel::when($search,function($query) use ($search) {
            $query->where('no_rm','like','%'.$search.'%')
                 ->orWhere('no_rm','like','%'.$search.'%');
        })->latest();
        $param['data'] = $query->paginate(10);

        $title = 'Delete Rekam Medis!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('rekam-medis.index',$param);
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
        $validateData = Validator::make($request->all(),[
            'no_rm' => 'required|unique:pasien,no_rm',
            'name' => 'required|max:100',
            'tempat' => 'required',
            'tgl_lahir' => 'required',
            'no_hp' => 'required',
            'jenis_kelamin' => 'required|not_in:0',
            'alamat' => 'required',
        ]);

        if ($validateData->fails()) {
            $html = "<ol class='max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400'>";
            foreach($validateData->errors()->getMessages() as $error) {
                $html .= "<li>$error[0]</li>";
            }
            $html .= "</ol>";

            alert()->html('Terjadi kesalahan eror!', $html, 'error')->autoClose(5000);
            return redirect()->route('rekam-medis.index');
        }
        try {
            $tambah = new RekamMedisModel;
            $tambah->no_rm = $request->get('no_rm');
            $tambah->nama_pasien = $request->get('name');
            $tambah->tempat_lahir = $request->get('tempat');
            $tambah->tanggal_lahir = Carbon::parse($request->get('tgl_lahir'));
            $tambah->no_hp = $request->get('no_hp');
            $tambah->alamat = $request->get('alamat');
            $tambah->jenis_kelamin = $request->get('jenis_kelamin');
            $tambah->user_id =Auth::user()->id;
            $tambah->save();

            alert()->success('Sukses','Berhasil menambahkan data.');
            return redirect()->route('rekam-medis.index');
        } catch (Exception $th) {
            return $th;
            alert()->error('Error','Terjadi Kesalahan');
            return redirect()->route('rekam-medis.index');
        } catch (QueryException $th) {
            return $th;
            alert()->error('Error','Terjadi Kesalahan');
            return redirect()->route('rekam-medis.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $data = RekamMedisModel::find($request->get('id'));
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $data = RekamMedisModel::find($request->get('id'));
        return $data;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateData = Validator::make($request->all(),[
            'no_rm' => 'required',
            'name' => 'required',
            'tempat' => 'required',
            'tgl_lahir' => 'required',
            'no_hp' => 'required',
            'jenis_kelamin' => 'required|not_in:0',
            'alamat' => 'required',
        ]);

        if ($validateData->fails()) {
            $html = "<ol class='max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400'>";
            foreach($validateData->errors()->getMessages() as $error) {
                $html .= "<li>$error[0]</li>";
            }
            $html .= "</ol>";

            alert()->html('Terjadi kesalahan eror!', $html, 'error')->autoClose(5000);
            return redirect()->route('rekam-medis.index');
        }
        try {
            $tambah = RekamMedisModel::find($request->get('id'));
            $tambah->no_rm = $request->get('no_rm');
            $tambah->nama_pasien = $request->get('name');
            $tambah->tempat_lahir = $request->get('tempat');
            $tambah->tanggal_lahir = Carbon::parse($request->get('tgl_lahir'));
            $tambah->no_hp = $request->get('no_hp');
            $tambah->alamat = $request->get('alamat');
            $tambah->jenis_kelamin = $request->get('jenis_kelamin');
            $tambah->user_id =Auth::user()->id;
            $tambah->update();

            alert()->warning('Peringatan','Berhasil mengganti data.');
            return redirect()->route('rekam-medis.index');
        } catch (Exception $th) {
            alert()->error('Error','Terjadi Kesalahan');
            return redirect()->route('rekam-medis.index');
        } catch (QueryException $th) {
            alert()->error('Error','Terjadi Kesalahan');
            return redirect()->route('rekam-medis.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
