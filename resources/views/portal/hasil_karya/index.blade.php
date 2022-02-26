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
                            <h3>Hasil Karya</h3>
                        </div>
                        <div class="kf_inr_breadcrumb">
                            <ul>
                                <li><a href="{{ url('') }}">Beranda</a></li>
                                <li><a>Hasil Karya</a></li>
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
        <section class="our_event_page">
            <div class="container">
                <div class="row">

                    <!-- HEADING 2 START-->
                    <div class="col-md-12">
                        <div class="kf_edu2_heading2">
                            <h3>Hasil Karya Teknik Elektro</h3>
                        </div>
                    </div>
                    <!-- HEADING 2 END-->

                    <?php $x = 0; ?>
                    @foreach ($hasilKaryas as $hasilKarya)
                        <?php $x = $x + 1; ?>
                        @if ($loop->iteration % 2 == 1)
                            <div class="row">
                                <!-- EDU2 NEW DES START-->
                                <div class="col-md-6">
                                    <div class="edu2_event_wrap">
                                        <div class="edu2_event_des">
                                            <h4>{{ substr(date('F', strtotime($hasilKarya->release_date)), 0, 3) }}
                                            </h4>
                                            <ul>
                                                <li><i class="fa fa-calendar"></i>  {{ date(' Y', strtotime($hasilKarya->release_date)) }}</li>
                                            </ul>
                                            <p>
                                                {{ $hasilKarya->judul }}
                                            </p>
                                            
                                            <a href="{{ url($hasilKarya->slug) }}" class="readmore">Selengkapnya<i
                                                    class="fa fa-long-arrow-right"></i></a>
                                            <span> {{ date('d', strtotime($hasilKarya->release_date)) }}</span>
                                        </div>

                                        <figure><img  style="height : 20rem; object-fit :cover"  src="{{ url($hasilKarya->thumbnail) }}" alt="" />
                                            <figcaption><a href="{{ url($hasilKarya->slug) }}"><i
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
                                            <h4>{{ substr(date('F', strtotime($hasilKarya->release_date)), 0, 3) }}
                                            </h4>
                                            <ul>
                                                <li>{{ date(' Y', strtotime($hasilKarya->release_date)) }} <i class="fa fa-calendar"></i> </li>
                                            </ul>
                                            <p>
                                                {{ $hasilKarya->judul }}
                                            </p>
                                           
                                            <a href="{{ url($hasilKarya->slug) }}" class="readmore">Selengkapnya<i
                                                    class="fa fa-long-arrow-right"></i></a>
                                            <span> {{ date('d', strtotime($hasilKarya->release_date)) }}</span>
                                        </div>

                                        <figure><img  style="height : 20rem; object-fit :cover" src="{{ url($hasilKarya->thumbnail) }}" alt="" />
                                            <figcaption><a href="{{ url($hasilKarya->slug) }}"><i
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
                <div class="col-md-12">
                    <!--KF_PAGINATION_WRAP START-->
                    <div class="kf_edu_pagination_wrap">
                        <ul class="pagination">
                            <div class="center">
                                <ul class="pagination">
                                    {{ $hasilKaryas->links('pagination::default') }}
                                </ul>
                            </div>
                        </ul>
                    </div>
                    <!--KF_PAGINATION_WRAP END-->
                </div>

            </div>
    </div>
    </section>
    </div>
    <!--Content Wrap End-->
@endsection
