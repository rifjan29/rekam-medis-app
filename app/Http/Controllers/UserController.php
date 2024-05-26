<?php

namespace App\Http\Controllers;

use App\Models\PoliModel;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $param['title'] = 'List User';
        $query = User::when($search,function($query) use ($search) {
            $query->where('name','like','%'.$search.'%')
                 ->orWhere('email','like','%'.$search.'%');
        })->latest();
        $param['data'] = $query->paginate(10);

        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('users.index',$param);
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
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'no_hp' => 'required',
            'roles' => 'required|not_in:0',
            'nip' => 'required|max:16|unique:users,nip',
        ]);

        if ($validateData->fails()) {
            $html = "<ol class='max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400'>";
            foreach($validateData->errors()->getMessages() as $error) {
                $html .= "<li>$error[0]</li>";
            }
            $html .= "</ol>";

            alert()->html('Terjadi kesalahan eror!', $html, 'error')->autoClose(5000);
            return redirect()->route('user.index');
        }
        try {
            $tambah = new User;
            $tambah->name = $request->get('name');
            $tambah->nip = $request->get('nip');
            $tambah->email = $request->get('email');
            $tambah->role = $request->get('roles');
            $tambah->no_hp = $request->get('no_hp');
            $tambah->password = Hash::make($request->get('password'));
            $tambah->save();

            alert()->success('Sukses','Berhasil menambahkan data.');
            return redirect()->route('user.index');

        } catch (Exception $th) {
            alert()->error('Error','Terjadi Kesalahan');
            return redirect()->route('user.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $data = User::find($request->get('id'));
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $data = User::find($request->get('id'));
        return $data;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateData = Validator::make($request->all(),[
            'name' => 'required',
            'nip' => 'required|max:16',
            'email' => 'required',
            'no_hp' => 'required',
            'roles' => 'required|not_in:0',
        ]);

        if ($validateData->fails()) {
            $html = "<ol class='max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400'>";
            foreach($validateData->errors()->getMessages() as $error) {
                $html .= "<li>$error[0]</li>";
            }
            $html .= "</ol>";

            alert()->html('Terjadi kesalahan eror!', $html, 'error')->autoClose(5000);
            return redirect()->route('user.index');
        }
        try {
            $edit = User::find($request->get('id'));
            $edit->name = $request->get('name');
            $edit->nip = $request->get('nip');
            $edit->email = $request->get('email');
            $edit->role = $request->get('roles');
            $edit->no_hp = $request->get('no_hp');
            $edit->update();

            alert()->warning('Perhatian','Berhasil mengganti data.');
            return redirect()->route('user.index');

        } catch (Exception $th) {
            alert()->error('Error','Terjadi Kesalahan');
            return redirect()->route('user.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::find($id)->delete();
        alert()->success('Sukses','Berhasil dihapus.');
        return redirect()->route('user.index');
    }
}
