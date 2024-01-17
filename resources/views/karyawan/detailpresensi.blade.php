@extends('layouts.appdashboardmobile')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
<link rel="stylesheet" href="css/detailpresensi.css">

<div class="container">
    <div class="card-header">
        <h1><b>Presensi</b></h1>
    </div>
    <div class="card-body">
        @php
        $selectedMonth = request('selectedMonth', now()->format('m'));
    @endphp
    <div class="ket" style="display:flex;flex-direction:column;margin-bottom: -100px;">
        <h4 style="margin-top: 10px;margin-left: 17px;">Bulan : 1/1/2024 </h4>
        <h4 style="margin-top: 10px;margin-left: 17px;">Shift : Pagi</h4>
        <h4 style="margin-top: 10px;margin-left: 17px;">Status : Terlambat </h4>
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
                    <td><?php echo rand(8, 17) . ':00'; ?></td>
                    <td><?php echo rand(8, 17) . ':00'; ?></td>
                </tr>
    
                <!-- Baris 3 -->
                <tr>
                    <td>Check Out 1</td>
                    <td><?php echo rand(8, 17) . ':00'; ?></td>
                    <td><?php echo rand(8, 17) . ':00'; ?></td>
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
                    <td><?php echo rand(8, 17) . ':00'; ?></td>
                    <td><?php echo rand(8, 17) . ':00'; ?></td>
                </tr>
    
                <!-- Baris 6 -->
                <tr>
                    <td>Check Out 2</td>
                    <td><?php echo rand(8, 17) . ':00'; ?></td>
                    <td><?php echo rand(8, 17) . ':00'; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    
    

    </div>
</div>
@endsection