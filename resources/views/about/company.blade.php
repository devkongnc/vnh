@extends('about.base')

@section('about-content')
    <article class="company">
        <div class="breadcrumb">
            <a href="#">トップページ</a>
            <a href="#">会社情報</a>
        </div>
        <h1>会社情報</h1>
        <div class="company-information-wrapper">
            <div class="box-content">
                <h3>会社概要</h3>
                <img src="{{ asset('images/about_profile.svg') }}" align="Profile"/>
                <p>ベトナムハウスの「会社概要」をご紹介します。社名、所在地、設立年月日、事業内容など、当社の基本情報を掲載しています。</p>
            </div>
            <div class="box-content">
                <h3>採用情報</h3>
                <img src="{{ asset('images/about_recruit.svg') }}" align="Recruit"/>
                <p>ベトナムハウスの採用情報をご紹介します。<br/>
                    今まで以上に様々なサービスを次々と展開し、提供し続ける為、ベトナムハウスでは新しい仲間を募っています。</p>
            </div>
            <div class="box-content">
                <h3>プライバシーポリシー</h3>
                <img src="{{ asset('images/about_privacy.svg') }}" align="Privacy"/>
                <p>ベトナムハウスの個人情報の取り扱いについてご案内します。</p>
            </div>
            <div class="box-content">
                <h3>お問い合わせ</h3>
                <img src="{{ asset('images/about_contact.svg') }}" align="Contact"/>
                <p>ベトナムハウスのお問い合わせに関するページです。<br/>
                    <a class="text-primary" href="#">よくあるご質問</a>も合せてご利用下さい。</p>
            </div>
        </div>
        <button class="btn btn-company btn-block border-button large-padding">サイトマップ</button>
    </article>
@endsection