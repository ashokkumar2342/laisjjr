@php
    $include_page_extends = 'temp_1.include.main';
    $include_page_section = 'temp_1.include.main.container';
@endphp

@extends($include_page_extends)
@section($include_page_section)
<!-- Header Area End Here -->
<!-- Slider 1 Area Start Here -->
<div class="slider1-area overlay-default">
    <div class="bend niceties preview-1">
        <div id="ensign-nivoslider-3" class="slides">
            <img src="{{ asset('temp_1/img/slider/4.jpeg') }}" alt="slider">
            <img src="{{ asset('temp_1/img/slider/5.jpeg') }}" alt="slider">
            <img src="{{ asset('temp_1/img/slider/6.jpeg') }}" alt="slider">
        </div>        
    </div>
</div>
<!-- Slider 1 Area End Here -->
<!-- About 2 Area Start Here -->
<div class="lecturers-page-area">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                <div class="single-item">
                    <div class="lecturers1-item-wrapper">
                        <div class="lecturers-img-wrapper">
                            <a href="#"><img class="img-responsive" src="{{ asset('temp_1/img/images/cm.jpeg') }}" alt="team" style="border: 2px solid black;"></a>
                        </div>
                        <div class="lecturers-content-wrapper">
                            <h3 class="item-title"><a href="#">Sh. Nayab Singh Saini</a></h3>
                            <span class="item-designation">Chief Minister, Haryana</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-6 col-sm-12">
                <h3 class="title-default-left title-bar-big-left-close">Message</h3>
                <p>Eimply dummy text of the printing and typesetting industry. Eimply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text type and scrambled it to make a type specimen book.
                    Eimply dummy text of the printing and typesetting industry. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. Eimply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text type and scrambled it to make a type specimen book. </p>
            </div>
            <hr>
            <div class="col-xl-9 col-lg-9 col-md-6 col-sm-12">
                <h3 class="title-default-left title-bar-big-left-close">Message</h3>
                <p>Eimply dummy text of the printing and typesetting industry. Eimply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text type and scrambled it to make a type specimen book.
                    Eimply dummy text of the printing and typesetting industry. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. Eimply dummy text of the printing and typesetting
                    industry. Lorem Ipsum has been the industry's standard dummy text type and scrambled it to make a type specimen book. </p>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                <div class="single-item">
                    <div class="lecturers1-item-wrapper">
                        <div class="lecturers-img-wrapper">
                            <a href="#"><img class="img-responsive" src="{{ asset('temp_1/img/images/dc_jjr.jpeg') }}" alt="team" style="border: 2px solid black;"></a>
                        </div>
                        <div class="lecturers-content-wrapper">
                            <h3 class="item-title"><a href="#">Sh. Pradeep Dahiya, IAS</a></h3>
                            <span class="item-designation">Deputy Commissioner, Jhajjar</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <h2 class="title-default-left">Haryana Govt. Services</h2>
    </div>
    <div class="container">
        <div class="rc-carousel" data-loop="true" data-items="4" data-margin="30" data-autoplay="true" data-autoplay-timeout="10000" data-smart-speed="2000" data-dots="false" data-nav="true" data-nav-speed="false" data-r-x-small="1" data-r-x-small-nav="true"
            data-r-x-small-dots="false" data-r-x-medium="2" data-r-x-medium-nav="true" data-r-x-medium-dots="false" data-r-small="3" data-r-small-nav="true" data-r-small-dots="false" data-r-medium="4" data-r-medium-nav="true" data-r-medium-dots="false"
            data-r-large="4" data-r-large-nav="true" data-r-large-dots="false">
            <div class="single-item">
                <div class="lecturers1-item-wrapper">
                    <div class="lecturers-img-wrapper">
                        <a target="_blank" href="https://saralharyana.gov.in/">
                            <img class="img-responsive" src="{{ asset('temp_1/img/portal/saralharyana.jpeg') }}" alt="team">
                        </a>
                    </div>
                    <div class="lecturers-content-wrapper">
                        <h3 class="item-title">
                            <a target="_blank" href="https://saralharyana.gov.in/">Saral Haryana</a>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="single-item">
                <div class="lecturers1-item-wrapper">
                    <div class="lecturers-img-wrapper">
                        <a target="_blank" href="https://jamabandi.nic.in/defaultpages/default">
                            <img class="img-responsive" src="{{ asset('temp_1/img/portal/jamabandi.jpeg') }}" alt="team">
                        </a>
                    </div>
                    <div class="lecturers-content-wrapper">
                        <h3 class="item-title">
                            <a target="_blank" href="https://jamabandi.nic.in/defaultpages/default">Jamabandi</a>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="single-item">
                <div class="lecturers1-item-wrapper">
                    <div class="lecturers-img-wrapper">
                        <a target="_blank" href="https://hsac.org.in/">
                            <img class="img-responsive" src="{{ asset('temp_1/img/portal/hsac.jpeg') }}" alt="team">
                        </a>
                    </div>
                    <div class="lecturers-content-wrapper">
                        <h3 class="item-title">
                            <a target="_blank" href="https://hsac.org.in/">HSAC</a>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="single-item">
                <div class="lecturers1-item-wrapper">
                    <div class="lecturers-img-wrapper">
                        <a target="_blank" href="https://revenueharyana.gov.in/">
                            <img class="img-responsive" src="{{ asset('temp_1/img/portal/revenueharyana.jpeg') }}" alt="team">
                        </a>
                    </div>
                    <div class="lecturers-content-wrapper">
                        <h3 class="item-title">
                            <a target="_blank" href="https://revenueharyana.gov.in/">Revenue Haryana</a>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="single-item">
                <div class="lecturers1-item-wrapper">
                    <div class="lecturers-img-wrapper">
                        <a target="_blank" href="https://jhajjar.nic.in/">
                            <img class="img-responsive" src="{{ asset('temp_1/img/portal/jhajjar.jpeg') }}" alt="team">
                        </a>
                    </div>
                    <div class="lecturers-content-wrapper">
                        <h3 class="item-title">
                            <a target="_blank" href="https://jhajjar.nic.in/">District Jhajjar</a>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
        