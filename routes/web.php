<?php

use App\Models\ListRequestLetter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\BagianController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KBJadwalController;
use App\Http\Controllers\PostDataController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ArsipController;
use App\Http\Controllers\StatusJadwalController;
use App\Http\Controllers\KaryawanJadwalController;
use App\Http\Controllers\Admin\DisposisiController;
use App\Http\Controllers\Admin\SuratMasukController;
use App\Http\Controllers\Admin\TemplateSKController;
use App\Http\Controllers\Admin\SuratKeluarController;
use App\Http\Controllers\ListRequestLetterController;
use App\Http\Controllers\Admin\ProfileAdminController;
use App\Http\Controllers\Karyawan\SuratCutiController;
use App\Http\Controllers\Karyawan\SuratIzinController;
use App\Http\Controllers\Karyawan\StatusSuratController;
use App\Http\Controllers\KepalaBagian\KBProfileController;
use App\Http\Controllers\Karyawan\SuratTukarJagaController;
use App\Http\Controllers\Karyawan\ProfileKaryawanController;
use App\Http\Controllers\KepalaBagian\KBDisposisiController;
use App\Http\Controllers\KepalaBagian\KBSuratMasukController;
use App\Http\Controllers\KepalaBagian\KBTemplateSKController;
use App\Http\Controllers\KepalaBagian\KBSuratKeluarController;



Route::get('presensi/fetch/{selectedMonth}/{selectedYear}', [PresensiController::class, 'fetch'])
    ->name('presensi.fetch')->withoutMiddleware(['auth']);
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('admin.index');
Route::get('/', function () {
    return view('auth.login');
});

    // Route di sini akan menerapkan middleware 'api' (termasuk CorsMiddleware)
    

    Route::get('bagiandata/fetch', [PostDataController::class, 'storebagian'])
    ->name('bagians.fetch');
    Route::get('userdata/fetch', [PostDataController::class, 'storeuser'])
    ->name('users.fetch');

    Route::get('presensi/take/{bulan}/{tahun}', [PresensiController::class, 'fetchData'])
    ->name('presensi.ambildata');





Route::middleware(['auth', 'role:1'])->group(function () {
    Route::get('/dashboardadmin', function () {
        return view('admin.index');
    });


    Route::get('/welcome', function () {
        return view('welcome');
    });
    Route::get('/welcome2', function () {
        return view('test');
    });
    Route::get('/send', [ChatController::class, 'sendWhatsAppMessage']);
    Route::get('/sendsms', [SMSController::class, 'sendSMS']);

    Route::resource('arsip', ArsipController::class);
    Route::get('/arsip/{id}/{file}', [ArsipController::class, 'downloadarsip'])->name('arsipdownload');

    Route::resource('bagian', BagianController::class);

    Route::resource('shift', ShiftController::class);
    Route::resource('presensi', PresensiController::class);
    Route::post('/presensi/rekap', [PresensiController::class, 'rekap'])->name('presensi.rekap');

    

    Route::resource('jadwal', JadwalController::class);
    Route::get('/jadwal/download/file', [JadwalController::class, 'download'])->name('jadwal.download');
    Route::get('/jadwal/edit/{bulan}', [JadwalController::class, 'editjadwal'])->name('jadwal.editjadwal');
    Route::post('/jadwal/import/import-sql-table', [JadwalController::class, 'importTable'])->name('jadwal.importsql');

    Route::resource('statusjadwal', StatusJadwalController::class);
    Route::post('/statusjadwal/lock', [StatusJadwalController::class, 'kunci'])->name('statusjadwal.lock');
    Route::post('/statusjadwal/unlock', [StatusJadwalController::class, 'buka'])->name('statusjadwal.unlock');
    Route::post('/statusjadwal/lockall', [StatusJadwalController::class, 'kuncisemua'])->name('statusjadwal.lockall');


    Route::resource('suratmasuk', SuratMasukController::class);
    Route::get('/suratmasuk/download/{id}/{file}', [SuratMasukController::class, 'downloadsuratmasuk'])->name('suratmasukdownload');

    Route::get('/disposisi/add/{id}/{jenis}', [DisposisiController::class, 'tambah'])->name('disposisi.tambah');
    Route::post('/disposisi/store/{id}/{jenis}', [DisposisiController::class, 'store'])->name('disposisi.tambahdisposisi');
    Route::get('/disposisi/showsurat/{id}/{nama}', [DisposisiController::class, 'showsurat'])->name('disposisi.showsurat');

    // Route::resource('User-Profile', ProfileAdminController::class);
    // Route::resource('User-Profile', ProfileAdminController::class);
    Route::get('/User-Profile', [ProfileAdminController::class, 'index'])->name('profile.user');
    Route::put('/User-Profile', [ProfileAdminController::class, 'update'])->name('Adminprofile.update');
    Route::get('/User-Profile/GantiPassword', [ProfileAdminController::class, 'EditPassword'])->name('profile.EditPassword');
    Route::post('/User-Profile/GantiPassword', [ProfileAdminController::class, 'changePassword'])->name('Adminprofile.changePassword');



    Route::resource('user', UserController::class);
    Route::resource('disposisi', DisposisiController::class);
    Route::get('/disposisi/add/{id}/{jenis}', [DisposisiController::class, 'tambah'])->name('disposisi.tambah');
    Route::post('/disposisi/store/{id}/{jenis}', [DisposisiController::class, 'store'])->name('disposisi.tambahdisposisi');
    Route::get('/disposisi/showsurat/{id}/{nama}', [DisposisiController::class, 'showsurat'])->name('disposisi.showsurat');


    Route::resource('suratkeluar', SuratKeluarController::class);
    Route::get('/suratkeluar/download/{id}/{file}', [SuratKeluarController::class, 'downloadSurat'])->name('suratkeluar.download');
    Route::get('/formtemplate', [SuratKeluarController::class, 'template'])->name('template');


    route::resource('templateSK', TemplateSKController::class);
    Route::get('/templateSk/show', [TemplateSKController::class, 'showDesk'])->name('templateSK.showDesk');
    // Route::post('/templateSk/{id}', [TemplateSKController::class, 'template'])->name('templateSK.template');
    // Route::post('/templateSk/{id}', [TemplateSKController::class, 'storeTemplate'])->name('templateSK.storeSK');
    Route::post('/templateSk/storenew', [TemplateSKController::class, 'storeSKnew'])->name('templateSK.storeSKnew');
    Route::post('/templateSk', [TemplateSKController::class, 'storeSKForm'])->name('templateSK.storeSKForm');
    Route::get('/template/priview/{id}', [TemplateSKController::class, 'priview'])->name('templateSK.priview');
    Route::put('/template/sign/{id}', [TemplateSKController::class, 'Sign'])->name('templateSK.Sign');
    // Route::get('/suratkeluar/{id}', [TemplateSKController::class, 'signature'])->name('templateSK.signature');

    // Route::resource('profile' , ProfileAdminController::class);



});


Route::middleware(['auth', 'role:2'])->group(function () {

    Route::resource('kbsuratkeluar', KBSuratKeluarController::class);
    Route::resource('kbdisposisi', KBDisposisiController::class);
    Route::resource('kbjadwal', KBJadwalController::class);
    Route::get('/kbjadwal/download/file', [KBJadwalController::class, 'download'])->name('kbjadwal.download');
    Route::get('/kbjadwal/edit/{bulan}/{tahun}', [KBJadwalController::class, 'editjadwal'])->name('kbjadwal.editjadwal');
    Route::post('/kbjadwal/import/import-sql-table', [KBJadwalController::class, 'importTable'])->name('kbjadwal.importsql');
    Route::get('/kbdisposisi/add/{id}/{jenis}', [KBDisposisiController::class, 'tambah'])->name('kbdisposisi.tambah');
    Route::get('/kbdisposisi/showsurat/{id}/{nama}', [KBDisposisiController::class, 'showsurat'])->name('kbdisposisi.showsurat');
    Route::post('/kbdisposisi/store/{id}/{jenis}', [KBDisposisiController::class, 'store'])->name('kbdisposisi.tambahdisposisi');
    Route::get('/kbsuratkeluar/download/{id}/{file}', [KBSuratKeluarController::class, 'downloadSurat'])->name('kbsuratkeluar.download');

    Route::resource('kbsuratmasuk', KBSuratMasukController::class);
    Route::get('/kbsuratmasuk/download/{id}/{file}', [KBSuratMasukController::class, 'downloadsuratmasuk'])->name('kbsuratmasukdownload');

    Route::get('/Profile-Pengguna', [KBProfileController::class, 'index'])->name('KBprofile.user');
    Route::put('/Profile-Pengguna', [KBProfileController::class, 'update'])->name('KBprofile.update');
    Route::get('/Profile-Pengguna/GantiPassword', [KBProfileController::class, 'EditPassword'])->name('KBprofile.EditPassword');
    Route::post('/Profile-Pengguna/GantiPassword', [KBProfileController::class, 'changePassword'])->name('KBprofile.changePassword');



    route::resource('kbtemplateSK', TemplateSKController::class);
    Route::get('/kbtemplateSk/show', [TemplateSKController::class, 'showDesk'])->name('kbtemplateSK.showDesk');
    // Route::post('/templateSk/{id}', [TemplateSKController::class, 'template'])->name('templateSK.template');
    // Route::post('/templateSk/{id}', [TemplateSKController::class, 'storeTemplate'])->name('templateSK.storeSK');
    Route::post('/kbtemplateSk/storenew', [TemplateSKController::class, 'storeSKnew'])->name('kbtemplateSK.storeSKnew');
    Route::post('/kbtemplateSk', [TemplateSKController::class, 'storeSKForm'])->name('kbtemplateSK.storeSKForm');
    Route::get('/kbtemplate/priview/{id}', [TemplateSKController::class, 'priview'])->name('kbtemplateSK.priview');
    Route::put('/kbtemplate/sign/{id}', [TemplateSKController::class, 'Sign'])->name('kbtemplateSK.Sign');



    Route::get('/suratizin/priview/{id}', [SuratIzinController::class, 'priview'])->name('PermohonanIzin.priview');
    Route::put('/suratizin/sign/{id}', [SuratIzinController::class, 'Sign'])->name('PermohonanIzin.Sign');
    Route::put('/suratizin/tolak/{id}', [SuratIzinController::class, 'Tolak'])->name('PermohonanIzin.Tolak');
    Route::get('/suratizin/{id}/{file}', [SuratIzinController::class, 'downloadSuratIzin'])->name('PermohonanIzin.download');


    Route::get('/suratcuti/priview/{id}', [SuratCutiController::class, 'priview'])->name('PermohonanCuti.priview');
    Route::put('/suratcuti/sign/{id}', [SuratCutiController::class, 'Sign'])->name('PermohonanCuti.Sign');
    Route::put('/suratcuti/tolak/{id}', [SuratCutiController::class, 'Tolak'])->name('PermohonanCuti.Tolak');
    Route::get('/suratcuti/{id}/{file}', [SuratCutiController::class, 'downloadSuratCuti'])->name('PermohonanCuti.download');


    Route::get('/surattukarjaga/priview/{id}', [SuratTukarJagaController::class, 'priview'])->name('PermohonanTukarJaga.priview');
    Route::put('/surattukarjaga/sign/{id}/{jenis}', [SuratTukarJagaController::class, 'Sign'])->name('PermohonanTukarJaga.Sign');
    Route::put('/surattukarjaga/tolak/{id}/{jenis}', [SuratTukarJagaController::class, 'TolakTukarJaga'])->name('PermohonanTukarJaga.Tolak');
    Route::get('/surattukarjaga/{id}/{file}', [SuratTukarJagaController::class, 'downloadSuratTukarJaga'])->name('PermohonanTukarJaga.download');

    Route::resource('DaftarPermohonan', ListRequestLetterController::class);
    Route::get('/DaftarPermohonanCuti', [ListRequestLetterController::class, 'indexCuti'])->name('DaftarPermohonan.indexCuti');
    Route::get('/DaftarPermohonanTukarJaga', [ListRequestLetterController::class, 'indexTukarJaga'])->name('DaftarPermohonan.indexTukarJaga');
    Route::get('/DaftarPermohonanIzin', [ListRequestLetterController::class, 'indexIzin'])->name('DaftarPermohonan.indexIzin');
});


Route::middleware(['auth', 'role:3'])->group(function () {
    Route::resource('karyawanjadwal', KaryawanJadwalController::class);
    Route::resource('suratizin', SuratIzinController::class);
    Route::resource('suratcuti', SuratCutiController::class);
    Route::resource('surattukarjaga', SuratTukarJagaController::class);
    Route::get('/pengajuansurat/buatsurat', [StatusSuratController::class, 'create'])->name('statussurat.create');
    Route::get('/statuscuti/{id}', [StatusSuratController::class, 'statuscuti'])->name('status.cuti');
    Route::get('/statusizin/{id}', [StatusSuratController::class, 'statusizin'])->name('status.izin');
    Route::get('/statustukarjaga/{id}', [StatusSuratController::class, 'statustukarjaga'])->name('status.tukarjaga');
    Route::get('/statuscuti/download/{id}/{file}', [StatusSuratController::class, 'downloadSuratCuti'])->name('statuscuti.download');
    Route::get('/statusizin/download/{id}/{file}', [StatusSuratController::class, 'downloadSuratIzin'])->name('statusizin.download');
    Route::get('/statustukarjaga/download/{id}/{file}', [StatusSuratController::class, 'downloadSuratTukarJaga'])->name('statustukarjaga.download');
    Route::delete('statuscuti/destroy/{id}', [StatusSuratController::class, 'destroyCuti'])->name('statuscuti.destroy');
    Route::delete('statusizin/destroy/{id}', [StatusSuratController::class, 'destroyIzin'])->name('statusizin.destroy');
    Route::delete('statustukarjaga/destroy/{id}', [StatusSuratController::class, 'destroyTukarJaga'])->name('statustukarjaga.destroy');
    Route::post('/changepassword', [ProfileKaryawanController::class, 'changePassword'])->name('change.password');

    
    Route::get('/presensi/karyawan/detail', [PresensiController::class, 'indexkaryawan'])->name('presensi.karyawan');
    Route::get('/presensi/karyawan/detail/{id}/{shift}', [PresensiController::class, 'detailpresensi'])->name('detail.presensi');
    

    Route::resource('profile', SuratIzinController::class);
    Route::put('/updateprofile', [ProfileKaryawanController::class, 'updateprofile'])->name('update.profile');
    Route::get('/permintaantukarjaga', [SuratTukarJagaController::class, 'permintaantukarjaga'])->name('tukarjaga.permintaan');
    Route::put('/permintaansurattukarjaga/setujui/{id}', [SuratTukarJagaController::class, 'setujui'])->name('setujui.tukarjaga');
    Route::put('/permintaansurattukarjaga/tolak/{id}', [SuratTukarJagaController::class, 'tolak'])->name('tolak.tukarjaga');


    Route::get('/buatpengajuansurat', function () {
        return view('karyawan.buatpengajuan');
    })->name('lihat.pengajuan');
    Route::get('/status', function () {
        return view('karyawan.lihatstatusmobile');
    });
    Route::get('/profile', function () {
        return view('karyawan.profilemobile');
    });

    Route::get('/tukarjaga', function () {
        return view('karyawan.statustukarjagamobile');
    });
    Route::get('/cuti', function () {
        return view('karyawan.statuscutimobile');
    });
    Route::get('/izin', function () {
        return view('karyawan.statusizinmobile');
    });
    Route::get('/permintaan', function () {
        return view('karyawan.permintaan');
    });
    Route::get('/pengajuan', function () {
        return view('karyawan.buatpengajuan');
    });

  
    
});

// route::resource('suratkeluar', SuratKeluarController::class);
// Route::get('/suratkeluar/{id}/{file}', [SuratKeluarController::class, 'downloadSurat'])->name('Suratkeluar.download');


// route::resource('templateSK', TemplateSKController::class);
// Route::get('/templateSk', [TemplateSKController::class, 'showDesk'])->name('templateSK.showDesk');
// // Route::post('/templateSk/{id}', [TemplateSKController::class, 'template'])->name('templateSK.template');
// // Route::post('/templateSk/{id}', [TemplateSKController::class, 'storeTemplate'])->name('templateSK.storeSK');
// Route::post('/templateSk', [TemplateSKController::class, 'storeSKnew'])->name('templateSK.storeSKnew');
// Route::post('/templateSk/{id}', [TemplateSKController::class, 'storeSKForm'])->name('templateSK.storeSKForm');
// Route::get('/template/priview/{id}', [TemplateSKController::class, 'priview'])->name('templateSK.priview');
// Route::put('/template/priview/{id}', [TemplateSKController::class, 'Sign'])->name('templateSK.Sign');
// // Route::get('/suratkeluar/{id}', [TemplateSKController::class, 'signature'])->name('templateSK.signature');
