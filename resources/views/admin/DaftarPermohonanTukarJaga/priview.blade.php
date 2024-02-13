@extends('layouts.appdashboardkabag')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Surat</title>
</head>

<body>
    <div class="container_tukarjaga">
    <div class="blangko">
        <p>BLANGKO TUKAR DINAS/TUKAR JAGA BAGIAN/RUANG ...............</p>
    </div>
    <div class="isi_tabel">
        <table>
            <tr style="border: 1px solid #02BA62;">
                <th style="border: 1px solid #02BA62;">Nama Karyawan</th>
                {{-- <th>Tgl</th> --}}
                <th style="border: 1px solid #02BA62;">Jadwal Asli</th>
                {{-- <th>Tgl</th> --}}
                <th style="border: 1px solid #02BA62;">Jadwal yang dirubah/diganti</th>
            </tr>
            <tr style="border: 1px solid #02BA62;">
                <td style="border: 1px solid #02BA62;">{{ $suratTukarJaga->nama_pengaju }}</td>
                {{-- <td>......</td> --}}
                {{-- <td>......</td> --}}
                <td style="border: 1px solid #02BA62;">{{ \Carbon\Carbon::parse($suratTukarJaga->jadwal_asli)->format('d-m-Y')}}</td>
                <td style="border: 1px solid #02BA62;">{{ \Carbon\Carbon::parse($suratTukarJaga->jadwal_dirubah)->format('d-m-Y')}}</td>

            </tr>
            <tr style="border: 1px solid #02BA62;">
                <th style="border: 1px solid #02BA62;">Nama Karyawan</th>
                {{-- <th>Tgl</th> --}}
                <th style="border: 1px solid #02BA62;">Jadwal Asli</th>
                {{-- <th>Tgl</th> --}}
                <th style="border: 1px solid #02BA62;">Jadwal yang dirubah/diganti</th>
            </tr>
            <tr style="border: 1px solid #02BA62;">
                <td style="border: 1px solid #02BA62;">{{ $suratTukarJaga->target_tukar_jaga}}</td>
                {{-- <td>......</td> --}}
                <td style="border: 1px solid #02BA62;">{{ \Carbon\Carbon::parse($suratTukarJaga->jadwal_dirubah)->format('d-m-Y')}}</td>
                {{-- <td>......</td> --}}
                <td style="border: 1px solid #02BA62;">{{ \Carbon\Carbon::parse($suratTukarJaga->jadwal_asli)->format('d-m-Y')}}</td>
            </tr>
        </table>
        <div class="atur_blanko">
            <p>Tgl. PENYERAHAN BLANKO</p>
            <div class="tgl_blangko"></div>
        


            <div class="pihak_termohon">
                <div class="ttd_kar">
                    <p>Direktur RS</p>
                    <p>
                        @if ($suratTukarJaga->tanda_tangan_direktur)
                        <img style="height: 120px ; width:120px;"
                        src="{{ asset('assets/ttd/' . $suratTukarJaga->kepala_ruangan) }}"
                        alt="Tanda Tangan">
                        @elseif($suratTukarJaga->tanda_tangan_direktur == NULL && $suratTukarJaga->status =='Direktur')
                        <form method="POST" action="{{route("PermohonanTukarJaga.Sign",['id' => $suratTukarJaga->id,'jenis'=>'Kepala Ruangan'])}}">
                            @csrf
                            @method('put')
                            <button type="submit">Tanda Tangani</button>
                        </form>
                        <form method="POST" action="{{ route('PermohonanTukarJaga.Tolak', ['id' => $suratTukarJaga->id,'jenis'=>'Kepala Ruangan']) }}">
                            @csrf
                            @method('put')
                            <button type="submit">Tolak</button>
                        </form>
                        @endif
                    </p>
                    <b>dr. Imilia Sapitri, M.Kes</b>
                    <div class="line"></div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>


@endsection
