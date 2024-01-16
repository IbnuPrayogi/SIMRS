@extends('layouts.appdashboardmobile')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
<link rel="stylesheet" href="css/presensi.css">

<div class="container">
    <div class="card-header">
        <h1><b>Presensi</b></h1>
    </div>
    <div class="card-body">
        @php
        $selectedMonth = request('selectedMonth', now()->format('m'));
    @endphp
    
    <h4 style="margin-top: 20px;margin-left: 17px;">Bulan 
        <select id="selectMonth" onchange="updateTable()" value="{{ $selectedMonth }}" style="font-size: 20px">
            @for ($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}" {{ $selectedMonth == $i ? 'selected' : '' }}>
                    {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                </option>
            @endfor
        </select>
    </h4>

    <table>
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Shift</th>
          <th>Status</th>
          <th>Detail</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>Pagi</td>
          <td>Masuk</td>
          <td>
            <button class="detail-button">
              <i class="fas fa-eye"></i> Detail
            </button>
          </td>
        </tr>
        <tr>
            <td>2</td>
            <td>Malam</td>
            <td>Telat</td>
            <td>
              <button class="detail-button">
                <i class="fas fa-eye"></i> Detail
              </button>
            </td>
          </tr>
      </tbody>
    </table>
  
    <!-- Sertakan ikon mata (eye) dari Font Awesome -->
    <script src="https://kit.fontawesome.com/your-font-awesome-kit-id.js" crossorigin="anonymous"></script>
  

    </div>
</div>
@endsection