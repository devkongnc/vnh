@extends('about.base')

@section('about-content')
    <article class="links">
        <div class="breadcrumb">
            <a href="#">トップページ</a>
            <a href="#">会社情報</a>
        </div>
        <h1>会社情報</h1>
        <section class="wrap-profile">
            <form>
                <div class="form-group">
                    <div class="label-name">会社名</div>
                    <div class="info">Vietnamhouse Inc.</div>
                </div>
                <div class="form-group">
                    <div class="label-name">所在地</div>
                    <div class="info">9 Hoang Sa, District 1, Ho Chi Minh City, Vietnam</div>
                </div>
                <div class="form-group">
                    <div class="label-name">事業内容</div>
                    <div class="info">不動産仲介、不動産管理</div>
                </div>
                <div class="form-group">
                    <div class="label-name">お問い合わせ先</div>
                    <div class="info">(+84) 08 3911 2100　/　hello@vietnamhouse.jp</div>
                </div>
                <div class="form-group">
                    <div class="label-name">URL</div>
                    <div class="info">//vietnamhouse.jp</div>
                </div>
            </form>
            <div class="map-profile">
                <div id="map-canvas"></div>
            </div>
        </section>
    </article>
@endsection
@section('scripts')
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{ env('APP_MAP_KEY') }}&libraries=places&callback=initMap">
    </script>
    <script type="text/javascript">
        /* Map Google API */
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map-canvas'), {
                zoom: 17,
                center: {lat: 10.7920682, lng: 106.7039437},
                scrollwheel: false,
            });
            var image = '//vietnamhouse.jp/images/localtion-map.png';
            var beachMarker = new google.maps.Marker({
                position: {lat: 10.7920682, lng: 106.7039437},
                map: map,
                icon: image
            });
        }
        $('.tab-hightrise .nav-tabs li a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            initMap();
        });
    </script>
@endsection