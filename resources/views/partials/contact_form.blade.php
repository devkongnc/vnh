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
        <label class="ctf_hide_mobile">@lang('entity.page.contact.name') <img src="/images/new-layout/icon-require.png" ></label>
        <span class="ctf-show-mobile"><img src="/images/icon-contact-form/user-icon.png" ></span>
        <input type="text" id="{{ $prefix }}-name" name="name" value="" placeholder="@lang('entity.page.contact.name')" required="" maxlength="255" title="{{ rtrim(trans('validation.min.string', ['attribute' => 'name', 'min' => 3]), '.') }}" />
    </div>
    <div class="gr-cotnact-row">
        <label class="ctf_hide_mobile">@lang('entity.page.contact.phone') <img src="/images/new-layout/icon-require.png" ></label>
        <span class="ctf-show-mobile"><img src="/images/icon-contact-form/phone-icon.png" ></span>
        <input type="tel" id="{{ $prefix }}-phone" name="phone" value="" placeholder="@lang('entity.page.contact.phone')" required="" minlength="8" maxlength="15" pattern="^\+?[0-9\s]+$" title="{{ rtrim(trans('validation.regex', ['attribute' => 'phone']), '.') }}" />
        <span class="ctf_hide_mobile">（@lang('entity.page.contact.alphanumeric')）</span>
    </div>
    <div class="gr-cotnact-row">
        <label class="ctf_hide_mobile">@lang('entity.page.contact.email') <img src="/images/new-layout/icon-require.png" ></label>
        <span class="ctf-show-mobile"><img src="/images/icon-contact-form/email-icon.png" ></span>
        <input type="email" id="{{ $prefix }}-email" name="email" value="" placeholder="@lang('entity.page.contact.email')" required="" maxlength="255" />
    </div>
    <div class="gr-cotnact-row">
        <label class="ctf_hide_mobile">@lang('entity.page.contact.message') <img src="/images/new-layout/icon-require.png" ></label>
        <span class="ctf-show-mobile"><img src="/images/icon-contact-form/mess-icon.png" ></span>
        <textarea id="{{ $prefix }}-message" name="message" required="" maxlength="500" placeholder="@lang('entity.page.contact.message')"></textarea>
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
        padding: 6px 10px;
        height: 40px;
        line-height: 40px;
    }
    .gr-cotnact-row input:hover{
        border: 1px solid #fbb03b;
        outline-color: transparent;
        outline-style: none;
    }

    .gr-cotnact-row input, .gr-cotnact-row textarea{border: 1px solid #5d5c5c !important; border-radius: 3px !important;}
    .ctf-show-mobile{display: none}
    @media screen and (max-width: 767px){
        .ctf_hide_mobile{display: none !important}
        .ctf-show-mobile{display: block; float: left; padding-top: 5px;}
        .gr-cotnact-row input, .gr-cotnact-row textarea{margin-left: 7%; width: 80% !important;}
    }

    @media screen and (min-width: 768px){
        .gr-cotnact-row input[type=text]::placeholder,
        .gr-cotnact-row input[type=tel]::placeholder,
        .gr-cotnact-row input[type=email]::placeholder,
        .gr-cotnact-row textarea::placeholder
        {
            opacity: 0 !important;
        }
    }
</style>

