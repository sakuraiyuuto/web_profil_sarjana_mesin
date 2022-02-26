@extends('portal/layout/main')

@section('title', 'Hasil Karya - Teknik Elektro UNTAN')

@section('container')
    <!--Banner Wrap Start-->
    <div class="kf_inr_banner">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!--KF INR BANNER DES Wrap Start-->
                    <div class="kf_inr_ban_des">
                        <div class="inr_banner_heading">
                            <h3>Detail Hasil Karya</h3>
                        </div>

                        <div class="kf_inr_breadcrumb">
                            <ul>
                                <li><a href="{{ url('') }}">Beranda</a></li>
                                <li><a href="{{ url('/hasil_karya') }}">Hasil Karya</a></li>
                            </ul>
                        </div>
                    </div>
                    <!--KF INR BANNER DES Wrap End-->
                </div>
            </div>
        </div>
    </div>

    <!--Banner Wrap End-->

    <!--Content Wrap Start-->
    <div class="kf_content_wrap">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-8">

                        <!--KF_BLOG DETAIL_WRAP START-->
                        <div class="kf_blog_detail_wrap">

                            <!-- BLOG DETAIL THUMBNAIL START-->
                            <div class="blog_detail_thumbnail">
                                <figure>
                                    <img src="{{ url($hasilKarya->thumbnail) }}" alt="" />
                                    <figcaption><a href="#">Hasil Karya</a></figcaption>
                                </figure>
                            </div>
                            <!-- BLOG DETAIL THUMBNAIL END-->

                            <!--KF_BLOG DETAIL_DES START-->
                            <div class="kf_blog_detail_des">
                                <div class="blog-detl_heading">
                                    <h5>{{ $hasilKarya->judul }}</h5>
                                </div>

                                <ul class="blog_detail_meta">
                                    <li><i class="fa fa-calendar"></i><a
                                            href="#">{{ date('d M, Y', strtotime($hasilKarya->release_date)) }}</a>
                                    </li>
                                </ul>
                                <div class="ck-content">
                                    {!! $hasilKarya->teks !!}
                                </div>
                            </div>
                            
                            <!--Share Media Sosial -->
                            <section id="share-post">
                                <div class="icons">
                                    <span>Bagikan ke :</span>
                                    <a href="{{ Share::currentPage()->facebook()->getRawLinks() }}" class="social-button "
                                        target="_blank" id="">
                                        <span class="fa fa-facebook"></span>
                                    </a>
                                    <a href="{{ Share::currentPage()->twitter()->getRawLinks() }}" class="social-button "
                                        target="_blank" id="">
                                        <span class="fa fa-twitter"></span>
                                    </a>
                                    <a href="{{ Share::currentPage()->whatsapp()->getRawLinks() }}" class="social-button "
                                        target="_blank" id="">
                                        <span class="fa fa-whatsapp"></span>
                                    </a>
                                </div><!-- /.icons -->
                            </section>

                            <!--KF_BLOG DETAIL_DES END-->
                        </div>
                        <!--KF_BLOG DETAIL_WRAP END-->
                    </div>

                    <!--KF_EDU_SIDEBAR_WRAP START-->
                    <div class="col-md-4">
                        <div class="kf-sidebar">

                            <!--KF_SIDEBAR_SEARCH_WRAP START-->
                            <div class="widget widget-search">
                                <h2>Pencarian</h2>
                                <form action="{{ url('pencarian') }}">
                                    <div class="input-group">
                                        <input type="search" class="form-control" name="search" placeholder="Search">
                                        <span class="input-group-btn"><button type="submit" id="search-submit"
                                                class="btn"><i class="fa fa-search"></i></button></span>
                                    </div><!-- /.input-group -->
                                </form>
                            </div>
                            <!--KF_SIDEBAR_SEARCH_WRAP END-->

                            <!--KF SIDEBAR RECENT POST WRAP START-->
                            <div class="widget widget-recent-posts">
                                <h2>Informasi Terbaru</h2>
                                <ul class="sidebar_rpost_des">
                                    @foreach ($informasiTerbarus as $informasiTerbaru)
                                        <!--LIST ITEM START-->
                                        <li>
                                            <figure>
                                                <img src="{{ asset($informasiTerbaru->thumbnail) }}" alt="">
                                                <figcaption><a href="{{ url($informasiTerbaru->slug) }}"><i
                                                            class="fa fa-search-plus"></i></a></figcaption>
                                            </figure>
                                            <div class="kode-text">
                                                <h6>
                                                    <a
                                                        href="{{ url($informasiTerbaru->slug) }}">{{ $informasiTerbaru->judul }}</a>
                                                </h6>
                                                <span>
                                                    <i class="fa fa-clock-o"></i>{{ $informasiTerbaru->release_date }}
                                                </span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <a href="{{ url('/informasi_terbaru') }}" class="read-more">Semua Informasi</a>
                            </div>
                            <!--KF SIDEBAR RECENT POST WRAP END-->

                            <!--KF SIDEBAR RECENT POST WRAP START-->
                            <div class="widget widget-recent-posts">
                                <h2>Aplikasi Integrasi</h2>
                                <ul id="normal" class="sidebar_rpost_des " style="width : 30rem">
                                    <div id="owl-demo-apl" class="owl-carousel owl-theme">
                                        @foreach ($aplikasiIntegrasis as $aplikasiIntegrasi)
                                            <div class="item">
                                                <!--LIST ITEM START-->
                                                <li>
                                                    <figure>
                                                        <img style="height : 10rem;object-fit: cover"
                                                            src="{{ url($aplikasiIntegrasi->thumbnail) }}" alt="">
                                                        <figcaption><a href="{{ $aplikasiIntegrasi->url }}"><i
                                                                    class="fa fa-search-plus"></i></a></figcaption>
                                                    </figure>
                                                    <div class="kode-text"
                                                        style="padding-top : 10px;padding-right : 5px">
                                                        <h6><a
                                                                href="{{ $aplikasiIntegrasi->url }}">{{ $aplikasiIntegrasi->nama }}</a>
                                                        </h6>
                                                        <span><i
                                                                class="fa fa-clock-o"></i>{{ $aplikasiIntegrasi->release_date }}</span>
                                                    </div>
                                                </li>
                                                <!--LIST ITEM START-->
                                            </div>
                                        @endforeach
                                    </div>
                                </ul>
                            </div>
                            <a href="{{ url('aplikasi_integrasi') }}" style="font-size : 15px"
                                class="button-pkm">Semua Aplikasi</a>
                            <!--KF SIDEBAR RECENT POST WRAP END-->

                        </div>
                    </div>
                    <!--KF EDU SIDEBAR WRAP END-->

                </div>
            </div>
        </section>
    </div>
@endsection
