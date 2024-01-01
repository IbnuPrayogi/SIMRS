<?php

namespace App\Http\Controllers\Karyawan;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class ProfileKaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function changePassword(Request $request)
    {

        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|different:password_lama',
        ]);


        $user = Auth::user();

        if (!Hash::check($request->password_lama, $user->password)) {
            return redirect()->back()->with('error', 'Kata sandi lama tidak cocok.');

        }
      

        $user->update(['password' => $request->password_baru]);

        return redirect()->back()->with('success', 'Kata sandi berhasil diubah.');
    }

    public function updateprofile(Request $request)
    {
        $user = Auth::user();

        // Validate the request data
        $request->validate([
            'nama_karyawan' => 'required|string',
            'alamat' => 'required|string',
         // Adjust file type and size as needed
        ]);




        $validatedData = $request->validate([

            'foto' => 'mimes:jpeg,png,jpg,gif|max:5120 ',
            'tanda_tangan' => 'mimes:jpeg,png,jpg,gif|max:5120 ',
        ]);

        // Update user data



                // Handle photo upload
        if ($request->hasFile('foto')) {
            // Delete old profile photo if it exists
            if ($user->foto) {
                File::delete(public_path('assets/profil/' . $user->foto));
            }
            $file1 = $validatedData[('foto')];


            $filename1 =  $file1->getClientOriginalName();

            // File upload location
            $location1 = '../public/assets/profil/';

            $file1->move(public_path($location1), $filename1);
            $user->foto = $filename1;



        }
        if ($request->hasFile('tanda_tangan')) {
            // Delete old profile photo if it exists
            if ($user->foto) {
                File::delete(public_path('assets/ttd/' . $user->tanda_tangan));
            }

            $file2 = $validatedData[('tanda_tangan')];

            $filename2 = $file2->getClientOriginalName();

            $location2 = '../public/assets/ttd/';
            $file2->move(public_path($location2), $filename2);
            $user->tanda_tangan = $filename2;

        }

        $user->update([
            'nama_karyawan' => $request->input('nama_karyawan'),
            'alamat' => $request->input('alamat'),


        ]);

        $user->save();




        return redirect()->back();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
