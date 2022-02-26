<!DOCTYPE html>
<html lang="en">
<style>
    .space-maju{
        margin-left : 15px;
    }
</style>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('/admin_template/dist/img/favicon.ico') }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('/admin_template/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ url('/admin_template/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ url('/admin_template/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('/admin_template/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet"
        href="{{ url('/admin_template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ url('/admin_template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ url('/admin_template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ url('/admin_template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Webicon -->
    <link href="{{ url('/images/logo.ico') }}" rel="shortcut icon" type="image/vnd.microsoft.icon" />

    <link rel="stylesheet"
        href="{{ url('/admin_template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

    <!-- CK Editor -->
    <script src="{{ asset('admin_template/ck_editor/build/ckeditor.js') }}"></script>

    <!-- jQuery -->
    <script src="{{ url('/admin_template/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ url('/admin_template/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ url('/admin_template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ url('/admin_template/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ url('/admin_template/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ url('/admin_template/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ url('/admin_template/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ url('/admin_template/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ url('/admin_template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ url('/admin_template/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('/admin_template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url('/admin_template/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ url('/admin_template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ url('/admin_template/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ url('/admin_template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ url('/admin_template/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ url('/admin_template/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ url('/admin_template/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ url('/admin_template/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ url('/admin_template/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ url('/admin_template/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ url('/admin_template/dist/js/demo.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ url('/admin_template/dist/js/pages/dashboard.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('/admin_template/dist/js/adminlte.min.js') }}"></script>

    <script src="{{ url('/admin_template/plugins/sweetalert2/sweetalert2.min.js') }}"></script>


</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ url('admin/dashboard') }}" class="nav-link">Dashboard</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->

                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                        <span class="dropdown-item dropdown-header"><b>{{ $session_user->name }}</b></span>
                        <div class="dropdown-divider"></div>
                        <a href="{{ url('admin/dashboard') }}" class="dropdown-item dropdown-footer">
                            <i class="fas fa-tachometer-alt fa-sm fa-fw mr-2"></i>
                            Dashboard</a>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ url('admin/logout') }}" class="dropdown-item text-danger dropdown-footer">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                            Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <div>
                <a href="{{ url('admin/dashboard') }}" class="brand-link">
                    <img src="{{ url('/images/logo.png') }}" alt="Logo" class="brand-image img-circle elevation-3"
                        style="opacity: .8">
                    <span class="brand-text font-weight-light">Prodi Teknik Elektro</span>
                </a>
            </div>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ url('/images/user.png') }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ $session_user->name }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2 pb-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                        <li class="nav-item">
                            <a href="{{ url('admin/dashboard') }}"
                                class="nav-link {{ set_active(['dashboard.index']) }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        <li
                            class="nav-item {{ set_open(['banner.index', 'quote.index', 'profil_singkat.index', 'galeri.index', 'kemitraan.index', 'laboratorium_singkat.index']) }}">
                            <a href="#"
                                class="nav-link {{ set_active(['banner.index', 'quote.index', 'profil_singkat.index', 'galeri.index', 'kemitraan.index', 'laboratorium_singkat.index']) }}">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Beranda
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview space-maju">

                                <li class="nav-item">
                                    <a href="{{ url('admin/banner') }}"
                                        class="nav-link {{ set_active(['banner.index']) }}">
                                        <i class="far fa{{ set_dot(['banner.index']) }}-circle nav-icon"></i>
                                        <p>Banner</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('admin/quote') }}"
                                        class="nav-link {{ set_active(['quote.index']) }}">
                                        <i class="far fa{{ set_dot(['quote.index']) }}-circle nav-icon"></i>
                                        <p>Quote</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('admin/profil_singkat') }}"
                                        class="nav-link {{ set_active(['profil_singkat.index']) }}">
                                        <i class="far fa{{ set_dot(['profil_singkat.index']) }}-circle nav-icon"></i>
                                        <p>Profil Singkat</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('admin/galeri') }}"
                                        class="nav-link {{ set_active(['galeri.index']) }}">
                                        <i class="far fa{{ set_dot(['galeri.index']) }}-circle nav-icon"></i>
                                        <p>Galeri</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('admin/laboratorium_singkat') }}"
                                        class="nav-link {{ set_active(['laboratorium_singkat.index']) }}">
                                        <i
                                            class="far fa{{ set_dot(['laboratorium_singkat.index']) }}-circle nav-icon"></i>
                                        <p>Laboratorium Singkat</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('admin/kemitraan') }}"
                                        class="nav-link {{ set_active(['kemitraan.index']) }}">
                                        <i
                                            class="far fa{{ set_dot(['kemitraan.index']) }}-circle nav-icon"></i>
                                        <p>Kemitraan</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li
                            class="nav-item {{ set_open(['sejarah.index', 'video_profil.index', 'sambutan.index', 'visi_misi.index', 'struktur_organisasi.index', 'akreditasi.index', 'kerjasama_mitra_kolaborasi.index','kerjasama_mitra_kolaborasi.create','kerjasama_mitra_kolaborasi.edit']) }}">
                            <a href="#"
                                class="nav-link {{ set_active(['sejarah.index', 'video_profil.index', 'sambutan.index', 'visi_misi.index', 'struktur_organisasi.index', 'akreditasi.index', 'kerjasama_mitra_kolaborasi.index','kerjasama_mitra_kolaborasi.create','kerjasama_mitra_kolaborasi.edit']) }}">
                                <i class="nav-icon fas fa-id-card"></i>
                                <p>
                                    Profil
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview  space-maju">

                                <li class="nav-item">
                                    <a href="{{ url('admin/akreditasi') }}"
                                        class="nav-link {{ set_active(['akreditasi.index']) }}">
                                        <i class="far fa{{ set_dot(['akreditasi.index']) }}-circle nav-icon"></i>
                                        <p>Akreditasi</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('admin/kerjasama_mitra_kolaborasi') }}"
                                        class="nav-link {{ set_active(['kerjasama_mitra_kolaborasi.index','kerjasama_mitra_kolaborasi.create','kerjasama_mitra_kolaborasi.edit']) }}">
                                        <i
                                            class="far fa{{ set_dot(['kerjasama_mitra_kolaborasi.index','kerjasama_mitra_kolaborasi.create','kerjasama_mitra_kolaborasi.edit']) }}-circle nav-icon"></i>
                                        <p>Kerjasama & Mitra Kolaborasi</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('admin/sejarah') }}"
                                        class="nav-link {{ set_active(['sejarah.index']) }}">
                                        <i class="far fa{{ set_dot(['sejarah.index']) }}-circle nav-icon"></i>
                                        <p>Sejarah</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('admin/sambutan') }}"
                                        class="nav-link {{ set_active(['sambutan.index']) }}">
                                        <i
                                            class="far fa{{ set_dot(['sambutan.index']) }}-circle nav-icon"></i>
                                        <p>Sambutan</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('admin/struktur_organisasi') }}"
                                        class="nav-link {{ set_active(['struktur_organisasi.index']) }}">
                                        <i
                                            class="far fa{{ set_dot(['struktur_organisasi.index']) }}-circle nav-icon"></i>
                                        <p>Struktur Organisasi</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('admin/video_profil') }}"
                                        class="nav-link {{ set_active(['video_profil.index']) }}">
                                        <i class="far fa{{ set_dot(['video_profil.index']) }}-circle nav-icon"></i>
                                        <p>Video Profil</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('admin/visi_misi') }}"
                                        class="nav-link {{ set_active(['visi_misi.index']) }}">
                                        <i class="far fa{{ set_dot(['visi_misi.index']) }}-circle nav-icon"></i>
                                        <p>Visi & Misi</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        
                        <li
                            class="nav-item {{ set_open(['kurikulum.index', 'hasil_karya.index','hasil_karya.edit','hasil_karya.create', 'kalender_akademik.index','penelitian.index','penelitian.edit','penelitian.create', 'pengabdian_kepada_masyarakat.index','pengabdian_kepada_masyarakat.edit','pengabdian_kepada_masyarakat.create']) }}">
                            <a href="#"
                                class="nav-link {{ set_active(['kurikulum.index', 'hasil_karya.index','hasil_karya.edit','hasil_karya.create', 'kalender_akademik.index','penelitian.index','penelitian.edit','penelitian.create', 'pengabdian_kepada_masyarakat.index','pengabdian_kepada_masyarakat.edit','pengabdian_kepada_masyarakat.create']) }}">

                                <i class="nav-icon fas fa-school"></i>
                                <p>
                                    Akademik
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview  space-maju">
                                
                                <li class="nav-item">
                                    <a href="{{ url('admin/kalender_akademik') }}"
                                        class="nav-link {{ set_active(['kalender_akademik.index']) }}">
                                        <i
                                            class="far fa{{ set_dot(['kalender_akademik.index']) }}-circle nav-icon"></i>
                                        <p>Kalender Akademik</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('admin/kurikulum') }}"
                                        class="nav-link {{ set_active(['kurikulum.index']) }}">
                                        <i class="far fa{{ set_dot(['kurikulum.index']) }}-circle nav-icon"></i>
                                        <p>Kurikulum</p>
                                    </a>
                                </li>
                                
                                <li class="nav-item">
                                    <a href="{{ url('admin/hasil_karya') }}"
                                        class="nav-link {{ set_active(['hasil_karya.index','hasil_karya.edit','hasil_karya.create']) }}">
                                        <i class="far fa{{ set_dot(['hasil_karya.index','hasil_karya.edit','hasil_karya.create']) }}-circle nav-icon"></i>
                                        <p>Hasil Karya</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('admin/penelitian') }}"
                                        class="nav-link {{ set_active(['penelitian.index','penelitian.edit','penelitian.create']) }}">
                                        <i class="far fa{{ set_dot(['penelitian.index','penelitian.edit','penelitian.create']) }}-circle nav-icon"></i>
                                        <p>Penelitian</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('admin/pengabdian_kepada_masyarakat') }}"
                                        class="nav-link {{ set_active(['pengabdian_kepada_masyarakat.index','pengabdian_kepada_masyarakat.edit','pengabdian_kepada_masyarakat.create']) }}">
                                        <i
                                            class="far fa{{ set_dot(['pengabdian_kepada_masyarakat.index','pengabdian_kepada_masyarakat.edit','pengabdian_kepada_masyarakat.create']) }}-circle nav-icon"></i>
                                        <p>Pengabdian Kepada Masyarakat</p>
                                    </a>
                                </li>
                               
                            </ul>
                        </li>

                        <li class="nav-item {{ set_open(['jurnal.index', 'buku.index','prosiding.index','haki.index']) }}">
                            <a href="#" class="nav-link {{ set_active(['jurnal.index', 'buku.index','prosiding.index','haki.index']) }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Publikasi
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview  space-maju">

                                <li class="nav-item">
                                    <a href="{{ url('admin/jurnal') }}"
                                        class="nav-link {{ set_active(['jurnal.index']) }}">
                                        <i class="far fa{{ set_dot(['jurnal.index']) }}-circle nav-icon"></i>
                                        <p>Jurnal</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('admin/buku') }}"
                                        class="nav-link {{ set_active(['buku.index']) }}">
                                        <i class="far fa{{ set_dot(['buku.index']) }}-circle nav-icon"></i>
                                        <p>Buku</p>
                                    </a>
                                </li>
                           
                                <li class="nav-item">
                                    <a href="{{ url('admin/prosiding') }}"
                                        class="nav-link {{ set_active(['prosiding.index']) }}">
                                        <i class="far fa{{ set_dot(['prosiding.index']) }}-circle nav-icon"></i>
                                        <p>
                                        Prosiding
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('admin/haki') }}"
                                        class="nav-link {{ set_active(['haki.index']) }}">
                                        <i class="far fa{{ set_dot(['haki.index']) }}-circle nav-icon"></i>
                                        <p>
                                        HAKI
                                        </p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li
                            class="nav-item {{ set_open(['seminar_proposal.index', 'sidang_akhir.index', 'kerja_praktik.index']) }}">
                            <a href="#"
                                class="nav-link {{ set_active(['seminar_proposal.index', 'sidang_akhir.index', 'kerja_praktik.index']) }}">
                                <i class="nav-icon fas fa-file"></i>
                                <p>
                                    SOP
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview  space-maju">

                            <li class="nav-item">
                                    <a href="{{ url('admin/kerja_praktik') }}"
                                        class="nav-link {{ set_active(['kerja_praktik.index']) }}">
                                        <i
                                            class="far fa{{ set_dot(['kerja_praktik.index']) }}-circle nav-icon"></i>
                                        <p>Kerja Praktik</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('admin/seminar_proposal') }}"
                                        class="nav-link {{ set_active(['seminar_proposal.index']) }}">
                                        <i
                                            class="far fa{{ set_dot(['seminar_proposal.index']) }}-circle nav-icon"></i>
                                        <p>Seminar Proposal</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('admin/sidang_akhir') }}"
                                        class="nav-link {{ set_active(['sidang_akhir.index']) }}">
                                        <i
                                            class="far fa{{ set_dot(['sidang_akhir.index']) }}-circle nav-icon"></i>
                                        <p>Sidang Akhir</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                 
                        <li
                            class="nav-item {{ set_open(['jadwal_kuliah.index', 'jadwal_ujian.index', 'jadwal_kegiatan.index']) }}">
                            <a href="#"
                                class="nav-link {{ set_active(['jadwal_kuliah.index', 'jadwal_ujian.index', 'jadwal_kegiatan.index']) }}">
                                <i class="nav-icon fas fa-calendar"></i>
                                <p>
                                   Agenda
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview  space-maju">

                                <li class="nav-item">
                                    <a href="{{ url('admin/jadwal_kuliah') }}"
                                        class="nav-link {{ set_active(['jadwal_kuliah.index']) }}">
                                        <i class="far fa{{ set_dot(['jadwal_kuliah.index']) }}-circle nav-icon"></i>
                                        <p>Jadwal Kuliah</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('admin/jadwal_ujian') }}"
                                        class="nav-link {{ set_active(['jadwal_ujian.index']) }}">
                                        <i
                                            class="far fa{{ set_dot(['jadwal_ujian.index']) }}-circle nav-icon"></i>
                                        <p>Jadwal Ujian</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('admin/jadwal_kegiatan') }}"
                                        class="nav-link {{ set_active(['jadwal_kegiatan.index']) }}">
                                        <i
                                            class="far fa{{ set_dot(['jadwal_kegiatan.index']) }}-circle nav-icon"></i>
                                        <p>Jadwal Kegiatan</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li
                            class="nav-item {{ set_open(['himpunan_mahasiswa.index', 'himpunan_mahasiswa.edit','himpunan_mahasiswa.create', 'layanan_mahasiswa.index','layanan_mahasiswa.edit','layanan_mahasiswa.create', 'informasi_beasiswa.index','informasi_beasiswa.edit','informasi_beasiswa.create', 'profil_lulusan.index', 'tata_tertib_peraturan.index']) }}">
                            <a href="#"
                                class="nav-link {{ set_active(['himpunan_mahasiswa.index', 'himpunan_mahasiswa.edit','himpunan_mahasiswa.create', 'layanan_mahasiswa.index','layanan_mahasiswa.edit','layanan_mahasiswa.create', 'informasi_beasiswa.index','informasi_beasiswa.edit','informasi_beasiswa.create', 'profil_lulusan.index', 'tata_tertib_peraturan.index']) }}">
                                <i class="nav-icon fas fa-user-graduate"></i>
                                <p>
                                    Mahasiswa & Alumni
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview  space-maju">

                                <li class="nav-item">
                                    <a href="{{ url('admin/himpunan_mahasiswa') }}"
                                        class="nav-link {{ set_active(['himpunan_mahasiswa.index','himpunan_mahasiswa.edit','himpunan_mahasiswa.create']) }}">
                                        <i
                                            class="far fa{{ set_dot(['himpunan_mahasiswa.index','himpunan_mahasiswa.edit','himpunan_mahasiswa.create']) }}-circle nav-icon"></i>
                                        <p>Himpunan Mahasiswa</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('admin/layanan_mahasiswa') }}"
                                        class="nav-link {{ set_active(['layanan_mahasiswa.index','layanan_mahasiswa.edit','layanan_mahasiswa.create']) }}">
                                        <i
                                            class="far fa{{ set_dot(['layanan_mahasiswa.index','layanan_mahasiswa.edit','layanan_mahasiswa.create']) }}-circle nav-icon"></i>
                                        <p>Layanan Mahasiswa</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('admin/informasi_beasiswa') }}"
                                        class="nav-link {{ set_active(['informasi_beasiswa.index','informasi_beasiswa.edit','informasi_beasiswa.create']) }}">
                                        <i
                                            class="far fa{{ set_dot(['informasi_beasiswa.index','informasi_beasiswa.edit','informasi_beasiswa.create']) }}-circle nav-icon"></i>
                                        <p>Informasi Beasiswa</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('admin/profil_lulusan') }}"
                                        class="nav-link {{ set_active(['profil_lulusan.index']) }}">
                                        <i
                                            class="far fa{{ set_dot(['profil_lulusan.index']) }}-circle nav-icon"></i>
                                        <p>Profil Lulusan</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('admin/tata_tertib_peraturan') }}"
                                        class="nav-link {{ set_active(['tata_tertib_peraturan.index']) }}">
                                        <i class="far fa{{ set_dot(['tata_tertib_peraturan.index']) }}-circle nav-icon"></i>
                                        <p>Tata Tertib dan Peraturan</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li
                            class="nav-item {{ set_open(['ruang_perkuliahan.index', 'laboratorium.index', 'ruang_staf_dan_dosen.index', 'perpustakaan.index']) }}">
                            <a href="#"
                                class="nav-link {{ set_active(['ruang_perkuliahan.index', 'laboratorium.index', 'ruang_staf_dan_dosen.index', 'perpustakaan.index']) }}">
                                <i class="nav-icon fas fa-building"></i>
                                <p>
                                    Fasilitas
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview  space-maju">

                                <li class="nav-item">
                                    <a href="{{ url('admin/ruang_perkuliahan') }}"
                                        class="nav-link {{ set_active(['ruang_perkuliahan.index']) }}">
                                        <i
                                            class="far fa{{ set_dot(['ruang_perkuliahan.index']) }}-circle nav-icon"></i>
                                        <p>Ruang Perkuliahan</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('admin/laboratorium') }}"
                                        class="nav-link {{ set_active(['laboratorium.index']) }}">
                                        <i class="far fa{{ set_dot(['laboratorium.index']) }}-circle nav-icon"></i>
                                        <p>Laboratorium</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('admin/ruang_staf_dan_dosen') }}"
                                        class="nav-link {{ set_active(['ruang_staf_dan_dosen.index']) }}">
                                        <i
                                            class="far fa{{ set_dot(['ruang_staf_dan_dosen.index']) }}-circle nav-icon"></i>
                                        <p>Ruang Staf & Dosen</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('admin/perpustakaan') }}"
                                        class="nav-link {{ set_active(['perpustakaan.index']) }}">
                                        <i class="far fa{{ set_dot(['perpustakaan.index']) }}-circle nav-icon"></i>
                                        <p>Perpustakaan</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-item {{ set_open(['peraturan_perundang_undangan.index', 'dokumen_prodi.index']) }}">
                        
                                    <a href="{{ url('admin/dokumen_prodi') }}"
                                        class="nav-link {{ set_active(['dokumen_prodi.index']) }}">
                                        <i class="nav-icon fas fa-download"></i>
                                        <p>Dokumen Prodi</p>
                                    </a>
                                </li>
                        <li
                            class="nav-item  {{ (request()->is('admin/berita/' .$berita->id. '/edit')) ? 'menu-open' : '' }} {{ set_open(['berita.index', 'berita.create',  'blog.index', 'blog.create', 'blog.edit']) }}">
                            <a href="#"
                                class="nav-link {{ (request()->is('admin/berita/' . $berita->id . '/edit')) ? 'active' : '' }} {{ set_active(['berita.index', 'berita.create', 'blog.index', 'blog.create', 'blog.edit']) }}">

                                <i class="nav-icon fas fa-newspaper"></i>
                                <p>
                                    Berita & Blog Dosen
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview  space-maju">

                                <li class="nav-item">
                                    <a href="{{ url('admin/berita') }}"
                                        class="nav-link {{ (request()->is('admin/berita/' . $berita->id . '/edit')) ? 'active' : '' }} {{ set_active(['berita.index', 'berita.create']) }}">
                                        <i
                                            class="far fa{{ set_dot(['berita.index', 'berita.create', 'berita.edit']) }}{{ (request()->is('admin/berita/' .$berita->id. '/edit')) ? '-dot' : '' }}-circle nav-icon"></i>

                                        <p>Berita</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('admin/blog') }}"
                                        class="nav-link {{ set_active(['blog.index', 'blog.create', 'blog.edit']) }}">
                                        <i
                                            class="far fa{{ set_dot(['blog.index', 'blog.create', 'blog.edit']) }}-circle nav-icon"></i>

                                        <p>Blog Dosen</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                       <li
                            class="nav-item {{ set_open(['repository_kerja_praktik.index','repository_kerja_praktik.edit','repository_kerja_praktik.create', 'repository_skripsi.index','repository_skripsi.edit','repository_skripsi.create']) }}">
                            <a href="#"
                                class="nav-link {{ set_active(['repository_kerja_praktik.index','repository_kerja_praktik.edit','repository_kerja_praktik.create', 'repository_skripsi.index','repository_skripsi.edit','repository_skripsi.create']) }}">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Repository
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview  space-maju">

                                <li class="nav-item">
                                    <a href="{{ url('admin/repository_kerja_praktik') }}"
                                        class="nav-link {{ set_active(['repository_kerja_praktik.index','repository_kerja_praktik.edit','repository_kerja_praktik.create']) }}">
                                        <i
                                            class="far fa{{ set_dot(['repository_kerja_praktik.index','repository_kerja_praktik.edit','repository_kerja_praktik.create']) }}-circle nav-icon"></i>
                                        <p>Repository Kerja Praktik</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ url('admin/repository_skripsi') }}"
                                        class="nav-link {{ set_active(['repository_skripsi.index','repository_skripsi.edit','repository_skripsi.create']) }}">
                                        <i
                                            class="far fa{{ set_dot(['repository_skripsi.index','repository_skripsi.edit','repository_skripsi.create']) }}-circle nav-icon"></i>
                                        <p>Repository Skripsi</p>
                                    </a>
                                </li>


                            </ul>
                        </li>

                        <li class="nav-item {{ set_open(['staf.index', 'dosen.index','kontak.index']) }}">
                            <a href="#" class="nav-link {{ set_active(['staf.index', 'dosen.index','kontak.index']) }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Seputar Kampus
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview  space-maju">

                                <li class="nav-item">
                                    <a href="{{ url('admin/staf') }}"
                                        class="nav-link {{ set_active(['staf.index']) }}">
                                        <i class="far fa{{ set_dot(['staf.index']) }}-circle nav-icon"></i>
                                        <p>Staf</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('admin/dosen') }}"
                                        class="nav-link {{ set_active(['dosen.index']) }}">
                                        <i class="far fa{{ set_dot(['dosen.index']) }}-circle nav-icon"></i>
                                        <p>Dosen</p>
                                    </a>
                                </li>
                           
                            <li class="nav-item">
                                <a href="{{ url('admin/kontak') }}"
                                     class="nav-link {{ set_active(['kontak.index']) }}">
                                     <i class="far fa{{ set_dot(['kontak.index']) }}-circle nav-icon"></i>
                                     <p>
                                    Kontak
                                     </p>
                                 </a>
                            </li>

                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('admin/aplikasi_integrasi') }}"
                                class="nav-link {{ set_active(['aplikasi_integrasi.index']) }}">
                                <i class="nav-icon fas fa-tablet-alt"></i>
                                <p>
                                    Aplikasi Terintegrasi
                                </p>
                            </a>
                        </li>

                      

                      

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        @yield('container')
        <!-- /.content-wrapper -->
        <footer class="main-footer">
           
            <div class="float-right d-none d-sm-inline-block">
                2022 © Jurusan Informatika, Universitas Tanjungpura.
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
</body>
@yield('script')

</html>
