@extends('portal/layout/main')

@section('title', 'Tracer Alumni')

@section('container')
    <!--Banner Wrap Start-->
    <div class="kf_inr_banner">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!--KF INR BANNER DES Wrap Start-->
                    <div class="kf_inr_ban_des">
                        <div class="inr_banner_heading">
                            <h3>Tracer Study Alumni</h3>
                        </div>

                        <div class="kf_inr_breadcrumb">
                            <ul>
                                <li><a href="{{ url('') }}">Beranda</a></li>
                                <li><a>Tracer Study Alumni</a></li>
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
            <div class="kf_edu2_heading1" style="float : none">
                                <h3>Tracer Study Alumni</h3>
                            </div>
                
                <div class="row">
                    <div class="col-md-8">
                  

                            <div class="col-md-4">
                              
                                 
                                    <div class="jumlah-tracer">
                                         <div class="col-md-3">
                                            <i class="fa fa-users" style="font-size : 30px;color : blue"></i>
                                        </div>
                                        <div class="col-md-9">
                                            <p>Jumlah Pengisi : </p>
                                            <h4 style="color : blue"> {{  $jumlahPengisi }}</h4>
                                        </div>
                                    </div>
                               
                            </div>
                            <div class="col-md-4">
                              
                            <div class="jumlah-tracer">
                                         <div class="col-md-3">
                                            <i class="fa fa-file" style="font-size : 30px;text-align:center;color : green;"></i>
                                        </div>
                                        <div class="col-md-9">
                                            <p>Jumlah Pengisi Validasi : </p>
                                            <h4 style="color:green"> {{  $jumlahPengisiValidasi}}</h4>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-4">
                                    
                                  
                            <div class="jumlah-tracer">
                                         <div class="col-md-3">
                                            <i class="fa fa-user-plus" style="font-size : 30px;color : orange;"></i>
                                        </div>
                                        <div class="col-md-9">
                                            <p>Jumlah Pengisi Hari Ini : </p>
                                            <h4 style="color :orange"> {{  $jumlahPengisihariini}}</h4>
                                        </div>
                                    </div>
                                
                            </div>    

                            <div class="abt_univ_des">
                                   <h3 class="font-weight :800"> Perhatian ! </h3>
                                   <p style="color : black;padding : 10px;	background-color: #f9f9f9;">Bagi Alumni Yang Belum Mengisi Data Pada Website Tracer Alumni, Silahkan Isikan Data Anda Pada Link Yang Ada Di Bawah :
                                    <a style="color :white; font-weight : 700" href='http://tracerstudyalumni.untan.ac.id/'> <div class="btn btn-primary"> Link </div> </a>
                                    </p>
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
                                                <img class="img-sidebar-info"
                                                    src="{{ asset($informasiTerbaru->thumbnail) }}" alt="">
                                                <figcaption><a href="{{ url($informasiTerbaru->slug) }}"><i
                                                            class="fa fa-search-plus"></i></a></figcaption>
                                            </figure>
                                            <div class="kode-text">
                                                <h6>
                                                    <a
                                                        href="{{ url($informasiTerbaru->slug) }}">{{ $informasiTerbaru->judul }}</a>
                                                </h6>
                                                <span>
                                                    <i
                                                        class="fa fa-clock-o"></i>{{ date('d M, Y', strtotime($informasiTerbaru->release_date)) }}

                                                </span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <a href="{{ url('/informasi_terbaru') }}" style="margin-top : 40px;font-size : 15px"
                                    class="button-pkm">Semua Informasi</a>

                            </div>
                            <!--KF SIDEBAR RECENT POST WRAP END-->



                        </div>
                    </div>
                    <!--KF EDU SIDEBAR WRAP END-->

                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#tabel_kurikulum').DataTable();
        });
    </script>
@endsection
