@extends('layouts.app')

@section('content')

    <body>

        <div class="container py-5" style="background-color: blue; border-radius: 25px;">
            <section>
                <div class="container py-6">
                    <div class="card-header" style="background-color: blue; color: white;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div style="display: flex; align-items: center;">
                                <a href="/arsip" style="text-decoration: none; margin-right: 10px;color:white">
                                    <i class="fa-sharp fa-solid fa-arrow-left" style="font-size: 30px;"></i>
                                </a>
                                <span class="font-weight-bold" style="font-size: 30px;">Edit Bagian</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section>

                <body>
                    <div class="container mt-5">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('bagian.update', $bagian->id) }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group row">
                                                <label for="namabagian" class="col-md-4 col-form-label">Nama Bagian</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" id="namabagian"
                                                        name="nama_bagian" style="background-color: #E0E0E0;"
                                                        value="{{ $bagian->nama_bagian }}"
                                                        placeholder="{{ $bagian->nama_bagian }}">
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
                </body>
            </section>
    </body>
@endsection
