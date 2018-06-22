@extends('layout.base')

@section('content')

<div class="head-search">
    <div class="content-l">
        <ul>
            <li><a href="#">エリア</a></li>
            <li><a href="#">平米単価</a></li>
            <li><a href="#">面積</a></li>
            <li>ヒット件数 <strong>156</strong></li>
        </ul>
        <a href="#" class="search-map"><img src="{{ asset('images/new-layout/icon-map-close.png') }}" > MAP</a>
    </div>
</div>

<div class="content-l">
    <div class="row row-map">
        <div class="house-list-scroll">
            <div class="house-list hidden-tablet">
                <div class="house-blk">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="owl-carousel owl-theme house-carousel">
                                <div class="item">
                                    <img src="{{ asset('images/new-layout/h1.jpg') }}" >
                                </div>
                                <div class="item">
                                    <img src="{{ asset('images/new-layout/h2.jpg') }}" >
                                </div>
                                <div class="item">
                                    <img src="{{ asset('images/new-layout/h1.jpg') }}" >
                                </div>
                                <div class="item">
                                    <img src="{{ asset('images/new-layout/h2.jpg') }}" >
                                </div>
                            </div>
                            <div class="house-sub-title"><strong>25~40</strong> USD /㎡　（管理費込み）</div>

                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="title-number">
                                <h2>51096</h2>
                                <div class="like"><img src="{{ asset('images/new-layout/icon-heart.png') }}" ></div>
                            </div>
                            <h3>登記もできちゃう綺麗なレンタルオフィス一室</h3>
                            <table class="house-info">
                                <tr>
                                    <td class="tdl">エリア</td>
                                    <td class="tdr">1区</td>
                                </tr>
                                <tr>
                                    <td class="tdl">所在地</td>
                                    <td class="tdr">Lê Thánh Tông</td>
                                </tr>
                                <tr>
                                    <td class="tdl">最低契約年数</td>
                                    <td class="tdr">1年</td>
                                </tr>
                                <tr>
                                    <td class="tdl">最大フロア面積</td>
                                    <td class="tdr">2,000㎡</td>
                                </tr>
                                <tr>
                                    <td class="tdl">階数</td>
                                    <td class="tdr">xx階建て</td>
                                </tr>
                                <tr>
                                    <td class="tdl">築年数</td>
                                    <td class="tdr">2016年６月</td>
                                </tr>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="house-list-map">

        </div>
    </div>
</div>

@endsection


