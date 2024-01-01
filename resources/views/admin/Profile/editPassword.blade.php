@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @elseif (session('successdelete'))
            <div class="alert alert-success">
                {{ session('successdelete') }}
            </div>
        @endif
        <!DOCTYPE html>
        <html>

        <head>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
            <link rel="stylesheet" href="css/arsip.css">
            <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
        </head>

        <body>

            <div class="container py-5" style="background-color: blue; border-radius: 25px;">

                <div class="container py-6">
                    <div class="card-header" style="background-color: blue; color: white;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div style="display: flex; align-items: center;">
                                <span class="font-weight-bold" style="font-size: 30px;">Kelola Pengguna >></span>
                                <span class="font" style="font-size: 20px;">Edit Pengguna</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row py-6">
                    <div class="col-lg-12 mx-auto">
                        <div class="card rounded shadow border-2">
                            <div class="card-body p-5 bg-white rounded">

                                <div class="container light-style flex-grow-1 container-p-y">
                                    <div class="card overflow-hidden"style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);">
                                        <div class="card-header"
                                            style="background-color: blue;color:white;text-align:center;border-radius:10px;">
                                            <h4>Edit Password</h4>
                                        </div>
                                        <div class="row no-gutters row-bordered row-border-light"
                                            style="justify-content: center">
                                            <div class="col-md-9">
                                                <form method="POST"
                                                    action="{{ route('Adminprofile.changePassword', auth()->user()->id) }}">
                                                    @csrf

                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label class="form-label">Password Lama</label>
                                                            <input type="password" class="form-control mb-1"
                                                                placeholder="Password Lama"
                                                                style="background-color: #CCD9EC" name="password_lama"
                                                                required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="form-label">Password Baru</label>
                                                            <input type="password" class="form-control mb-1"
                                                                placeholder="Password Baru"
                                                                style="background-color: #CCD9EC" name="password_baru"
                                                                required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="form-label">Konfirmasi Password Baru</label>
                                                            <input type="password" class="form-control mb-1"
                                                                placeholder="Password Baru"
                                                                style="background-color: #CCD9EC" name="konfirmasi_password"
                                                                required>
                                                        </div>
                                                    </div>

                                                    <div class="text-center mt-3 mb-4">
                                                        <button type="submit" class="btn btn-default"
                                                            style="background-color: blue;color:white">Save</button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        </body>

        </html>
    @endsection
