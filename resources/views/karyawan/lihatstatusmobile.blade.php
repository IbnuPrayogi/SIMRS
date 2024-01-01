@extends('layouts.appdashboardmobile')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
<link rel="stylesheet" href="css/homemobile.css">

<div class="container">
    <div class="card-header">
        <h1><b>Lihat Status</b></h1>
    </div>
    <div class="card-body">
        <div class="card-content">
            <h2>Tukar Jaga</h2>
            <a href="{{ route('status.tukarjaga',['id'=>auth()->user()->id]) }}"><i class='bx bx-right-arrow-circle' ></i></a>
        </div>
        <div class="card-content">
            <h2>Permohonan Cuti</h2>
            <a href="{{ route('status.cuti',['id'=>auth()->user()->id]) }}"><i class='bx bx-right-arrow-circle' ></i></a>
        </div>
        <div class="card-content">
            <h2>Permohonan Izin</h2>
            <a href="{{ route('status.izin',['id'=>auth()->user()->id]) }}"><i class='bx bx-right-arrow-circle' ></i></a>
        </div>
    </div>
</div>
@endsection