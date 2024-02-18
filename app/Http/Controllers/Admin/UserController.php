<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Bagian;
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
        $bagians=Bagian::all();
        return view("admin.user.create",compact('bagians'));
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
          
        ]);
     
        $file1 = $validatedData[('foto')];

        $filename1 =  $file1->getClientOriginalName();
        // File upload location
        $location1 = public_path('assets/profil/');
      

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
            'nama_bagian' => $request->input('nama_bagian'),
            'email'=> $request->input('nik').'@email.com'

        ]);
        $file1->move($location1, $filename1);
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
            $location1 = public_path('assets/profile/');

            // Move the new photo to the destination
            $file1->move($location1, $filename1);

            // Delete the old photo if it exists
            if ($user->foto) {
                unlink($location1 . $user->foto);
            }

            // Update the user's foto attribute
            $user->foto = $filename1;
        }

        // Update tanda_tangan if provided

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
