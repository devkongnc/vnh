@extends('about.base')

@section('about-content')
    <article class="area-wrapper">
        <div class="breadcrumb">
            <a href="#">トップページ</a>
            <a href="#">サポート</a>
            <a href="#">住居エリア情報</a>
        </div>
        <h1>住居エリア情報</h1>
        <img class="area-image" src="{{ asset('images/area.svg') }}"/>
        <div class="area-list" id="questionListParent" role="tablist" aria-multiselectable="true">
            @for ($i = 1; $i <= 8; $i++)
                <div class="panel area-item">
                    <div class="area-item-heading" role="tab" id="questionTitle{{$i}}">
                        <h4 class="area-item-title">
                            <a role="button" data-toggle="collapse" data-parent="#questionListParent" href="#questionContent{{$i}}" aria-expanded="{{ $i == 1 ? 'true' : 'false' }}" aria-controls="questionContent{{$i}}">
                                <div class="area-tags">
                                    <div class="tag tag-color-1">1</div>
                                    <div class="tag tag-color-{{$i+1}}">{{$i+1}}</div>
                                    @if($i==5)
                                    <div class="tag tag-color-tb">T</div>
                                    @elseif($i==7)
                                    <div class="tag tag-color-pn">P</div>
                                    @elseif($i==8)
                                    <div class="tag tag-color-bt">B</div>
                                    @endif
                                </div>
                                ファミリー層の多い住宅エリア #{{$i}}
                            </a>
                        </h4>
                    </div>
                    <div id="questionContent{{$i}}" class="panel-body area-body collapse {{ $i == 1 ? 'in' : '' }}" role="tabpanel" aria-labelledby="questionTitle{{$i}}">
                        <p>２区はVILLA等の一戸建て、７区はファミリー向けのタワーマンションが多い地域です。どちらも緑が多くバイクも少ないので静かでのんびりとした雰囲気のエリアとなります。</p>
                        <p>７区は大型のショッピングセンター（ロッテーマート・クレセントモール・ビボシティー）が点在しているので買物、食事に便利でお子様対応のお店が充実しています。医療面はホーチミンでも屈指のエフブイホスピタル(FV Hospital)があります。病院はとても大きく、様々な科が受診可能です。外資系病院の中では費用が安めなところもおすすめのポイントです。海外旅行保険のキャッシュレス対応※。クレジットカードもOKです。<br>
                        韓国人が多く住んでいるエリアでもありますが、治安は安定していています。７区から１区の繁華街までは、タクシーで20分～30分（15万ドン＝800円※）くらいです。大きな道が通っているので、大型のトラックも通りますが信号がありますし、１区のようにバイクのゴミゴミした道を歩いて横切るような交通事情はありません。</p>
                        <p>２区はおしゃれなカフェや商店、川沿いのレストランなどがあります。良い意味でベトナムっぽさが無く裕福層が住んでいるエリアなので治安も良いです。特にタオディエンという２区の川に囲まれた中州にあるエリアは欧米人が多く暮らしているエリアなので輸入食材や雑貨を揃えたお店やBARもあって大人も楽しめるエリアです。１区まではタクシーで15分（12万ドン＝650円※）くらいです。</p>
                        <p>2区にはもともとマンションはありましたが、上述の利便性に加えて、数年以内に地下鉄が通ること（日本のODA案件で現在工事中）もあり、新しいマンション建築が最も集中している地域になっています。</p>
                        <p>どちらも、ビジネス街ではないので、いかがわしいお店はがほぼ無く安心してお子様と暮らしていただける地域になります。</p>
                    </div>
                </div>
            @endfor
        </div>
    </article>
@endsection