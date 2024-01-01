<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display Http\Client\Request
     */
    public function index()
    {
        $users = User::all();
        return view("admin.user.index", compact("users"));
    }

    public function create()
    {
        return view("admin.user.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required',
            'nama_karyawan' => 'required',
            'jabatan' => 'required',
            'nik' => 'required|unique:users,nik',
            'password' => 'required',
            'alamat' => 'required',
            'nomor_hp' => 'required',
            'nama_bagian' => 'required',
        ]);

        $validatedData = $request->validate([

            'foto' => 'required|mimes:jpeg,png,jpg,gif|max:5120 ',
            'tanda_tangan' => 'required|mimes:jpeg,png,jpg,gif|max:5120 ',
        ]);
     
        $file1 = $validatedData[('foto')];
        $file2 = $validatedData[('tanda_tangan')];

        $filename1 =  $file1->getClientOriginalName();
        $filename2 = $file2->getClientOriginalName();
        // File upload location
        $location1 = '../public/assets/profil/';
        $location2 = '../public/assets/ttd/';

        // Hash password secara otomatis melalui mutator pada model User
        // Jadi, tidak perlu melakukan Hash::make secara manual di sini

        // Buat user baru dengan menggunakan model User
        $user = User::create([
            'role' => $request->input('role'),
            'nama_karyawan' => $request->input('nama_karyawan'),
            'jabatan' => $request->input('jabatan'),
            'nik' => $request->input('nik'),
            'password' => $request->input('password'),
            'foto' => $filename1,
            'alamat' => $request->input('alamat'),
            'nomor_hp' => $request->input('nomor_hp'),
            'tanda_tangan' =>$filename2,
            'nama_bagian' => $request->input('nama_bagian'),
            'email'=> $request->input('nik').'@email.com'

        ]);
        $file1->move(public_path($location1), $filename1);
        $file2->move(public_path($location2), $filename2);
        Session::flash('success', 'Data User Berhasil Ditambahkan');

        // Redirect atau response sesuai kebutuhan aplikasi
        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user=User::find($id);
        return view('admin.user.detail',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($nik)
    {

        $user=User::where("nik",$nik)->first();

        return view("admin.user.update", compact("user"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required',
            'nama_karyawan' => 'required',
            'jabatan' => 'required',
            'nik' => 'required|unique:users,nik,'.$id,
            'alamat' => 'required',
            'nomor_hp' => 'required',
            'nama_bagian' => 'required',
        ]);

        $validatedData = $request->validate([
            'foto' => 'nullable|mimes:jpeg,png,jpg,gif|max:5120',
            'tanda_tangan' => 'nullable|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $user = User::find($id);


        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }

        // Update existing user data
        $user->role = $request->input('role');
        $user->nama_karyawan = $request->input('nama_karyawan');
        $user->jabatan = $request->input('jabatan');
        $user->nik = $request->input('nik');
        $user->alamat = $request->input('alamat');
        $user->nomor_hp = $request->input('nomor_hp');
        $user->nama_bagian = $request->input('nama_bagian');
        
        // Update foto if provided
        if ($request->hasFile('foto')) {
            $file1 = $validatedData['foto'];
            $filename1 = $file1->getClientOriginalName();
            $location1 = '../public/assets/profil/';

            // Move the new photo to the destination
            $file1->move(public_path($location1), $filename1);

            // Delete the old photo if it exists
            if ($user->foto) {
                unlink(public_path($location1 . $user->foto));
            }

            // Update the user's foto attribute
            $user->foto = $filename1;
        }

        // Update tanda_tangan if provided
        if ($request->hasFile('tanda_tangan')) {
            $file2 = $validatedData['tanda_tangan'];
            $filename2 = $file2->getClientOriginalName();
            $location2 = '../public/assets/ttd/';

            // Move the new tanda_tangan to the destination
            $file2->move(public_path($location2), $filename2);

            // Delete the old tanda_tangan if it exists
            if ($user->tanda_tangan) {
                unlink(public_path($location2 . $user->tanda_tangan));
            }

            // Update the user's tanda_tangan attribute
            $user->tanda_tangan = $filename2;
        }

        // Save the updated user
        $user->save();
        Session::flash('success', 'Data User Berhasil Diubah');
        return redirect()->route('user.index')->with('success', 'User berhasil diupdate.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = User::where('id', $id)->first();
        $data->delete();
        Session::flash('success', 'Data User Berhasil Dihapus');

        // $title = "Arsip";
        $arsips = User::all();
        // return view('admin.arsip.index',compact(['arsips','title']));
        return redirect()->back();
    }
}
