<?php
if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}

use App\Http\Controllers\AkreditasiController;
use App\Http\Controllers\AplikasiIntegrasiController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumenProdiController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\HasilKaryaController;
use App\Http\Controllers\HimpunanMahasiswaController;
use App\Http\Controllers\LaboratoriumController;
use App\Http\Controllers\InformasiBeasiswaController;
use App\Http\Controllers\JadwalKuliahController;
use App\Http\Controllers\JadwalUjianController;
use App\Http\Controllers\JadwalKegiatanController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\ProsidingController;
use App\Http\Controllers\HakiController;
use App\Http\Controllers\KalenderAkademikController;
use App\Http\Controllers\KelompokKeahlianDosenController;
use App\Http\Controllers\KemitraanController;
use App\Http\Controllers\KerjasamaMitraKolaborasiController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\KurikulumController;
use App\Http\Controllers\LayananMahasiswaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\PenelitianController;
use App\Http\Controllers\PengabdianKeMasyarakatController;
use App\Http\Controllers\PerpustakaanController;
use App\Http\Controllers\ProfilLulusanController;
use App\Http\Controllers\RepositoryKerjaPraktikController;
use App\Http\Controllers\RepositorySkripsiController;
use App\Http\Controllers\ProfilSingkatController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\RuangLabController;
use App\Http\Controllers\RuangStafDanDosenController;
use App\Http\Controllers\RuangPerkuliahanController;
use App\Http\Controllers\SambutanPimpinanInstansiController;
use App\Http\Controllers\SejarahController;
use App\Http\Controllers\StafController;
use App\Http\Controllers\StrukturInstansiController;
use App\Http\Controllers\TataTertibPeraturanController;
use App\Http\Controllers\VideoProfilController;
use App\Http\Controllers\VisiMisiController;
use App\Http\Controllers\SeminarProposalController;
use App\Http\Controllers\SidangAkhirController;
use App\Http\Controllers\KerjaPraktikController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InformasiTerbaruController;
use App\Http\Controllers\UnduhanTerbaruController;
use App\Http\Controllers\PencarianController;
use App\Http\Controllers\LaboratoriumSingkatController;


//Admin
Route::get('/admin', [LoginController::class, 'index']);

//Login Management
Route::get('/admin/login', function () {
    return view('/admin/login.index');
})->name('login');

Route::post('/admin/postlogin', [LoginController::class, 'postLogin'])->name('postlogin');
Route::get('/admin/logout', [LoginController::class, 'logOut'])->name('logout');


//Menu Admin
Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::post('/admin/hasil_karya/{hasilKarya}/restore', [HasilKaryaController::class, 'restore']);
    Route::post('/admin/hasil_karya/{hasilKarya}/delete_permanen', [HasilKaryaController::class, 'deletePermanen']);

    Route::post('/admin/kerjasama_mitra_kolaborasi/{kerjasamaMitraKolaborasi}/restore', [KerjasamaMitraKolaborasiController::class, 'restore']);
    Route::post('/admin/kerjasama_mitra_kolaborasi/{kerjasamaMitraKolaborasi}/delete_permanen', [KerjasamaMitraKolaborasiController::class, 'deletePermanen']);

    Route::post('/admin/akreditasi/{akreditasi}/restore', [AkreditasiController::class, 'restore']);
    Route::post('/admin/akreditasi/{akreditasi}/delete_permanen', [AkreditasiController::class, 'deletePermanen']);

    Route::post('/admin/seminar_proposal/{seminar_proposal}/restore', [SeminarProposalController::class, 'restore']);
    Route::post('/admin/seminar_proposal/{seminar_proposal}/delete_permanen', [SeminarProposalController::class, 'deletePermanen']);

    Route::post('/admin/sidang_akhir/{sidang_akhir}/restore', [SidangAkhirController::class, 'restore']);
    Route::post('/admin/sidang_akhir/{sidang_akhir}/delete_permanen', [SidangAkhirController::class, 'deletePermanen']);

    Route::post('/admin/kerja_praktik/{kerja_praktik}/restore', [KerjaPraktikController::class, 'restore']);
    Route::post('/admin/kerja_praktik/{kerja_praktik}/delete_permanen', [KerjaPraktikController::class, 'deletePermanen']);

    Route::post('/admin/kurikulum/mata_kuliah/tambah', [KurikulumController::class, 'tambahMataKuliah']);

    Route::patch('/admin/kurikulum/mata_kuliah/{mataKuliah}', [KurikulumController::class, 'updateMataKuliah']);

    Route::delete('/admin/kurikulum/mata_kuliah/{mataKuliah}', [KurikulumController::class, 'deleteMataKuliah']);

    Route::post('/admin/kurikulum/mata_kuliah/{mataKuliah}/restore', [KurikulumController::class, 'restoreMataKuliah']);

    Route::post('/admin/kurikulum/mata_kuliah/{mataKuliah}/delete_permanen', [KurikulumController::class, 'deletePermanenMataKuliah']);

    Route::post('/admin/kalender_akademik/{prodi}/restore', [KalenderAkademikController::class, 'restore']);
    Route::post('/admin/kalender_akademik/{mataKuliah}/delete_permanen', [KalenderAkademikController::class, 'deletePermanen']);

    Route::post('/admin/aplikasi_integrasi/{aplikasi_integrasi}/restore', [AplikasiIntegrasiController::class, 'restore']);
    Route::post('/admin/aplikasi_integrasi/{aplikasi_integrasi}/delete', [AplikasiIntegrasiController::class, 'delete']);

    Route::post('/admin/berita/{berita}/restore', [BeritaController::class, 'restore']);
    Route::post('/admin/berita/{berita}/delete', [BeritaController::class, 'delete']);

    Route::post('/admin/blog/{blog}/restore', [BlogController::class, 'restore']);
    Route::post('/admin/blog/{blog}/delete', [BlogController::class, 'delete']);

    Route::post('/admin/dokumen_prodi/{dokumen_prodi}/restore', [DokumenProdiController::class, 'restore']);
    Route::post('/admin/dokumen_prodi/{dokumen_prodi}/delete', [DokumenProdiController::class, 'delete']);

    Route::post('/admin/informasi_beasiswa/{informasi_beasiswa}/restore', [InformasiBeasiswaController::class, 'restore']);
    Route::post('/admin/informasi_beasiswa/{informasi_beasiswa}/delete', [InformasiBeasiswaController::class, 'delete']);

    Route::post('/admin/jurnal/{jurnal}/restore', [JurnalController::class, 'restore']);
    Route::post('/admin/jurnal/{jurnal}/delete', [JurnalController::class, 'delete']);
    
    Route::post('/admin/buku/{buku}/restore', [BukuController::class, 'restore']);
    Route::post('/admin/buku/{buku}/delete', [BukuController::class, 'delete']);
    
    Route::post('/admin/prosiding/{prosiding}/restore', [ProsidingController::class, 'restore']);
    Route::post('/admin/prosiding/{prosiding}/delete', [ProsidingController::class, 'delete']);

    Route::post('/admin/haki/{haki}/restore', [HakiController::class, 'restore']);
    Route::post('/admin/haki/{haki}/delete', [HakiController::class, 'delete']);

    Route::post('/admin/layanan_mahasiswa/{layanan_mahasiswa}/restore', [LayananMahasiswaController::class, 'restore']);
    Route::post('/admin/layanan_mahasiswa/{layanan_mahasiswa}/delete', [LayananMahasiswaController::class, 'delete']);

    Route::post('/admin/penelitian/{penelitian}/restore', [PenelitianController::class, 'restore']);
    Route::post('/admin/penelitian/{penelitian}/delete', [PenelitianController::class, 'delete']);

    Route::post('/admin/pengabdian_kepada_masyarakat/{pengabdian_kepada_masyarakat}/restore', [PengabdianKeMasyarakatController::class, 'restore']);
    Route::post('/admin/pengabdian_kepada_masyarakat/{pengabdian_kepada_masyarakat}/delete', [PengabdianKeMasyarakatController::class, 'delete']);

    Route::post('/admin/profil_lulusan/{profil_lulusan}/restore', [ProfilLulusanController::class, 'restore']);
    Route::post('/admin/profil_lulusan/{profil_lulusan}/delete', [ProfilLulusanController::class, 'delete']);

    Route::post('/admin/repository_kerja_praktik/{repository_kerja_praktik}/restore', [RepositoryKerjaPraktikController::class, 'restore']);
    Route::post('/admin/repository_kerja_praktik/{repository_kerja_praktik}/delete', [RepositoryKerjaPraktikController::class, 'delete']);

    Route::post('/admin/repository_skripsi/{repository_skripsi}/restore', [RepositorySkripsiController::class, 'restore']);
    Route::post('/admin/repository_skripsi/{repository_skripsi}/delete', [RepositorySkripsiController::class, 'delete']);

    Route::post('/admin/galeri/{galeri}/restore', [GaleriController::class, 'restore']);
    Route::post('/admin/galeri/{galeri}/delete', [GaleriController::class, 'delete']);

    Route::post('/admin/kemitraan/{kemitraan}/restore', [KemitraanController::class, 'restore']);
    Route::post('/admin/kemitraan/{kemitraan}/delete', [KemitraanController::class, 'delete']);

    Route::post('/admin/banner/{banner}/restore', [BannerController::class, 'restore']);
    Route::post('/admin/banner/{banner}/delete', [BannerController::class, 'delete']);

    Route::post('/admin/quote/{quote}/restore', [QuoteController::class, 'restore']);
    Route::post('/admin/quote/{quote}/delete', [QuoteController::class, 'delete']);

    Route::post('/admin/jadwal_ujian/{jadwal_ujian}/restore', [JadwalUjianController::class, 'restore']);
    Route::post('/admin/jadwal_ujian/{jadwal_ujian}/delete', [JadwalUjianController::class, 'delete']);

    Route::post('/admin/jadwal_kuliah/{jadwal_kuliah}/restore', [JadwalKuliahController::class, 'restore']);
    Route::post('/admin/jadwal_kuliah/{jadwal_kuliah}/delete', [JadwalKuliahController::class, 'delete']);

    Route::post('/admin/jadwal_kegiatan/{jadwal_kegiatan}/restore', [JadwalKegiatanController::class, 'restore']);
    Route::post('/admin/jadwal_kegiatan/{jadwal_kegiatan}/delete', [JadwalKegiatanController::class, 'delete']);

    Route::post('/admin/tata_tertib_peraturan/{tata_tertib_peraturan}/restore', [TataTertibPeraturanController::class, 'restore']);
    Route::post('/admin/tata_tertib_peraturan/{tata_tertib_peraturan}/delete', [TataTertibPeraturanController::class, 'delete']);

    Route::post('/admin/laboratorium/{laboratorium}/restore', [LaboratoriumController::class, 'restore']);
    Route::post('/admin/laboratorium/{laboratorium}/delete_permanen', [LaboratoriumController::class, 'delete']);

    Route::post('/admin/dosen/{dosen}/restore', [DosenController::class, 'restore']);
    Route::post('/admin/dosen/{dosen}/delete', [DosenController::class, 'delete']);
    Route::post('/admin/dosen/storeKelompoKeahlianDosen', [DosenController::class, 'storeKelompoKeahlianDosen']);
    Route::patch('/admin/dosen/updateKelompoKeahlianDosen', [DosenController::class, 'updateKelompoKeahlianDosen']);
    Route::delete('/admin/dosen/{kelompok_keahlian_dosen}/destroyKelompoKeahlianDosen', [DosenController::class, 'destroyKelompoKeahlianDosen']);
    Route::post('/admin/dosen/{kelompok_keahlian_dosen}/restoreKelompoKeahlianDosen', [DosenController::class, 'restoreKelompoKeahlianDosen']);
    Route::post('/admin/dosen/{kelompok_keahlian_dosen}/deleteKelompoKeahlianDosen', [DosenController::class, 'deleteKelompoKeahlianDosen']);
    Route::patch('/admin/akreditasi/updateAkreditasiText', [AkreditasiController::class, 'updateAkreditasiText']);

    Route::resource('/admin/akreditasi', AkreditasiController::class);
    Route::resource('/admin/aplikasi_integrasi', AplikasiIntegrasiController::class);
    Route::resource('/admin/banner', BannerController::class);
    Route::get('/admin/berita/{berita}/edit', [BeritaController::class, 'edit']);
    Route::resource('/admin/berita', BeritaController::class);
    Route::resource('/admin/blog', BlogController::class);
    Route::resource('/admin/dashboard', DashboardController::class);
    Route::resource('/admin/dokumen_prodi', DokumenProdiController::class);
    Route::resource('/admin/dosen', DosenController::class);
    Route::resource('/admin/galeri', GaleriController::class);
    Route::resource('/admin/hasil_karya', HasilKaryaController::class);
    Route::resource('/admin/laboratorium', LaboratoriumController::class);
    Route::resource('/admin/informasi_beasiswa', InformasiBeasiswaController::class);
    Route::resource('/admin/jurnal', JurnalController::class);
    Route::resource('/admin/buku', BukuController::class);
    Route::resource('/admin/prosiding', ProsidingController::class);
    Route::resource('/admin/haki', HakiController::class);
    Route::resource('/admin/kalender_akademik', KalenderAkademikController::class);
    Route::resource('/admin/kemitraan', KemitraanController::class);
    Route::resource('/admin/kerjasama_mitra_kolaborasi', KerjasamaMitraKolaborasiController::class);
    Route::resource('/admin/kontak', KontakController::class);
    Route::resource('/admin/kurikulum', KurikulumController::class);
    Route::resource('/admin/layanan_mahasiswa', LayananMahasiswaController::class);
    Route::resource('/admin/mata_kuliah', MataKuliahController::class);
    Route::resource('/admin/penelitian', PenelitianController::class);
    Route::resource('/admin/pengabdian_kepada_masyarakat', PengabdianKeMasyarakatController::class);
    Route::resource('/admin/perpustakaan', PerpustakaanController::class);
    Route::resource('/admin/profil_lulusan', ProfilLulusanController::class);
    Route::resource('/admin/repository_kerja_praktik', RepositoryKerjaPraktikController::class);
    Route::resource('/admin/repository_skripsi', RepositorySkripsiController::class);
    Route::resource('/admin/profil_singkat', ProfilSingkatController::class);
    Route::resource('/admin/quote', QuoteController::class);
    Route::resource('/admin/ruang_staf_dan_dosen', RuangStafDanDosenController::class);
    Route::resource('/admin/ruang_perkuliahan', RuangPerkuliahanController::class);
    Route::resource('/admin/sambutan', SambutanPimpinanInstansiController::class);
    Route::resource('/admin/sejarah', SejarahController::class);
    Route::resource('/admin/staf', StafController::class);
    Route::resource('/admin/struktur_organisasi', StrukturInstansiController::class);
    Route::resource('/admin/video_profil', VideoProfilController::class);
    Route::resource('/admin/visi_misi', VisiMisiController::class);
    Route::resource('/admin/jadwal_ujian', JadwalUjianController::class);
    Route::resource('/admin/jadwal_kuliah', JadwalKuliahController::class);
    Route::resource('/admin/jadwal_kegiatan', JadwalKegiatanController::class);
    Route::resource('/admin/tata_tertib_peraturan', TataTertibPeraturanController::class);
    Route::resource('/admin/seminar_proposal', SeminarProposalController::class);
    Route::resource('/admin/sidang_akhir', SidangAkhirController::class);
    Route::resource('/admin/kerja_praktik', KerjaPraktikController::class);
    Route::resource('/admin/laboratorium_singkat', LaboratoriumSingkatController::class);
    Route::resource('/admin/himpunan_mahasiswa', HimpunanMahasiswaController::class);

    Route::post('/admin/ckeditor/upload', 'App\Http\Controllers\CKEditorController@store')->name('ckeditor.upload');
    
});

//Portal
Route::get('', [BerandaController::class, 'index']);
Route::get('sejarah', [SejarahController::class, 'menuSejarah']);
Route::get('video_profil', [VideoProfilController::class, 'menuVideoProfil']);
Route::get('sambutan', [SambutanPimpinanInstansiController::class, 'menuSambutanPimpinanInstansi']);
Route::get('visi_misi', [VisiMisiController::class, 'menuVisiMisi']);
Route::get('himpunan_mahasiswa', [HimpunanMahasiswaController::class, 'menuHimpunanMahasiswa']);
Route::get('struktur_organisasi', [StrukturInstansiController::class, 'menuStrukturInstansi']);
Route::get('akreditasi', [AkreditasiController::class, 'menuAkreditasi']);
Route::get('kerjasama_mitra_kolaborasi', [KerjasamaMitraKolaborasiController::class, 'menuKerjasamaMitraKolaborasi']);
Route::get('kerjasama_mitra_kolaborasi/{slug}', [KerjasamaMitraKolaborasiController::class, 'menuKerjasamaMitraKolaborasiDetail']);
Route::get('kurikulum', [KurikulumController::class, 'menuKurikulum']);
Route::get('hasil_karya', [HasilKaryaController::class, 'menuHasilKarya']);
Route::get('hasil_karya/{slug}', [HasilKaryaController::class, 'menuHasilKaryaDetail']);
Route::get('staf', [StafController::class, 'menuStaf']);
Route::get('dosen', [DosenController::class, 'menuDosen']);
Route::get('laboratorium', [LaboratoriumController::class, 'menuLaboratorium']);
Route::get('kalender_akademik', [KalenderAkademikController::class, 'menuKalenderAkademik']);
Route::get('kalender_akademik/{slug}', [KalenderAkademikController::class, 'menuKalenderAkademikDetail']);

Route::get('layanan_mahasiswa/{slug}', [LayananMahasiswaController::class, 'menuDetailLayananMahasiswa']);
Route::get('informasi_beasiswa/{slug}', [InformasiBeasiswaController::class, 'menuDetailInformasiBeasiswa']);
Route::get('penelitian/{slug}', [PenelitianController::class, 'menuDetailPenelitian']);
Route::get('pengabdian_kepada_masyarakat/{slug}', [PengabdianKeMasyarakatController::class, 'menuDetailPengabdianKeMasyarakat']);
Route::get('berita/{slug}', [BeritaController::class, 'menuDetailBerita']);
Route::get('dokumen_prodi/{slug}', [DokumenProdiController::class, 'menuDetailDokumenProdi']);
Route::get('jadwal_ujian/{slug}', [JadwalUjianController::class, 'menuDetailJadwalUjian']);
Route::get('jadwal_kuliah/{slug}', [JadwalKuliahController::class, 'menuDetailJadwalKuliah']);
Route::get('jadwal_kegiatan/{slug}', [JadwalKegiatanController::class, 'menuDetailJadwalKegiatan']);
Route::get('repository_skripsi/{slug}', [RepositorySkripsiController::class, 'menuRepositorySkripsiDetail']);
Route::get('repository_kerja_praktik/{slug}', [RepositoryKerjaPraktikController::class, 'menuRepositoryKerjaPraktikDetail']);

Route::get('layanan_mahasiswa', [LayananMahasiswaController::class, 'menuLayananMahasiswa']);
Route::get('informasi_beasiswa', [InformasiBeasiswaController::class, 'menuInformasiBeasiswa']);
Route::get('profil_lulusan', [ProfilLulusanController::class, 'menuProfilLulusan']);
Route::get('repository_skripsi', [RepositorySkripsiController::class, 'menuRepositorySkripsi']);
Route::get('repository_kerja_praktik', [RepositoryKerjaPraktikController::class, 'menuRepositoryKerjaPraktik']);
Route::get('ruang_perkuliahan', [RuangPerkuliahanController::class, 'menuRuangPerkuliahan']);
Route::get('ruang_staf_dan_dosen', [RuangStafDanDosenController::class, 'menuRuangStafDanDosen']);
Route::get('perpustakaan', [PerpustakaanController::class, 'menuPerpustakaan']);
Route::get('penelitian', [PenelitianController::class, 'menuPenelitian']);
Route::get('pengabdian_kepada_masyarakat', [PengabdianKeMasyarakatController::class, 'menuPengabdianKeMasyarakat']);
Route::get('berita', [BeritaController::class, 'menuBerita']);
Route::get('blog', [BlogController::class, 'menuBlog']);
Route::get('kontak', [KontakController::class, 'menuKontak']);
Route::get('aplikasi_integrasi', [AplikasiIntegrasiController::class, 'menuAplikasiIntegrasi']);
Route::get('jurnal', [JurnalController::class, 'menuJurnal']);
Route::get('buku', [BukuController::class, 'menuBuku']);
Route::get('prosiding', [ProsidingController::class, 'menuProsiding']);
Route::get('haki', [HakiController::class, 'menuHaki']);
Route::get('dokumen_prodi', [DokumenProdiController::class, 'menuDokumenProdi']);
Route::get('informasi_terbaru', [InformasiTerbaruController::class, 'menuinformasiTerbaru']);
Route::get('pencarian', [PencarianController::class, 'index']);
Route::get('unduhan_terbaru', [UnduhanTerbaruController::class, 'menuunduhanTerbaru']);
Route::get('jadwal_ujian', [JadwalUjianController::class, 'menuJadwalUjian']);
Route::get('jadwal_kuliah', [JadwalKuliahController::class, 'menuJadwalKuliah']);
Route::get('jadwal_kegiatan', [JadwalKegiatanController::class, 'menuJadwalKegiatan']);
Route::get('tata_tertib_peraturan', [TataTertibPeraturanController::class, 'menuTataTertibPeraturan']);
Route::get('kelompok_keahlian_dosen', [KelompokKeahlianDosenController::class, 'menuKelompokKeahlianDosen']);
Route::get('seminar_proposal', [SeminarProposalController::class, 'menuSeminarProposal']);
Route::get('sidang_akhir', [SidangAkhirController::class, 'menuSidangAkhir']);
Route::get('kerja_praktik', [KerjaPraktikController::class, 'menuKerjaPraktik']);
Route::get('laboratorium', [LaboratoriumController::class, 'menuLaboratorium']);
Route::get('laboratorium/{slug}', [LaboratoriumController::class, 'menuDetailLaboratorium']);
