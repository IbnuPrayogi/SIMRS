@extends('layouts.appdashboardkabag')

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Template Surat Cuti</title>
    </head>

    <body>
        <div class="container_cuti">
            <p
                style="position: absolute;
                height: fit-content;
                font-size: 11px;
                color: #02BA62;
                margin-left: 46%;
                margin-top: -0.6rem;">
                FORM.UM.RSAS.72</p>

            <img src="{{ asset('img/logo.png') }}" alt="logo" style="position:absolute; width:80px; height:80px; margin-top:45px" />

            <div class="teks_header">
                <h1>RUMAH SAKIT ISLAM ASY-SYIFAA <br>(RSAS)</h1>
                <p>Jl. Lintas Sumatera KM 65 Yukumjaya - Lampung Tengah<br>
                    Telp. (0725) 25264 Fax. (0725) 527476</p>
            </div>
            <div class="code">
                <p>No. Kode RS : 180 50 24</p>
            </div>
            <div class="menkes">
                <p>Izin Menkes RI No. YM. 02.04.3.5.3858</p>
            </div>
            <div class="line"></div>
            <div class="line"></div>
            <div class="isi">
                <p>Perihal: <u><b>Permohonan Cuti</b></u></p>
                <div class="kepada">
                    <p> Kepada Yth,<br>
                        Direktur Rumah Sakit Islam Asy-Syifaa<br>
                        Di<br>
                    <div class="tempat">Bandar Jaya</div>
                    </p>
                </div>
                <div class="salam">
                    <p><b>Assalamu’alaikum Wr. Wb.</b> <br> Saya yang bertandatangan di bawah ini:</p>
                </div>
                <div class="box_pengaju">
                    <table>
                        <tr>
                            <td>Nama</td>
                            <td>: {{ $suratCuti->nama_pengaju }}</td>
                        </tr>
                        <tr>
                            <td>Bagian</td>
                            <td>: {{ $suratCuti->bagian }}</td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td>: {{ $suratCuti->jabatan }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>: {{ $suratCuti->alamat }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Mulai</td>
                            <td>: {{ \Carbon\Carbon::parse($suratCuti->tanggal_mulai)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Selesai</td>
                            <td>: {{ \Carbon\Carbon::parse($suratCuti->tanggal_selesai)->format('d-m-Y') }}</td>
                        </tr>
                    </table>
                </div>

                <div class="demikian">
                    <p>Demikianlah surat permohonan ini saya buat dengan sesungguhnya, dikabulkannya permohonan ini saya
                        ucapkan terimakasih. <br> <b>Wassalamu’alaikum Wr. Wb.</b>
                    </p>
                </div>
                <div class="ttd_cuti">
                    <div class="ttd_koor">
                        <p>Mengetahui<br>
                            Ka./Koor.Bagian:</p>
                            @if ($suratCuti->kepala_bagian)
                            <img style="height: 120px ; width:120px;"
                            src="{{ asset('assets/ttd/'.$suratCuti->kepala_bagian) }}"
                            alt="Tanda Tangan">
                            @else
                            <form method="POST" action="{{ route('PermohonanCuti.Sign', ['id' => $suratCuti->id]) }}">
                                @csrf
                                @method('put')
                                <button type="submit">Tanda Tangani</button>
                            </form>
                            <form method="POST" action="{{ route('PermohonanCuti.Tolak', ['id' => $suratCuti->id]) }}">
                                @csrf
                                @method('put')
                                <button type="submit">Tolak</button>
                            </form>
                            @endif

                        <br><br>
                    </div>
                    <div class="ttd_pemohon">
                        <p>Bandar Jaya,<br>
                            Saya Yang Memohon</p>
                        <p>
                            @if ($suratCuti->tanda_tangan)
                                <img style="height: 120px ; width:120px;" src="{{ asset('assets/ttd/'. $suratCuti->tanda_tangan) }}"
                                    alt="Tanda Tangan">
                            @endif
                        </p>
                        <p>{{ $suratCuti->nama_pengaju }}</p>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
@endsection
