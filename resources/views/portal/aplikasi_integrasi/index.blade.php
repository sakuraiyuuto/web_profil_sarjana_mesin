@extends('portal/layout/main')

@section('title', 'Aplikasi Integrasi - Teknik Elektro UNTAN')

@section('container')
<!--Banner Wrap Start-->
<div class="kf_inr_banner">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!--KF INR BANNER DES Wrap Start-->
                <div class="kf_inr_ban_des">
                    <div class="inr_banner_heading">
                        <h3>Aplikasi Integrasi</h3>
                    </div>
                    <div class="kf_inr_breadcrumb">
                        <ul>
                            <li><a href="{{ url('') }}">Beranda</a></li>
                            <li><a>Aplikasi Integrasi</a></li>
                        </ul>
                    </div>
                </div>
                <!--KF INR BANNER DES Wrap End-->
            </div>
        </div>
    </div>
</div>

<!--Content Wrap Start-->
<div class="kf_content_wrap">
    <section class="event_list_page">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <table id="tabel_aplikasi_integrasi" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Daftar Aplikasi Integrasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($aplikasiIntegrasiPaginates as $aplikasiIntegrasiPaginate)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <!--EVENT LIST Wrap Start-->
                                    <div class="kf_event_list_wrap">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-5 col-sm-5">
                                                <!--EVENT LIST THUMB Start-->
                                                <div class="kf_event_list_thumb">
                                                    <figure>
                                                        <img style="height : 20rem; object-fit :cover"
                                                            src="{{ url($aplikasiIntegrasiPaginate->thumbnail) }}"
                                                            alt="" />
                                                    </figure>
                                                </div>
                                                <!--EVENT LIST THUMB END-->
                                            </div>

                                            <div class="col-lg-6 col-md-7 col-sm-7">
                                                <!--EVENT LIST DES Start-->
                                                <div class="kf_event_list_des">
                                                    <h4><a
                                                            href="{{ url($aplikasiIntegrasiPaginate->url) }}"><span>{{ $aplikasiIntegrasiPaginate->nama }}</span></a>
                                                    </h4>
                                                    <p>{{ $aplikasiIntegrasiPaginate->teks }}</p>
                                                    <ul class="kf_event_list_links">
                                                        <li><a>{{ $aplikasiIntegrasiPaginate->release_date }}</a></li>
                                                    </ul>
                                                    <a class="readmore"
                                                        href="{{ url($aplikasiIntegrasiPaginate->url) }}">
                                                        Selengkapnya
                                                        <i class="fa fa-long-arrow-right"></i>
                                                    </a>
                                                </div>
                                                <!--EVENT LIST DES END-->
                                            </div>
                                        </div>
                                    </div>
                                    <!--EVENT LIST Wrap END-->
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                                        <img class="img-sidebar-info" src="{{ asset($informasiTerbaru->thumbnail) }}"
                                            alt="">
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
                            <a href="{{ url('/informasi_terbaru') }}" style="margin-top : 40px;font-size : 15px"
                                class="button-pkm">Semua Informasi</a>

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
                                            <div class="kode-text" style="padding-top : 10px;padding-right : 5px">
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
                        <a href="{{ url('aplikasi_integrasi') }}" style="font-size : 15px" class="button-pkm">Semua
                            Aplikasi</a>
                        <!--KF SIDEBAR RECENT POST WRAP END-->

                    </div>
                </div>
                <!--KF EDU SIDEBAR WRAP END-->
            </div>
        </div>
    </section>
</div>
<!--Content Wrap End-->
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('#tabel_aplikasi_integrasi').DataTable();
    });
</script>
@endsection
