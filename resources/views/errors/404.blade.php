@extends('portal/layout/main')

@section('title', 'Kesalahan - Fakultas Teknik UNTAN')

@section('container')
    <!--Banner Wrap Start-->
    <div class="kf_inr_banner">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!--KF INR BANNER DES Wrap Start-->
                    <div class="kf_inr_ban_des">
                        <div class="inr_banner_heading">
                            <h3>404</h3>
                        </div>

                        <div class="kf_inr_breadcrumb">
                            <ul>
                                <li><a href="{{ url('') }}">Home</a></li>
                                <li><a href="#">404</a></li>
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

        <section class="error_outer_wrap">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="error_wrap">
                            <div class="error_des">
                                <span>404</span>
                                <h3>Tidak ditemukan.</h3>
                                <p>Halaman yang anda cari tidak ditemukan atau sudah dihapus. Coba untuk pergi ke
                                    <strong>Halaman Beranda</strong> dengan menggunakan tombol dibawah.
                                </p>
                            </div>
                            <div class="error_thumb">
                                <figure>
                                    <img src="{{ url('images/404.jpg') }}" alt=""
                                        style="width:840px;height:129px;object-fit:cover;" />
                                    <figcaption><a href="{{ url('') }}"><i class="fa fa-home"></i>Pergi ke
                                            Beranda</a></figcaption>
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
    <!--Content Wrap End-->
@endsection
