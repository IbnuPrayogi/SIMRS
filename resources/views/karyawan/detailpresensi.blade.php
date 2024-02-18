@extends('layouts.appdashboardmobile')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
<link rel="stylesheet" href="{{ asset('css/detailpresensi.css') }}">

<div class="container">
    <div class="card-header">
        <h1><b>Presensi</b></h1>
    </div>
    <div class="card-body">
        @php
        $selectedMonth = request('selectedMonth', now()->format('m'));
    @endphp
    <div class="ket" style="display:flex;flex-direction:column;margin-bottom: -100px;">
        <h4 style="margin-top: 10px;margin-left: 17px;">Bulan : {{ $presensi->tanggal }} </h4>
        <h4 style="margin-top: 10px;margin-left: 17px;">Shift : {{ $shifts->nama }}</h4>
        <h4 style="margin-top: 10px;margin-left: 17px;">Status : {{ $presensi->status }} </h4>
    </div>
    
    <div class="tab">
        <table>
            <thead>
                <tr>
                    <th> </th>
                    <th>Jadwal</th>
                    <th>Presensi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Baris 2 -->
                <tr>
                    <td>Check In 1</td>
                    <td>{{ $shifts->cin1 }}</td>
                    <td>{{ $presensi->cin1 }}</td>
                </tr>
    
                <!-- Baris 3 -->
                <tr>
                    <td>Check Out 1</td>
                    <td>{{ $shifts->cout1 }}</td>
                    <td>{{ $presensi->cout1 }}</td>
                </tr>
    
                <!-- Baris 4 -->
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
    
                <!-- Baris 5 -->
                <tr>
                    <td>Check In 2</td>
                    <td>{{ $shifts->cin2 }}</td>
                    <td>{{ $presensi->cin2 }}</td>
                </tr>
    
                <!-- Baris 6 -->
                <tr>
                    <td>Check Out 2</td>
                    <td>{{ $shifts->cout2 }}</td>
                    <td>{{ $presensi->cout2 }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    
    

    </div>
</div>
@endsection