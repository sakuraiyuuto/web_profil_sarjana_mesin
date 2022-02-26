<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap core CSS -->
    <link href="{{ url('/portal_template/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Full Calender CSS -->
    <link href="{{ url('/portal_template/css/fullcalendar.css') }}" rel="stylesheet">
    <!-- Owl Carousel CSS -->
    <link href="{{ url('/portal_template/css/owl.carousel.css') }}" rel="stylesheet">
    <!-- Pretty Photo CSS -->
    <link href="{{ url('/portal_template/css/prettyPhoto.css') }}" rel="stylesheet">
    <!-- Bx-Slider StyleSheet CSS -->
    <link href="{{ url('/portal_template/css/jquery.bxslider.css') }}" rel="stylesheet">
    <!-- Font Awesome StyleSheet CSS -->
    <link href="{{ url('/portal_template/css/font-awesome.min.css') }}" rel="stylesheet">
    
    <link href="{{ url('/portal_template/svg/style.css') }}" rel="stylesheet">
    <!-- Widget CSS -->
    <link href="{{ url('/portal_template/css/widget.css') }}" rel="stylesheet">
    <!-- Typography CSS -->
    <link href="{{ url('/portal_template/css/typography.css') }}" rel="stylesheet">
    <!-- Shortcodes CSS -->
    <link href="{{ url('/portal_template/css/shortcodes.css') }}" rel="stylesheet">
    <!-- Custom Main StyleSheet CSS -->
    <link href="{{ url('/portal_template/style.css') }}" rel="stylesheet">
    <!-- Menu StyleSheet CSS -->
    <link href="{{ url('/portal_template/css/menu.css') }}" rel="stylesheet">
    <!-- Color CSS -->
    <link href="{{ url('/portal_template/css/color.css') }}" rel="stylesheet">
    <!-- Responsive CSS -->
    <link href="{{ url('/portal_template/css/responsive.css') }}" rel="stylesheet">
    <!-- SELECT MENU -->
    <link href="{{ url('/portal_template/css/selectric.css') }}" rel="stylesheet">
    <!-- SIDE MENU -->
    <link rel="stylesheet" href="{{ url('/portal_template/css/jquery.sidr.dark.css') }}">

    <link rel="stylesheet" href="{{ url('/portal_template/ck_editor/content-styles.css') }}" type="text/css">

    <!-- Data Table -->
    <link rel="stylesheet"
        href="{{ url('/portal_template/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ url('/portal_template/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ url('/portal_template/css/buttons.bootstrap4.min.css') }}">

    <!-- Lightbox -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">

    <title>@yield('title')</title>
</head>

<body>
    <!--KF KODE WRAPPER WRAP START-->
    <div class="kode_wrapper">
        <!--HEADER START-->
        <header id="header_2">
            <!--kode top bar start-->
            <div class="top_bar_2">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="pull-left">
                                <em class="contct_2"><i class="fa fa-envelope"></i> Email kami : {{ $kontak->email }}</em>
                            </div>
                        </div>
                        <div class="col-md-9">	
                            <ul class="top_nav">
                              <li >  <b style="color :white">Seputar Kampus : </b></li>
                                <li class="{{ (request()->is('dosen')) ? 'active' : '' }}"><a href="{{ url('dosen') }}">Dosen</a></li>
                                <li class="{{ (request()->is('staf')) ? 'active' : '' }}" ><a href="{{ url('staf') }}">Staff</a></li>
                                <li class="{{ (request()->is('kontak')) ? 'active' : '' }}"><a href="{{ url('kontak') }}">Kontak</a></li>
                                <li class="{{ (request()->is('aplikasi_integrasi')) ? 'active' : '' }}"><a href="{{ url('aplikasi_integrasi') }}">Aplikasi Integrasi</a></li>
                                <li><a href="https://teknik.untan.ac.id/">Fakultas Teknik Untan</a></li>

                                    <li>
                                    <div class=" atas">
                                    <i class="fa fa-search" ></i>
                                    </div>
                                        <form action="{{ url('pencarian') }}">
                                            <div id="search-id" class="search-hidden">    
                                                    <input type="search" class="form-control" name="search" placeholder="Search">
                                                    <button>Submit</button>
                                            </div>  
                                        </form>
                                   </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!--kode top bar end-->

            <!--kode navigation start-->
            <div class="kode_navigation">
                <div class="container">
                    <div class="row margin_nav" >
                        <div class="col-md-4">
                            <div class="logo_wrap">
                                <a href="{{ url('') }}"><img class="logo-utama" src="{{ asset('portal_template/extra-images/logo_2.png') }}" alt=""></a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <!--kode nav_2 start-->
                            <nav id="nav" class="menu-atas">
                            <ul>
                            <li class="search_mobile">
                                <form action="{{ url('pencarian') }}">
                                <div class="search-mobile " style="margin:10px;" >
                                        <input type="search" class="form-control" name="search" placeholder="Search">
                                        <button> <span></span> </button>
                                </div>
                                </form>
                            </li>
                            
                            <li  class ="{{ (request()->is('/*')) ? 'active' : '' }}" ><a class="beranda"  href="{{ url('') }}">Beranda</a></li>
                            <li  class =" {{ (request()->is('akreditasi','kerjasama_mitra_kolaborasi','sejarah','sambutan','struktur_organisasi','video_profil','visi_misi','kerjasama_mitra_kolaborasi/*')) ? 'active' : '' }}"><span class="submenu">Profile <i class="fa fa-angle-down"></i></span>
                            <ul class="submenu ">
                                        <li><a href="{{ url('visi_misi') }}">Visi & Misi</a></li>
                                        <li><a href="{{ url('sambutan') }}">Sambutan</a></li>
                                        <li><a href="{{ url('sejarah') }}">Sejarah</a></li>
                                        <li><a href="{{ url('video_profil') }}">Video Profil</a></li>
                                        <li><a href="{{ url('struktur_organisasi') }}">Struktur Organisasi</a></li>
                                        <li><a href="{{ url('akreditasi') }}">Akreditasi</a></li>
                                        <li ><a  class ="{{ (request()->is('kerjasama_mitra_kolaborasi/*')) ? 'is-active' : '' }}" href="{{ url('kerjasama_mitra_kolaborasi') }}">Kerjasama & Mitra
                                                Kolaborasi</a></li>                       
                            </ul>
                            </li>
                            <li class =" {{ (request()->is('kelompok_keahlian_dosen','hasil_karya','jurnal','kurikulum','kalender_akademik','penelitian','pengabdian_kepada_masyarakat','kelompok_keahlian_dosen/*','hasil_karya/*','jurnal/*','kurikulum/*','kalender_akademik/*','penelitian/*','pengabdian_kepada_masyarakat/*','buku','jurnal','haki','prosiding')) ? 'active' : '' }} "><span class="submenu">Akademik  <i class="fa fa-angle-down"></i></span>
                            <ul class="submenu" >
                                        
                                        <li><a  class ="{{ (request()->is('kalender_akademik/*')) ? 'is-active' : '' }}" href="{{ url('kalender_akademik') }}">Kalender Akademik</a></li> 
                                        <li><a href="{{ url('kelompok_keahlian_dosen') }}">Kelompok Keahlian Dosen</a></li>
                                        <li><a href="{{ url('kurikulum') }}">Kurikulum</a></li>
                                        <li><a class ="{{ (request()->is('hasil_karya/*')) ? 'is-active' : '' }}" href="{{ url('hasil_karya') }}">Hasil Karya</a></li>
                                        <li><a class ="{{ (request()->is('penelitian/*')) ? 'is-active' : '' }}" href="{{ url('penelitian') }}">Penelitian</a></li>
                                        <li><a class ="{{ (request()->is('pengabdian_kepada_masyarakat/*')) ? 'is-active' : '' }}" href="{{ url('pengabdian_kepada_masyarakat') }}">Pengabdian Kepada Masyarakat</a></li>
                                        <li class="dropbtn icon1 hidden-menu" >
                                            <a class=" {{ (request()->is('jurnal','buku','prosiding','haki')) ? 'is-active' : '' }}" href="#" >
                                                Publikasi
                                            </a> 
                                            <ul id="drop-content">                                       
                                                <li><a class=" {{ (request()->is('jurnal')) ? 'sub-active' : '' }}" href="{{ url('jurnal') }}">Jurnal</a></li>
                                                <li><a class=" {{ (request()->is('buku')) ? 'sub-active' : '' }}" href="{{ url('buku') }}">Buku</a></li>
                                                <li><a class=" {{ (request()->is('prosiding')) ? 'sub-active' : '' }}" href="{{ url('prosiding') }}">Prosiding</a></li>
                                                <li><a class=" {{ (request()->is('haki')) ? 'sub-active' : '' }}" href="{{ url('haki') }}">HAKI</a></li>
                                            </ul>
                                        </li>
                                        <li  class ="hidden-menu2" ><span class="submenu level"> Publikasi <i class="fa fa-angle-down"></i></span>
                                        <ul class="submenu">
                                                <li><a class=" {{ (request()->is('jurnal')) ? 'sub-active' : '' }}" href="{{ url('jurnal') }}">Jurnal</a></li>
                                                <li><a class=" {{ (request()->is('buku')) ? 'sub-active' : '' }}" href="{{ url('buku') }}">Buku</a></li>
                                                <li><a class=" {{ (request()->is('prosiding')) ? 'sub-active' : '' }}" href="{{ url('prosiding') }}">Prosiding</a></li>
                                                <li><a class=" {{ (request()->is('haki')) ? 'sub-active' : '' }}" href="{{ url('haki') }}">HAKI</a></li>
                                        </ul>
                                        </li>
                                        
                            </ul>
                            </li>
                            <li  class ="{{ (request()->is('kerja_praktik','seminar_proposal','sidang_akhir')) ? 'active' : '' }}"><span class="submenu"> SOP <i class="fa fa-angle-down"></i></span>
                                        <ul class="submenu">
                                        <li><a href="{{ url('kerja_praktik') }}">Kerja Praktik</a></li>
                                        <li><a href="{{ url('seminar_proposal') }}">Seminar Proposal</a></li>
                                        <li><a href="{{ url('sidang_akhir') }}">Sidang Akhir</a></li>
                                        </ul>
                            </li>
                            <li  class ="{{ (request()->is('jadwal_kuliah','jadwal_ujian','jadwal_kegiatan','jadwal_kuliah/*','jadwal_ujian/*','jadwal_kegiatan/*')) ? 'active' : '' }}"><span class="submenu"> Agenda <i class="fa fa-angle-down"></i></span>
                                        <ul class="submenu">
                                            <li><a class ="{{ (request()->is('jadwal_kuliah/*')) ? 'is-active' : '' }}" href="{{ url('jadwal_kuliah') }}">Jadwal Kuliah</a></li>
                                            <li><a class ="{{ (request()->is('jadwal_ujian/*')) ? 'is-active' : '' }}"href="{{ url('jadwal_ujian') }}">Jadwal Ujian</a></li>
                                            <li><a class ="{{ (request()->is('jadwal_kegiatan/*')) ? 'is-active' : '' }}"href="{{ url('jadwal_kegiatan') }}">Jadwal Kegiatan</a></li>
                                        </ul>
                            </li>
                            <li  class ="{{ (request()->is('himpunan_mahasiswa', 'layanan_mahasiswa','informasi_beasiswa','profil_lulusan','tata_tertib_peraturan','himpunan_mahasiswa/*','prestasi_aktivitas_mahasiswa/*','layanan_mahasiswa/*','informasi_beasiswa/*','profil_lulusan/*','tata_tertib_peraturan/*')) ? 'active' : '' }}"><span class="submenu">Mahasiswa & Alumni <i class="fa fa-angle-down"></i></span>
                                        <ul class="submenu">
                                            <li><a href="{{ url('himpunan_mahasiswa') }}">Himpunan Mahasiswa</a>
                                            </li>
                                            <li><a class ="{{ (request()->is('layanan_mahasiswa/*')) ? 'is-active' : '' }}" href="{{ url('layanan_mahasiswa') }}">Layanan Mahasiswa</a></li>
                                            <li><a class ="{{ (request()->is('informasi_beasiswa/*')) ? 'is-active' : '' }}" href="{{ url('informasi_beasiswa') }}">Informasi Beasiswa</a></li>
                                            
                                            <li><a href="{{ url('profil_lulusan') }}">Profil Lulusan</a></li>
                                            <li><a href="{{ url('tata_tertib_peraturan') }}">Tata Tertib Peraturan</a>
                                        </ul>
                            </li>
                            <li class="{{ (request()->is('ruang_perkuliahan','laboratorium','laboratorium/*','ruang_staf_dan_dosen','perpustakaan')) ? 'active' : '' }}"><span class="submenu">Fasilitas <i class="fa fa-angle-down"></i></span>
                                        <ul class="submenu">
                                            <li><a href="{{ url('ruang_perkuliahan') }}">Ruang Perkuliahan</a></li>
                                            <li class="dropbtn icon2 hidden-menu"><a class ="{{ (request()->is('laboratorium','laboratorium/*')) ? 'is-active' : '' }}" href="{{ url('laboratorium') }}">Laboratorium</a>
                                            <ul id="drop-content2"> 
                                            @foreach ($laboratoriumHeaders as $laboratoriumHeader)                                      
                                                <li><a href="{{ url($laboratoriumHeader->slug) }}">{{ $laboratoriumHeader->nama }}</a></li>
                                            @endforeach
                                            </ul>
                                            </li>

                                            <li  class ="hidden-menu2" ><span class="submenu level"> Laboratorium <i class="fa fa-angle-down"></i></span>
                                                <ul class="submenu">
                                                <li><a class=" {{ (request()->is('laboratorium','laboratorium/*')) ? 'sub-active' : '' }}" href="{{ url('laboratorium') }}"> Semua Laboratorium</a></li>
                                                @foreach ($laboratoriumHeaders as $laboratoriumHeader)                                      
                                                        <li><a  href="{{ url($laboratoriumHeader->slug) }}">{{ $laboratoriumHeader->nama }}</a></li>
                                                    @endforeach
                                                </ul>
                                        </li>

                                            <li><a href="{{ url('ruang_staf_dan_dosen') }}">Ruang Staf &
                                                    Dosen</a>
                                            </li>
                                            <li><a href="{{ url('perpustakaan') }}">Perpustakaan</a></li>
                                        </ul>
                            </li> 
                            <li  class ="{{ (request()->is('dokumen_prodi','dokumen_prodi/*')) ? 'active' : '' }}" ><a class="beranda" href="{{ url('dokumen_prodi') }}">Dokumen Prodi</a></li>
                            <li class="{{ (request()->is('berita','blog','berita/*','blog/*','informasi_terbaru')) ? 'active' : '' }}"><span class="submenu">Blog & Berita <i class="fa fa-angle-down"></i></span>
                                        <ul class="submenu">
                                        <li><a class ="{{ (request()->is('berita/*')) ? 'is-active' : '' }}" href="{{ url('berita') }}">Berita</a></li>
                                        <li><a href="{{ url('blog') }}">Blog</a></li>
                                        <li><a href="{{ url('informasi_terbaru') }}">Informasi Terbaru</a></li>
                                        </ul>
                            </li>           
                            <li class="second-menu {{ (request()->is('aplikasi_integrasi','dosen','staf','kontak')) ? 'active' : '' }}"><span class="submenu">Seputar Kampus <i class="fa fa-angle-down"></i></span>
                                        <ul class="submenu">
                                        <li><a href="{{ url('dosen') }}">Dosen</a></li>
                                        <li><a href="{{ url('staf') }}">Staff</a></li>
                                        <li><a href="{{ url('kontak') }}">Kontak</a></li>
                                        <li><a href="{{ url('aplikasi_integrasi') }}">Aplikasi Integrasi</a></li>
                                        <li><a href="https://teknik.untan.ac.id/">Website Fakultas Teknik Untan</a></li>
                                        </ul>
                            </li> 
                            <li  class ="{{ (request()->is('repository_kerja_praktik','repository_skripsi','repository_kerja_praktik/*','repository_skripsi/*')) ? 'active' : '' }}"><span class="submenu"> Repository <i class="fa fa-angle-down"></i></span>
                                        <ul class="submenu">
                                            <li><a class ="{{ (request()->is('repository_kerja_praktik/*')) ? 'is-active' : '' }}" href="{{ url('repository_kerja_praktik') }}">Repository Kerja Praktik</a></li>
                                            <li><a class ="{{ (request()->is('repository_skripsi/*')) ? 'is-active' : '' }}"href="{{ url('repository_skripsi') }}">Repository Skripsi</a></li>
                                        </ul>
                            </li>
                        </ul>

                                
                            </nav>
                            <!--kode nav_2 end-->
                        </div>
                    </div>
                </div>
            </div>
            <!--kode navigation end-->
        </header>
        <!--HEADER END-->

        @yield('container')


        <!--NEWS LETTERS START-->
        <div class="edu2_ft_topbar_wrap footer-color1">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="edu2_ft_topbar_des">
                            <h5>Pencarian</h5>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="edu2_ft_topbar_des">
                            <form action="{{ url('pencarian') }}">
                                
                                    <input type="search" class="form-control" name="search" placeholder="Search">
                                    <button><i class="fa fa-search"></i>Submit</button>
                           
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--NEWS LETTERS END-->
        <!--FOOTER START-->
        <footer>
            <!--EDU2 FOOTER CONTANT WRAP START-->
            <div class="container">
                <div class="row">
                    <!--EDU2 FOOTER CONTANT DES START-->
                    <div class="col-md-4">
                        <div class="widget widget-links">
                            <h5>Tentang Teknik Elektro UNTAN</h5>
                            <p style="color :white">{{ $profilSingkat->teks }}

                            </p>
                            <div>
                                <a href="{{ url('sejarah') }}" class="selengkapnya-more">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <!--EDU2 FOOTER CONTANT DES END-->

                    <!--EDU2 FOOTER CONTANT DES START-->
                    <div class="col-md-4">
                        <div class="widget wiget-instagram">
                            <h5>Sosial Media</h5>
                            <ul>
                                <li><a class="whatsapp" href="{{ 'https://api.whatsapp.com/send?phone=+62' . $kontak->whatsapp }}"
                                        target="_BLANK"><i class="fa fa-whatsapp"></i></a>
                                </li>
                                <li><a class="facebook" href="{{ $kontak->url_facebook }}" target="_BLANK"><i class="fa fa-facebook-square"></i></a>
                                </li>
                                <li><a class="instagram" href="{{ $kontak->url_instagram }}" target="_BLANK"><i class="fa fa-instagram"></i></a>
                                </li>
                                <li><a class="youtube" href="{{ $kontak->url_youtube }}" target="_BLANK"><i class="fa fa-youtube-square"></i></a>
                                </li>
                                <li><a class="twitter" href="{{ $kontak->url_twitter }}" target="_BLANK"><i class="fa fa-twitter-square"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--EDU2 FOOTER CONTANT DES END-->

                    <!--EDU2 FOOTER CONTANT DES START-->
                    <div class="col-md-4">
                        <div class="widget widget-contact">
                            <h5>Kontak</h5>
                            <ul>
                                <li>{{ $kontak->alamat }}</li>
                                <li>Telepon : <a>{{ $kontak->nomor_telepon }}</a></li>
                                <li>Fax : <a>{{ $kontak->fax }}</a></li>
                                <li>Email : <a>{{ $kontak->email }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <!--EDU2 FOOTER CONTANT DES END-->
                </div>
            </div>
        </footer>
        <!--FOOTER END-->
        <!--COPYRIGHTS START-->
        <div class="edu2_copyright_wrap">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div  style="width : 200px" class="edu2_ft_logo_wrap">
                            <a href="{{ url('') }}"><img src="portal_template/extra-images/logo.png" alt="" /></a>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="copyright_des">
                            <span>&copy;<a href="#">Teknik Elektro Universitas Tanjungpura 2022</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--COPYRIGHTS START-->
    </div>
    <!--KF KODE WRAPPER WRAP END-->
        <!--Bootstrap core JavaScript-->
    <script src="{{ asset('portal_template/js/menu.js') }}"></script>
    <!--Bootstrap core JavaScript-->
    <script src="{{ asset('portal_template/js/jquery.js') }}"></script>
    <script src="{{ asset('portal_template/js/bootstrap.min.js') }}"></script>
    <!--Bx-Slider JavaScript-->
    <script src="{{ asset('portal_template/js/jquery.bxslider.min.js') }}"></script>
    <!--Owl Carousel JavaScript-->
    <script src="{{ asset('portal_template/js/owl.carousel.min.js') }}"></script>
    <!--Pretty Photo JavaScript-->
    <script src="{{ asset('portal_template/js/jquery.prettyPhoto.js') }}"></script>
    <!--Full Calender JavaScript-->
    <script src="{{ asset('portal_template/js/moment.min.js') }}"></script>
    <script src="{{ asset('portal_template/js/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('portal_template/js/jquery.downCount.js') }}"></script>
    <!--Image Filterable JavaScript-->
    <script src="{{ asset('portal_template/js/jquery-filterable.js') }}"></script>
    <!--Accordian JavaScript-->
    <script src="{{ asset('portal_template/js/jquery.accordion.js') }}"></script>
    <!--Number Count (Waypoints) JavaScript-->
    <script src="{{ asset('portal_template/js/waypoints-min.js') }}"></script>
    <!--v ticker-->
    <script src="{{ asset('portal_template/js/jquery.vticker.min.js') }}"></script>
    <!--select menu-->
    <script src="{{ asset('portal_template/js/jquery.selectric.min.js') }}"></script>
    <!--Side Menu-->
    <script src="{{ asset('portal_template/js/jquery.sidr.min.js') }}"></script>
    <!--Custom JavaScript-->
    <script src="{{ asset('portal_template/js/custom.js') }}"></script>

    <!-- LightBox -->
    <script type="text/javascript" src="{{ asset('portal_template/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('portal_template/js/bootstrap.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('portal_template/js/lightbox.min.js') }}"></script>

    <!-- dataTables -->
    <script src="{{ url('/portal_template/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('/portal_template/js/dataTables.bootstrap4.min.js') }}"></script>
    
    @yield('script')
    <script>
     
    $('.atas').click(function(e){
        e.preventDefault();
        var func = $('#search-id').hasClass('search-atas') ? 'removeClass' : 'addClass';
        $("#search-id").removeClass("search-atas");
        $('#search-id')[func]("search-atas");
       
});
    </script>
</body>

</html>
