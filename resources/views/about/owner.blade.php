@extends('about.base')

@section('about-content')
    <article class="owner-wrapper page-content">
        {!! Breadcrumbs::render('about-page', $page) !!}
        <h1>{{ $page->title }}</h1>
        <img class="owner-image img-responsive" src="{{ asset('images/owner-' . LaravelLocalization::getCurrentLocale() .  '.svg') }}"/>
        <h2>@lang('entity.page.owner.description')<span class="icon-require"></span> @lang('entity.page.contact.required')</h2>
        <section class="wrap-content-page">
            @if (session('flash_data'))
                @if (session('flash_data')['status'] != 'success')
                    @include('partials.validations')
                @endif
            @endif
            {!! Form::open(['action' => 'RealEstateController@landlord' ,'class' => 'form-contact estate-properties no-ajax', 'files' => true, 'novalidate' => '']) !!}
            <div class="basic-information">
                <div class="wrap-form">
                    <div class="group-form">
                        <label for="name">@lang('entity.page.contact.name') <span class="icon-require"></span></label>
                        <input type="text" id="name" name="info[name]" value="{{ old('info.name') }}" required="" maxlength="255" pattern=".{1,}" title="{{ rtrim(trans('validation.min.string', ['attribute' => 'name', 'min' => 1]), '.') }}" />
                    </div>
                    <div class="group-form">
                        <label for="phone">@lang('entity.page.contact.phone') <span class="icon-require"></span></label>
                        <input type="tel" id="phone" name="info[phone]" value="{{ old('info.phone') }}" required="" minlength="8" maxlength="15" pattern="^\+?[0-9\s]+$" title="{{ rtrim(trans('validation.regex', ['attribute' => 'phone']), '.') }}" />
                    </div>
                    <div class="group-form">
                        <label for="email">@lang('entity.page.contact.email') <span class="icon-require"></span></label>
                        <input type="email" id="email" name="info[email]" value="{{ old('info.email') }}" required="" maxlength="255" />
                    </div>
                    <div class="group-form">
                        <label for="address">@lang('entity.page.contact.address') <span class="icon-require"></span></label>
                        <input type="text" id="address" name="info[address]" value="{{ old('info.address') }}" required="" minlength="5" />
                    </div>
                </div>
            </div>
            <h2>＜　@lang('entity.page.owner.about property')　＞</h2>
            <div class="detail-information">
                <div class="wrap-form">
                    <div class="group-form">
                        <label for="price_usd">@lang('entity.page.owner.rental price') &lt;USD&gt;<span class="icon-require"></span></label>
                        <input type="number" id="price_usd" name="term[price]" value="{{ old('term.price') }}" required=""/>
                    </div>
                </div>
                    @foreach($terms_form as $key => $data)
                        @if ($key != "size_rangefor_search" && $key != "city")
                        <div class="wrap-form">
                            <div class="group-form">
                                <label class="{{ $data['group'] }}" for="term_{{$key}}">
                                    {{ \App\Term::getLocaleValue($data['name']) }}
                                    @if ($data['type'] !== 'multiple')
                                        <span class="icon-require"></span>
                                    @endif
                                </label>
                                @if ($data['type'] == 'text')
                                    {{ Form::number("term[{$key}]", '', ['class' => '', 'id' => "term_{$key}", 'required' => 'required']) }}
                                @elseif($data['type'] == 'single')
                                    <select name="term[{{$key}}]" id="term_{{$key}}" class="{{--selectpicker--}}" required="">
                                        <option value="" disabled="" selected="">--</option>
                                        @foreach($data['values'] as $index => $value)
                                            <option value="{{$index}}"{{ old("term.$key") == $index ? ' selected' : '' }}>{{ \App\Term::getLocaleValue($value) }}</option>
                                        @endforeach
                                    </select>
                                @elseif($data['type'] == 'multiple')
                                    <div class="checkboxes">
                                        <?php $i = 0; ?>
                                        <div class="row">
                                            @foreach($data['values'] as $index => $value)
                                                @if(($key == "facilities" && $index != '1') || ($key != "facilities"))
                                                <div>
                                                    <input id="term_{{$key}}_{{$index}}" {{ old("term.$key") != null && in_array($index, old("term.$key")) ? ' checked' : '' }} name="term[{{ $key }}][]" type="checkbox" value="{{$index}}">
                                                    <label for="term_{{$key}}_{{$index}}"></label>
                                                    {{ \App\Term::getLocaleValue($value) }}

                                                </div>
                                                <?php $i++; ?>
                                                @endif
                                                @if ($i % 3 == 0)
                                        </div><div class="row">
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    @endforeach
                <div class="wrap-form">
                    <div class="group-form">
                        <label class="normal" for="extra">@lang('entity.page.owner.introduction')</label>
                        @foreach (array_keys($all_locales) as $localeCode)
                            <textarea name="description[{{ $localeCode }}]" class="form-control {{ $localeCode === $current_locale ? '' : 'hidden' }}">{{ old('description.' . $localeCode) }}</textarea>
                        @endforeach

                    </div>
                </div>
                <div class="wrap-form">
                    <div class="group-form">
                        <label class="normal" for="abc-name">@lang('entity.page.owner.upload')</label>
                        <div class="resources row col">
                            @for ($i = 1; $i < 10; $i++)
                                <div class="resource row">
                                    <input type="text" data-target="#resource-{{$i}}"/>
                                    <button type="button" data-target="#resource-{{$i}}">@lang('entity.page.owner.upload btn')</button>
                                    <input type="file" accept="image/*" name="resources[]" data-target="#resource-{{$i}}" hidden="true" id="resource-{{$i}}">
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
                <div class="policy">
                    <p><a href="{{ LaravelLocalization::getLocalizedURL($current_locale, $pages_by_id[5]->permalink) }}" target="_blank">@lang('entity.page.contact.policy')</a>@lang('entity.page.contact.policy description')</p>
                    <!-- <p>
                        <input id="checkpolicy" name="policy" type="checkbox" required="" />
                        <label for="checkpolicy">@lang('entity.page.contact.policy checkbox')</label>
                    </p> -->
                </div>
                <div id="RecaptchaOwner" class="g-recaptcha"></div>
                <button type="submit" class="btn-send">@lang('entity.page.contact.submit')</button><img src="{{ asset('images/ajax-loader.gif') }}" class="ajax-loader hidden" alt="ajax loader">
            {!! Form::close() !!}
        </section>
    </article>
    @if (session('flash_data'))
        @if (session('flash_data')['status'] == 'success')
            {!!  view('partials.popup_thankyou')->render()  !!}
            @section('scripts')
                <script>
                    $('.popup-thankyou').addClass('opened').fadeIn().find('.sub-thankyou > span').text({{ old('info.name') }});
                    $('.popup-thankyou').find('.title-thankyou > span').css('opacity', 0);
                    setTimeout(function() {
                        $title_thankyou   = $('.title-thankyou');
                        $title_thankyou.css({ 'opacity': 1 });
                        for (var i = 0; i <= $title_thankyou.children().size(); i++)
                            $title_thankyou.children('span:eq(' + i + ')').delay(200 * i).animate({ 'opacity': 1 }, 10);
                    }, 500);
                </script>
            @endsection
        @endif
    @endif

@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
             $('button[data-target]').click(function(){
                $($(this).data("target")).click();
             });
            $('input[type="file"]').change(function(){
               $(this).parents(".resource").find('input[type="text"]').attr('value', $(this).get(0).files[0].name);;
            });
        });
    </script>
@endsection

