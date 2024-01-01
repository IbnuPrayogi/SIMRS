<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Template Surat Cuti</title>
  <link rel="stylesheet" href="{{ public_path('css/templatecuti.css') }}">
</head>
<body>
    <p style="position: absolute;
    height: fit-content;
    font-size: 11px;
    color: #02BA62;
    margin-left: 74%;">FORM.UM.RSAS.72</p>

    <img src="img/logo.png" alt="logo" style="position:absolute; width:80pxpx; height:80px; margin-top:45px"/>

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
                <p>Nama             : {{$suratCuti->nama_pengaju}}</p>
                <p>Bagian           : {{$suratCuti->bagian}}</p>
                <p>Jabatan          : {{$suratCuti->jabatan}}</p>
                <p>Alamat           : {{$suratCuti->alamat}}</p>
                <p>Tanggal Mulai    : {{$suratCuti->tanggal_mulai}}</p>
                <p>Tanggal Selesai  : {{$suratCuti->tanggal_selesai}}</p>
        </div>

        <div class="demikian">
            <p>Demikianlah surat permohonan ini saya buat dengan sesungguhnya, dikabulkannya permohonan ini saya
                ucapkan terimakasih. <br> <b>Wassalamu’alaikum Wr. Wb.</b>
            </p>
        </div>
        <div class="ttd_koor">
            <p>Mengetahui<br>
            Ka./Koor.Bagian:</p>
            <br><br>
        </div>
        <div class="ttd_pemohon">
            <p>Bandar Jaya,<br>
            Saya Yang Memohon</p>
            <p>
                @if ($suratCuti->tanda_tangan)
                    <img style="height: 120px ; width:120px;"
                        src="{{ public_path('img/' . $suratCuti->tanda_tangan) }}" alt="Tanda Tangan">
                @endif
            </p>
            <p>{{$suratCuti->nama_pengaju}}</p>
        </div>
    </div>
    </body>
</html>
