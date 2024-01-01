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
        
            <div class="pihak_memohon">
                <div class="ttd_A">
                    <p>Yang Memohon,
                    </p>
                    <p>
                        @if ($suratTukarJaga->tanda_tangan)
                        <img style="height: 120px ; width:120px;"
                        src="{{ asset('assets/ttd/'.$suratTukarJaga->tanda_tangan) }}"
                        alt="Tanda Tangan">
                        @endif
                    </p>
                    <b>{{ $suratTukarJaga->nama_pengaju }}</b>
                    <div class="line"></div>
                </div>


                <div class="ttd_B">
                    <p>Termohon,</p>
                    <p>
                        @if ($suratTukarJaga->termohon)
                        <img style="height: 120px ; width:120px;"
                        src="{{ asset('assets/ttd/' . $suratTukarJaga->termohon) }}"
                        alt="Tanda Tangan">
                        @elseif($suratTukarJaga->termohon == NULL && $suratTukarJaga->status =='Termohon')
                    <form method="POST" action="{{route("PermohonanTukarJaga.Sign",['id' => $suratTukarJaga->id,'jenis'=>'Termohon'])}}">
                        @csrf
                        @method('put')
                        <button type="submit">Tanda Tangani</button>
                    </form>
                    
                    @endif
                    </p>
                    <b>{{ $suratTukarJaga->target_tukar_jaga }}</b>
                    <div class="line"></div>
                </div>
            </div>

            <div class="pihak_termohon">
                <div class="ttd_kar">
                    <p>Ka. Ruangan</p>
                    <p>
                        @if ($suratTukarJaga->kepala_ruangan)
                        <img style="height: 120px ; width:120px;"
                        src="{{ asset('assets/ttd/' . $suratTukarJaga->kepala_ruangan) }}"
                        alt="Tanda Tangan">
                        @elseif($suratTukarJaga->kepala_ruangan == NULL && $suratTukarJaga->status =='Kepala Ruangan')
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
                    <b>{{ $suratTukarJaga->nama_kepala_ruangan }}</b>
                    <div class="line"></div>
                </div>


                <div class="ttd_kab">
                    <p>Ka. Bagian</p>
                    <p>
                        @if ($suratTukarJaga->kepala_bagian)
                        <img style="height: 120px ; width:120px;"
                        src="{{ asset('assets/ttd/' . $suratTukarJaga->kepala_bagian) }}"
                        alt="Tanda Tangan">
                        @elseif($suratTukarJaga->kepala_bagian == NULL && $suratTukarJaga->status =='Kepala Bagian')
                        <form method="POST" action="{{route("PermohonanTukarJaga.Sign",['id' => $suratTukarJaga->id,'jenis'=>'Kepala Bagian'])}}">
                            @csrf
                            @method('put')
                            <button type="submit">Tanda Tangani</button>
                        </form>
                        <form method="POST" action="{{ route('PermohonanTukarJaga.Tolak', ['id' => $suratTukarJaga->id,'jenis'=>'Kepala Bagian']) }}">
                            @csrf
                            @method('put')
                            <button type="submit">Tolak</button>
                        </form>
                        @endif
                    </p>
                    <b>{{ $suratTukarJaga->nama_kepala_bagian }}</b>
                    <div class="line"></div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>


@endsection
