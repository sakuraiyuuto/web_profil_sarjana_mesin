@extends('portal/layout/main')

@section('title', 'Kontak - Fakultas Teknik UNTAN')

@section('container')
    <!--Banner Wrap Start-->
    <div class="kf_inr_banner">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!--KF INR BANNER DES Wrap Start-->
                    <div class="kf_inr_ban_des">
                        <div class="inr_banner_heading">
                            <h3>Kontak</h3>
                        </div>

                        <div class="kf_inr_breadcrumb">
                            <ul>
                                <li><a href="{{ url('') }}">Beranda</a></li>
                                <li><a href="{{ url('kontak') }}">Kontak</a></li>
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
            <div class="container mt-0">
                <div class="row">
                    <div class="contct_wrap">
                        <div class="contact_heading">
                            <center>
                                <h2>Tentang Kami</h2>
                                <p>{{ $profilSingkat->teks }}</p>
                        </div>
                        </center>
                        <div class="col-md-6">
                            <div class="contact_heading">
                                <h5>Informasi Kontak</h5>
                            </div>
                            <ul class="contact_meta">
                                <li><i class="fa fa-home"></i> {{ $kontak->alamat }}</li>
                                <li><i class="fa fa-phone"></i> {{ $kontak->nomor_telepon }}</a></li>
                                <li><i class="fa fa-envelope-o"></i> {{ $kontak->email }}</a></li>
                                <li><i class="fa fa-fax"></i> {{ $kontak->fax }}</a></li>
                            </ul>
                        </div>

                        <div class="col-md-6">
                            <div class="contact_heading">
                                <h5>Media Sosial</h5>
                            </div>
                            <ul class="contact_meta">
                                <li><a href="{{ url($kontak->url_facebook) }}"><i class="fa fa-facebook"></i>
                                        {{ $kontak->facebook }}</li>
                                <li><a href="{{ url($kontak->url_instagram) }}"><i class="fa fa-instagram"></i>
                                        {{ $kontak->instagram }}</a></li>
                                <li><a href="{{ url($kontak->url_youtube) }}"><i class="fa fa-youtube-play"></i>
                                        {{ $kontak->youtube }}</a></li>
                                <li><a href="{{ url($kontak->url_twitter) }}"><i class="fa fa-twitter"></i>
                                        {{ $kontak->twitter }}</a></li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <div class="kf_location_wrap">
            <div id="map-canvas" class="map-canvas"><iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.8163927975597!2d109.34549091475328!3d-0.05632009995890483!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e1d59969f6be863%3A0x15552924b4812685!2sFaculty%20of%20Engineering%20(FT)!5e0!3m2!1sen!2sid!4v1643630226462!5m2!1sen!2sid"
                    width="100%" height="500px" style="border:0;" allowfullscreen="" loading="lazy"></iframe></div>
        </div>
    </div>
    <!--Content Wrap End-->
@endsection
