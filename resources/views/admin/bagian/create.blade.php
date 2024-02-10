@extends('layouts.app')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @elseif (session('successdelete'))
    <div class="alert alert-success">
        {{ session('successdelete') }}
    </div>
    @endif
    <section>
        <body>
            <div class="container py-5" style="background-color: blue; border-radius: 25px;">
                <div class="container py-6">
                    <div class="card-header" style="background-color: blue; color: white;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div style="display: flex; align-items: center;">
                                <a href="/arsip" style="text-decoration: none; margin-right: 10px;color:white">
                                    <i class="fa-sharp fa-solid fa-arrow-left" style="font-size: 30px;"></i>
                                </a>
                                <span class="font-weight-bold" style="font-size: 30px;">{{ $title }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <section>
                    <div class="container mt-5">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form  method="post" action="{{ route('bagian.store') }}"  enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group row">
                                                <label for="namaArsip" class="col-md-4 col-form-label">Nama Bagian</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" id="namaArsip"
                                                        placeholder="Nama Arsip" style="background-color: #E0E0E0;" name="nama_bagian">
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-default"
                                            style="background-color: blue;color:white">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </body>
    </section>
@endsection
