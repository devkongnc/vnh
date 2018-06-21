@extends('about.base')

@section('about-content')
    <article class="type-wrapper">
        <div class="breadcrumb">
            <a href="#">トップページ</a>
            <a href="#">お問い合わせ</a>
        </div>
        <h1>物件タイプ情報</h1>
        <div class="type-information-wrapper">
            <div class="box-content">
                <img src="{{ asset('images/type_apartment.svg') }}" align="Profile"/>
                <h3>アパート</h3>
                <p>日本同様のマンションタイプの賃貸物件で幅広い物件より御選び頂く事が可能です。家賃の他に電気、ガス、水道、インターネット、ケーブルTV、マンション共益費等のお支払いが発生致します。</p>
            </div>
            <div class="box-content">
                <img src="{{ asset('images/type_service.svg') }}" align="Recruit"/>
                <h3>サービスアパート</h3>
                <p>物件に応じて、光熱費、洗濯、お部屋の掃除、タオル交換、プール、ジム等のサービスが付加するアパートになります。通常のマンションタイプと外見は代わりが無いですが物件の選択肢が限られます。 </p>
            </div>
            <div class="box-content">
                <img src="{{ asset('images/type_villa.svg') }}" align="Privacy"/>
                <h3>VILLA(一戸建て)</h3>
                <p>戸建ての中でも豪華で庭、プール、門、壁や隣家との仕切り等がある物件が多い事が特徴です。アパート同様光熱費等の費用が発生いたします。また物件に応じて安全面上ガードマンを付ける事をお勧めします。</p>
            </div>
            <div class="box-content">
                <img src="{{ asset('images/type_house.svg') }}" align="Contact"/>
                <h3>House(一戸建て) </h3>
                <p>VILLAとの区別が難しいですが、敷地内の庭等のスペースが狭い、階数が多い、隣接する家との間隔無いことが特徴となります。光熱費等の費用が発生致します。</p>
            </div>
            <div class="box-content">
                <img src="{{ asset('images/type_office.svg') }}" align="Contact"/>
                <h3>オフィス</h3>
                <p>ビジネス利用目的の賃貸物件となります。レストラン、物販、各種ビジネス事務所、スタジオ等々ご希望に応じて物件をご案内させていただきます。</p>
            </div>
        </div>
    </article>
@endsection