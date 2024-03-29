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
    <div class="container_izin">
        <p style="margin-left:65%">Karang Endah, {{ \Carbon\Carbon::parse($suratIzin->updated_at)->format('d-m-Y') }} 
        </p>
        <div class="kepada">
            <p> Kepada Yth,<br>
                Ibu Direktur RS. Islam Asy-Syifaa<br>
                Di<br>
                Tempat
            </p>
        </div>
        <p><b>Assalamu’alaikum Wr. Wb.</b></p>
        <p> Saya yang bertandatangan di bawah ini:</p>
        <p>Nama Pengaju : {{ $suratIzin->nama_pengaju }} <br>
            Bagian      : {{ $suratIzin->bagian }}
        </p>
        <div class="keterangan">
            <p>Bersama Surat ini Saya sampaikan bahwa pada tanggal <b>{{ \Carbon\Carbon::parse($suratIzin->tanggal_izin)->format('d-m-Y') }}</b> Saya tidak
                dapat bekerja seperti biasa,
                dikarenakan ada <b>{{ $suratIzin->keterangan }}</b>. Mohon kiranya Ibu Direktur dapat memberikan izin kepada
                Saya.
            </p>
        </div>
        <p>Demikian Surat ini Saya sampaikan, atas Izin yang diberikan saya ucapkan terima kasih.</p>
        <p><b>Wassalamu’alaikum Wr. Wb.</b></p>
        <div class="tanda_tangan">
            <div class="ttd_aju">
                <p> Menyetujui,<br>
                    Direktur Rs
                    <div class="kotak">
                        @if ($suratIzin->tanda_tangan_direktur)
                        <img style="height: 120px ; width:120px;"
                        src="{{ asset('assets/ttd/'.$suratIzin->tanda_tangan_direktur) }}"
                        alt="Tanda Tangan">
                        @else
                        @if (auth()->user()->jabatan=="Direktur")
                            
                        <form method="POST" action="{{route("PermohonanIzin.Sign",['id' => $suratIzin->id])}}">
                            @csrf
                            @method('put')
                            <button type="submit">Tanda Tangani</button>
                        </form>
                        <form method="POST" action="{{ route('PermohonanIzin.Tolak', ['id' => $suratIzin->id]) }}">
                            @csrf
                            @method('put')
                            <button type="submit">Tolak</button>
                        </form>
                        @endif
                        @endif

                    </div>
                    <b>dr. Imilia Sapitri, M.Kes</b>
                </p>
            </div>

        </div>
    </div>
</body>
</html>

@endsection
