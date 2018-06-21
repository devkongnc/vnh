@extends('about.base')

@section('about-content')

    <article class="help">
        <div class="breadcrumb">
            <a href="#">トップページ</a>
            <a href="#">よくある質問</a>
        </div>
        <h1>よくある質問</h1>
        <div class="question-list" id="questionListParent" role="tablist" aria-multiselectable="true">
            @for ($i = 1; $i <= 8; $i++)
                <div class="panel question-item">
                    <div class="question-item-heading" role="tab" id="questionTitle{{$i}}">
                        <h4 class="question-item-title">
                            <a role="button" data-toggle="collapse" data-parent="#questionListParent" href="#questionContent{{$i}}" aria-expanded="{{ $i == 1 ? 'true' : 'false' }}" aria-controls="questionContent{{$i}}">
                                <img src="{{ asset('images/help.svg') }}"/> Group Item #{{$i}}
                            </a>
                        </h4>
                    </div>
                    <div id="questionContent{{$i}}" class="question-body collapse {{ $i == 1 ? 'in' : '' }}" role="tabpanel" aria-labelledby="questionTitle{{$i}}">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                    </div>
                </div>
            @endfor
        </div>
    </article>

@endsection