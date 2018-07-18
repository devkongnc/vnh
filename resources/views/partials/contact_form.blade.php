<form action="{{ action('HomeController@contact') }}" method="POST" class="contact-form" data-prefix="{{ $prefix }}">
    {{ csrf_field() }}
    <hr>
    <div class="estate-ids hidden">
        @if (isset($estate_id))
            <input type="hidden" name="estates[]" value="{{ $estate_id }}">
        @endif
    </div>
    <div class="contact-errors"></div>
    <div class="gr-cotnact-row">
        <label>@lang('entity.page.contact.name') <img src="/images/new-layout/icon-require.png" ></label>
        <input type="text" id="{{ $prefix }}-name" name="name" value="" required="" maxlength="255" title="{{ rtrim(trans('validation.min.string', ['attribute' => 'name', 'min' => 3]), '.') }}" />
    </div>
    <div class="gr-cotnact-row">
        <label>@lang('entity.page.contact.phone') <img src="/images/new-layout/icon-require.png" ></label>
        <input type="tel" id="{{ $prefix }}-phone" name="phone" value="" required="" minlength="8" maxlength="15" pattern="^\+?[0-9\s]+$" title="{{ rtrim(trans('validation.regex', ['attribute' => 'phone']), '.') }}" />
        <span>（@lang('entity.page.contact.alphanumeric')）</span>
    </div>
    <div class="gr-cotnact-row">
        <label>@lang('entity.page.contact.email') <img src="/images/new-layout/icon-require.png" ></label>
        <input type="email" id="{{ $prefix }}-email" name="email" value="" required="" maxlength="255" />
    </div>
    <div class="gr-cotnact-row">
        <label>@lang('entity.page.contact.message') <img src="/images/new-layout/icon-require.png" ></label>
        <textarea id="{{ $prefix }}-message" name="message" required="" maxlength="500"></textarea>
    </div>
    <div class="gr-cotnact-row">
        @if ($prefix === 'contact') <div id="RecaptchaContact" class="g-recaptcha"></div>
        @elseif ($prefix === 'estate') <div id="RecaptchaEstate" class="g-recaptcha"></div>
        @else <div id="RecaptchaPopup" class="g-recaptcha"></div>
        @endif
    </div>
    <hr>
    <div class="gr-cotnact-row">
        <div class="submit-blk">
            <span class="yellow-txt">@lang('entity.page.contact.policy') </span>@lang('entity.page.contact.policy description')
            <button type="submit" class="btn-send blk-submit-btn">@lang('entity.page.contact.submit')</button><img src="{{ asset('images/ajax-loader.gif') }}" class="ajax-loader hidden" alt="ajax loader">
        </div>
    </div>
</form>

<style>
    .gr-cotnact-row input{
        height: 36px;
        line-height: 36px;
        padding: 6px 10px;
        min-width: 340px;
    }
    .gr-cotnact-row input:hover{
        border: 1px solid #fbb03b;
        outline-color: transparent;
        outline-style: none;
    }
</style>
