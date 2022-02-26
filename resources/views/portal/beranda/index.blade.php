@extends('portal/layout/main')

@section('title', 'Beranda - Prodi Elektro Teknik UNTAN')

@section('container')
    <div class="edu2_main_bn_wrap">
        <div id="owl-demo-main" class="owl-carousel owl-theme">
            @foreach ($banners as $banner)
                <div class="item">
                    <figure>
                        <img class="height-banner" src="{{ $banner->nama_foto }}" alt=""  style="	max-height : 75rem;object-fit : cover" />
                        <figcaption>
                            <span>
                                <h2>{{ $banner->teks }}</h2>
                            </span>
                        </figcaption>
                    </figure>
                </div>
            @endforeach
        </div>
    </div>

    <div class="kf_content_wrap">
        <!--KF COURSES CATEGORIES WRAP START-->
        <section class="new_info  bg_new_info">
            <div class="container">
                <div class="row">
                    <!-- HEADING 1 START-->
                    <div class="col-md-12">
                        <div class="kf_edu2_heading1">
                            <h3>Informasi Terbaru</h3>
                        </div>
                    </div>
                    <!-- HEADING 1 END-->

                    <div class="kf_edu2_tab_des">
                        <div class="col-md-12">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active">
                                    <!-- 1 Tab START  -->
                                    <div class="row ">
                                        @foreach ($informasiTerbarus as $informasiTerbaru)
                                            <!-- EDU COURSES WRAP START -->
                                            <div class="col-md-4">
                                                <div class="edu2_cur_wrap">
                                                    <figure>
                                                        <img src="{{ $informasiTerbaru->thumbnail }}" alt="" style="height : 20rem;object-fit : cover">
                                                        <figcaption><a
                                                                href="{{ $informasiTerbaru->slug }}">Selengkapnya</a>
                                                        </figcaption>
                                                    </figure>
                                                    <div class="edu2_cur_des  new_info_bg">
                                                        <h5><a href="{{ $informasiTerbaru->slug }}">{{ $informasiTerbaru->judul }}</a></h5>
                                                        <strong>
                                                            <span><i class="fa fa-calendar"></i>  {{ date('d M, Y', strtotime($informasiTerbaru->release_date)) }}</span>
                                                        </strong>
                                                        <p style="text-align:justify;">
                                                            @if (strlen(strip_tags($informasiTerbaru->teks)) > 256)
                                                                {{ str_replace("&nbsp;", "",substr(strip_tags($informasiTerbaru->teks), 0, 256) . '...' )}}
                                                            @else
                                                                {{ str_replace("&nbsp;", "",substr(strip_tags($informasiTerbaru->teks), 0, 256))}}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- EDU COURSES WRAP END -->
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--EDU2 COURSES TAB WRAP END-->
                </div>
            </div>
        </section>
        <!--KF COURSES CATEGORIES WRAP END-->

        <!--OUR TESTEMONIAL WRAP START-->
        <section>
            <div class="container">
                <div class="row">
                    <!-- HEADING 2 START-->
                    <div class="col-md-12">
                        <div class="kf_edu2_heading2">
                            <h3>Quote</h3>
                        </div>
                    </div>
                    <!-- HEADING 2 END-->
                    <!-- TESTEMONIAL SLIDER WRAP START-->
                    <div class="edu2_testemonial_slider_wrap">
                        <div id="owl-demo-9">
                            @foreach ($quotes as $quote)
                                <div class="item quotes-size" >
                                    <!-- TESTEMONIAL SLIDER WRAP START-->
                                    <div class="edu_testemonial_wrap">
                                        <figure><img class="quotes-photo" src="{{ $quote->nama_foto }}" alt="" /></figure>
                                        <div class="kode-text">
                                            <p>{{ $quote->teks }}</p>
                                            <a>{{ $quote->sumber }}</a>
                                        </div>
                                    </div>
                                    <!-- TESTEMONIAL SLIDER WRAP END-->
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- TESTEMONIAL SLIDER WRAP END-->
                </div>
            </div>
        </section>
        <!--OUR TESTEMONIAL WRAP END-->

        <!--KF INTRO WRAP START-->
        <section class="kf_edu2_intro_wrap">
            <div class="kf_intro_des_wrap">
                <!-- HEADING 2 START-->
                <div class="col-md-12">
                    <div class="kf_edu2_heading2">
                        <h3>Profil Singkat Teknik Elektro UNTAN</h3>
                    </div>
                </div>
                <!-- HEADING 2 END-->
                <div class="col-md-12  ">
                    <div class="kf_intro_des  ">
                        <div class="kf_intro_des_caption">
                            <p>{{ $profilSingkat->teks }}</p>
                        </div>
                        <figure class="img-singkat-profil">
                            <img src="{{ $profilSingkat->nama_foto }}" alt="" />
                            <figcaption><a href="{{ url('/sejarah') }}">Sejarah</a></figcaption>
                        </figure>
                    </div>
                </div>
                <!-- INTERO DES START-->
              
                <!-- INTERO DES END-->
            </div>
        </section>
        <!--KF INTRO WRAP END-->

        <section class="our_event_page">
            <div class="container">
                <div class="row">

                    <!-- HEADING 2 START-->
                    <div class="col-md-12">
                        <div class="kf_edu2_heading2">
                            <h3>Pengabdian Kepada Masyarakat</h3>
                        </div>
                    </div>
                    <!-- HEADING 2 END-->

                    <?php $x = 0; ?>
                    @foreach ($pengabdianKeMasyarakats as $pengabdianKeMasyarakat)
                        <?php $x = $x + 1; ?>
                        @if ($loop->iteration % 2 == 1)
                            <div class="row">
                                <!-- EDU2 NEW DES START-->
                                <div class="col-md-6">
                                    <div class="edu2_event_wrap">
                                        <div class="edu2_event_des">
                                            <h4>{{ substr(date('F', strtotime($pengabdianKeMasyarakat->release_date)), 0, 3) }}
                                            </h4>
                                            <ul>
                                                <li> <i class="fa fa-calendar"></i>  {{ date(' Y', strtotime($pengabdianKeMasyarakat->release_date)) }}</li>
                                            </ul>
                                            <p>
                                                {{ $pengabdianKeMasyarakat->judul }}
                                            </p>
                                         
                                            <a href="{{ url($pengabdianKeMasyarakat->slug) }}" class="readmore">Selengkapnya
                                                <i class="fa fa-long-arrow-right"></i></a>
                                            <span>
                                                {{ date('d', strtotime($pengabdianKeMasyarakat->release_date)) }}</span>
                                        </div>

                                        <figure><img class="img-pkm" src="{{ url($pengabdianKeMasyarakat->thumbnail) }}" alt="" />
                                            <figcaption><a href="{{ url($pengabdianKeMasyarakat->slug) }}"><i
                                                        class="fa fa-plus"></i></a></figcaption>
                                        </figure>
                                    </div>
                                </div>
                                <!-- EDU2 NEW DES END-->
                            @else
                                <!-- EDU2 NEW DES START-->
                                <div class="col-md-6">
                                    <div class="edu2_event_wrap side_change">
                                        <div class="edu2_event_des">
                                            <h4>{{ substr(date('F', strtotime($pengabdianKeMasyarakat->release_date)), 0, 3) }}
                                            </h4>
                                            <ul>
                                                <li>{{ date(' Y', strtotime($pengabdianKeMasyarakat->release_date)) }} <i class="fa fa-calendar"></i> </li>
                                            </ul>
                                            <p>
                                                {{ $pengabdianKeMasyarakat->judul }}
                                            </p>
                                        
                                            <a href="{{ url($pengabdianKeMasyarakat->slug) }}"
                                                class="readmore">Selengkapnya<i
                                                    class="fa fa-long-arrow-right"></i></a>
                                            <span>
                                                {{ date('d', strtotime($pengabdianKeMasyarakat->release_date)) }}</span>
                                        </div>

                                        <figure><img class="img-pkm" src="{{ url($pengabdianKeMasyarakat->thumbnail) }}" alt="" />
                                            <figcaption><a href="{{ url($pengabdianKeMasyarakat->slug) }}"><i
                                                        class="fa fa-plus"></i></a></figcaption>
                                        </figure>
                                    </div>
                                </div>
                                <!-- EDU2 NEW DES END-->
                            </div>
                        @endif
                    @endforeach
                    @if ($x == 1 || $x == 3 || $x == 5)
                </div>
                @endif
                <div class="view-all">
                    <a class="button-pkm" href="{{ url('/pengabdian_kepada_masyarakat') }}">Semua PKM</a>
                </div>
            </div>
        </div>
        </section>
    

        <!--GALLERY SECTION START-->
        <section class="kode-gallery-section">
            <!-- HEADING 2 START-->
            <div class="col-md-12">
                <div class="kf_edu2_heading2">
                    <h3>Galeri</h3>
                    <p>Kegiatan Teknik Elektro Sampai Saat Ini</p>
                </div>
            </div>
            <!-- HEADING 2 END-->
            <!-- EDU2 GALLERY WRAP START-->
            <div class="edu2_gallery_wrap gallery">

                <!-- EDU2 GALLERY DES START-->
                <div class="gallery3">
                    @foreach ($galeris as $galeri)
                        <div class="filterable-item all 2 1 9  col-sm-4 col-xs-12 no_padding">
                            <div class="edu2_gallery_des">
                                <figure>
                                    <img class="img-galeri" alt="" src="{{ $galeri->nama_foto }}">
                                    <figcaption>
                                        <a class="margin-eye margin-eye-respo" data-rel="prettyPhoto[gallery2]" href="{{ $galeri->nama_foto }}"
                                            data-lightbox="photos"><i class="fa fa-eye"></i></a>
                                    </figcaption>
                                </figure>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- EDU2 GALLERY WRAP END-->
            </div>
        </section>
        <!--GALLERY SECTION END-->

        <!--COURSE OUTER WRAP START-->
        <div class="kf_course_outerwrap">
            <div class="container">

                <div class="row">

                    <div class="col-md-12">
                        <div class="row">
                            <!--COURSE CATEGORIES WRAP START-->
                            <div class="kf_cur_catg_wrap">
                                <!--COURSE CATEGORIES WRAP HEADING START-->
                                <div class="col-md-12">
                                    <div class="kf_edu2_heading1">
                                        <h3>Fasilitas</h3>
                                    </div>
                                </div>
                                <!--COURSE CATEGORIES WRAP HEADING END-->

                                <!--COURSE CATEGORIES DES START-->
                                <div class="col-md-6">
                                    <a href="{{ url('laboratorium') }}" class="kf_cur_catg_des color-1 lab" >
                                        <span><i class="icon-chemistry29"></i></span>
                                        <div class="kf_cur_catg_capstion">
                                            <h5>Laboratorium</h5>
                                            <p>
                                                @if (strlen(strip_tags($laboratoriumSingkat->teks)) > 256)
                                                    {{ str_replace("&nbsp;", "",substr(strip_tags($laboratoriumSingkat->teks), 0, 256) . '...' )}}
                                                @else
                                                    {{ str_replace("&nbsp;", "",substr(strip_tags($laboratoriumSingkat->teks), 0, 256))}}
                                                @endif
                                            </p>
                                        </div>
                                    </a>
                                </div>
                                <!--COURSE CATEGORIES DES END-->

                                <!--COURSE CATEGORIES DES START-->
                                <div class="col-md-6">
                                    <a href="{{ url('ruang_perkuliahan') }}" class="kf_cur_catg_des color-2">
                                        <span><i class="icon-educational18"></i></span>
                                        <div class="kf_cur_catg_capstion">
                                            <h5>Ruang Perkuliahan</h5>
                                            <p>
                                                @if (strlen(strip_tags($ruangPerkuliahan->teks)) > 256)
                                                    {{ str_replace("&nbsp;", "",substr(strip_tags($ruangPerkuliahan->teks), 0, 256) . '...' )}}
                                                @else
                                                    {{ str_replace("&nbsp;", "",substr(strip_tags($ruangPerkuliahan->teks), 0, 256))}}
                                                @endif
                                            </p>
                                        </div>
                                    <a>
                                </div>
                                <!--COURSE CATEGORIES DES END-->

                                <!--COURSE CATEGORIES DES START-->
                                <div class="col-md-6">
                                    <a href="{{ url('ruang_staf_dan_dosen') }}" class="kf_cur_catg_des color-3">
                                        <span><i class="icon-group2"></i></span>
                                        <div class="kf_cur_catg_capstion">
                                            <h5>Ruang Staf & Dosen</h5>
                                            <p>
                                                @if (strlen(strip_tags($ruangStafDanDosen->teks)) > 256)
                                                    {{ str_replace("&nbsp;", "",substr(strip_tags($ruangStafDanDosen->teks), 0, 256) . '...' )}}
                                                @else
                                                    {{ str_replace("&nbsp;", "",substr(strip_tags($ruangStafDanDosen->teks), 0, 256))}} 
                                                @endif
                                            </p>
                                        </div>
                                    </a>
                                </div>
                                <!--COURSE CATEGORIES DES END-->

                                <!--COURSE CATEGORIES DES START-->
                                <div class="col-md-6">
                                    <a href ="{{ url('perpustakaan') }}" class="kf_cur_catg_des color-4">
                                        <span><i class="icon-book200"></i></span>
                                        <div class="kf_cur_catg_capstion">
                                            <h5>Perpustakaan</h5>
                                            <p>
                                                @if (strlen(strip_tags($perpustakaan->teks)) > 256)
                                                    {{ str_replace("&nbsp;", "",substr(strip_tags($perpustakaan->teks), 0, 256) . '...' )}}
                                                @else
                                                    {{ str_replace("&nbsp;", "",substr(strip_tags($perpustakaan->teks), 0, 256))}}
                                                @endif
                                            </p>
                                        </div>
                                    </a>
                                </div>
                                <!--COURSE CATEGORIES DES END-->
                            </div>
                            <!--COURSE CATEGORIES WRAP END-->
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!--COURSE OUTER WRAP END-->

        <!-- KEMITRAAN START-->
        <section>
            <div class="container">
                <div class="row">
                    <!-- HEADING 1 START-->
                    <div class="col-md-12">
                        <div class="kf_edu2_heading1">
                            <h3>Kemitraan</h3>
                        </div>
                    </div>
                    <!-- HEADING 1 END-->

                    <!-- FACULTY SLIDER WRAP START-->
                    <div class="edu2_faculty_wrap">
                        <div id="owl-demo-8" class="owl-carousel owl-theme">
                            @foreach ($kemitraans as $kemitraan)
                                <div class="item">
                                    <!-- FACULTY DES START-->
                                    <div class="edu2_faculty_des">
                                        <img class="height-kemitraan"style=";object-fit:cover;" src="{{ url($kemitraan->nama_foto) }}" alt="" />
                                    </div>
                                    <!-- FACULTY DES END-->
                                </div>

                            @endforeach


                        </div>
                    </div>
                    <!-- FACULTY SLIDER WRAP END-->
                </div>
            </div>
        </section>
        <!-- KEMITRAAN START-->
    </div>
@endsection
