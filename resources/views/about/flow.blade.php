@extends('about.base')

@section('about-content')
    <article class="flow-wrapper">
        <div class="breadcrumb">
            <a href="#">トップページ</a>
            <a href="#">内覧・入居フロー</a>
        </div>
        <h1>内覧・入居フロー</h1>
        <img class="img-responsive" src="{{ asset('images/flow_contact.svg') }}" alt="Flow Contact"/>
        <div id="step1">
            <h2>1<span>コンタクト</span></h2>
            <p><b>ベトナムハウスのサイトから気になった物件を「お問い合わせ」下さい。<br/>もちろん、サイトの物件を見ていなくてもお気軽にお問い合わせ下さい。</b></p>
            <div class="step-images">
                <div class="center">
                    <img src="{{ asset('images/flow_step1_1.svg') }}"/>
                </div>
                <div class="center">
                    <img src="{{ asset('images/flow_step1_2.svg') }}"/>
                </div>
            </div>
        </div>
        <div id="step2">
            <h2>2<span>ヒアリング</span></h2>
            <p><b>担当者よりメールまたはお電話で、ご希望の物件条件をお伺いします！</b></p>
            <p>以下の内容を確認させていただきます。</p>
            <div class="step-images">
                <div class="center">
                    <img class="img-responsive" src="{{ asset('images/flow_step2_1.svg') }}"/>
                </div>
                <div class="center">
                    <img class="img-responsive no-stretch" src="{{ asset('images/flow_step2_2.svg') }}"/>
                </div>
            </div>
        </div>
        <div id="step3">
            <h2>3<span>ヒアリング</span></h2>
            <p><b>大家さんと契約内容や条件を交渉します。ベトナムハウスのスタッフがしっかりと対応させて頂きます。</b></p>
            <p>ご契約書を作成し個人又は会社様とご締結いただきます。</p>
            <img class="img-responsive" src="{{ asset('images/flow_step3.svg') }}"/>
        </div>
        <div id="step4">
            <h2>4<span>ヒアリング</span></h2>
            <p><b>条件に合せて5件前後の物件を実際にご覧頂きます。</b></p>
            <p>内覧は、弊社もしくは最寄のランドマークで待ち合わせさせて頂きます。</p>
            <div class="step-images">
                <div class="right">
                    <img class="img-responsive no-stretch" src="{{ asset('images/flow_step4_1.svg') }}"/>
                </div>
                <div class="left">
                    <img class="img-responsive no-stretch" src="{{ asset('images/flow_step4_2.svg') }}"/>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium aut autem ea fugit</p>
                </div>
            </div>
        </div>
        <div id="step5">
            <h2>5<span>ヒアリング</span></h2>
            <p><b>入居後のケアもベトナムハウスがしっかり対応します。</b></p>
            <div class="step-images">
                <div class="right">
                    <img class="img-responsive no-stretch" src="{{ asset('images/flow_step5.svg') }}"/>
                </div>
                <div class="left">
                    <ul>
                        <li>Lorem ipsum dolor sit amet</li>
                        <li>Lorem ipsum dolor sit amet</li>
                        <li>Lorem ipsum dolor sit amet</li>
                        <li>Lorem ipsum dolor sit amet</li>
                    </ul>
                </div>
            </div>
        </div>
    </article>
@endsection