@extends('about.base')

@section('about-content')
    <article class="support-wrapper">
        <div class="breadcrumb">
            <a href="#">トップページ</a>
            <a href="#">サポート</a>
        </div>
        <h1>サポート</h1>
        <div class="support-information-wrapper">
            <div class="box-content">
                <h3>物件タイプ情報</h3>
                <div>
                    <img src="{{ asset('images/support_1.svg') }}" align="Profile"/>
                </div>
            </div>
            <div class="box-content">
                <h3>住居エリア情報</h3>
                <div>
                    <img src="{{ asset('images/support_2.svg') }}" align="Recruit"/>
                </div>
            </div>
            <div class="box-content">
                <h3>内覧・入居フロー</h3>
                <div>
                    <img src="{{ asset('images/support_3.svg') }}" align="Privacy"/>
                </div>
            </div>
            <div class="box-content">
                <h3>よくある質問 </h3>
                <div>
                    <img src="{{ asset('images/support_4.svg') }}" align="Contact"/>
                </div>
            </div>
            <div class="box-content">
                <h3>便利なリンク集</h3>
                <div>
                    <img src="{{ asset('images/support_5.svg') }}" align="Contact"/>
                </div>
            </div>
            <div class="box-content">
                <h3>不動産オーナー様へ</h3>
                <div>
                    <img src="{{ asset('images/support_6.svg') }}" align="Contact"/>
                </div>
            </div>
        </div>
        <img src="{{ asset('images/support_banner.png') }}" style="width: 100%"/>
    </article>
@endsection