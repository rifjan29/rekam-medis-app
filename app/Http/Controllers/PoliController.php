<?php

namespace App\Http\Controllers;

use App\Models\PoliModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PoliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $param['title'] = 'List Poli';
        $query = PoliModel::when($search,function($query) use ($search) {
            $query->where('poli_name','like','%'.$search.'%')
                 ->orWhere('poli_name','like','%'.$search.'%');
        })->latest();
        $param['data'] = $query->paginate(10);

        $title = 'Delete Poli!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('poli.index',$param);
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
            'name' => 'required',
        ]);

        if ($validateData->fails()) {
            $html = "<ol class='max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400'>";
            foreach($validateData->errors()->getMessages() as $error) {
                $html .= "<li>$error[0]</li>";
            }
            $html .= "</ol>";

            alert()->html('Terjadi kesalahan eror!', $html, 'error')->autoClose(5000);
            return redirect()->route('poli.index');
        }
        try {
            $tambah = new PoliModel;
            $tambah->poli_name = $request->get('name');
            $tambah->save();

            alert()->success('Sukses','Berhasil menambahkan data.');
            return redirect()->route('poli.index');

        } catch (Exception  $th) {
            alert()->error('Error','Terjadi Kesalahan');
            return redirect()->route('poli.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $data = PoliModel::find($request->get('id'));
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $data = PoliModel::find($request->get('id'));
        return $data;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateData = Validator::make($request->all(),[
            'name' => 'required',
        ]);

        if ($validateData->fails()) {
            $html = "<ol class='max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400'>";
            foreach($validateData->errors()->getMessages() as $error) {
                $html .= "<li>$error[0]</li>";
            }
            $html .= "</ol>";

            alert()->html('Terjadi kesalahan eror!', $html, 'error')->autoClose(5000);
            return redirect()->route('poli.index');
        }
        try {
            $tambah = PoliModel::find($request->get('id'));
            $tambah->poli_name = $request->get('name');
            $tambah->save();

            alert()->warning('Sukses','Berhasil mengganti data.');
            return redirect()->route('poli.index');

        } catch (Exception  $th) {
            alert()->error('Error','Terjadi Kesalahan');
            return redirect()->route('poli.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        PoliModel::find($id)->delete();
        alert()->success('Sukses','Berhasil dihapus.');
        return redirect()->route('poli.index');
    }
}
