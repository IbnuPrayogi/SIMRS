@extends('layouts.appdashboardkabag')

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
                    <div class="card-header" style="background-color: blue; color: white; border-bottom: 2px solid white;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="font-weight-bold" style="font-size: 30px;">Riwayat Status Surat</span>
                            </div>
            
                        </div>

                    </div><br>
                    <div class="row py-6">
                        <div class="col-lg-12 mx-auto">
                            <div class="card rounded shadow border-2">
                                <div class="card-body p-5 bg-white rounded">
                                    <div class="table-responsive">
                                        <table id="example" style="width: 100%"
                                            class="table table-striped table-bordered">

                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Surat</th>
                                                    <th>Deskripsi</th>
                                                    <th>Status</th>
                                                    <th>Tanggal Respon</th>
                        
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no = 1;
                                                @endphp
                                                @foreach ($surats as $surat)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $surat->nama_surat }}</td>
                                                        <td>{{ $surat->deskripsi }}</td>
                                                        <td>tersampaikan kepada {{ $surat->status }}</td>
                                                        <td>{{ $surat->created_at }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
