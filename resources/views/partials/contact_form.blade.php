<form action="{{ action('HomeController@contact') }}" method="POST" class="form-contact" data-prefix="{{ $prefix }}">
    {{ csrf_field() }}
    <div class="estate-ids hidden">
        @if (isset($estate_id))
        <input type="hidden" name="estates[]" value="{{ $estate_id }}">
        @endif
    </div>
    <div class="title">
        @lang('entity.page.contact.description') <span class="icon-require"></span> @lang('entity.page.contact.required')
    </div>
    <div class="contact-errors"></div>
    <div class="wrap-form">
        <div class="group-form">
            <label for="{{ $prefix }}-name">@lang('entity.page.contact.name') <span class="icon-require"></span></label>
            <input type="text" id="{{ $prefix }}-name" name="name" value="" required="" maxlength="255" title="{{ rtrim(trans('validation.min.string', ['attribute' => 'name', 'min' => 3]), '.') }}" />
        </div>
        <div class="group-form">
            <label for="{{ $prefix }}-phone">@lang('entity.page.contact.phone') <span class="icon-require"></span></label>
            <input type="tel" id="{{ $prefix }}-phone" name="phone" value="" required="" minlength="8" maxlength="15" pattern="^\+?[0-9\s]+$" title="{{ rtrim(trans('validation.regex', ['attribute' => 'phone']), '.') }}" />
        </div>
        <div class="group-form">
            <label for="{{ $prefix }}-email">@lang('entity.page.contact.email') <span class="icon-require"></span></label>
            <input type="email" id="{{ $prefix }}-email" name="email" value="" required="" maxlength="255" /> <span>（@lang('entity.page.contact.alphanumeric')）</span>
        </div>
        <div class="group-form">
            <label for="{{ $prefix }}-message" style="margin-top: 5px;">@lang('entity.page.contact.message') <span class="icon-require"></span></label>
            <textarea id="{{ $prefix }}-message" name="message" required="" maxlength="500"></textarea>
        </div>
    </div>
    <div class="policy">
        <p><a href="{{ LaravelLocalization::getLocalizedURL(null, $pages_by_id[5]->permalink) }}" target="_blank">@lang('entity.page.contact.policy')</a>@lang('entity.page.contact.policy description')</p>
        <!-- <p>
            <input id="{{ $prefix }}-checkpolicy" name="policy" type="checkbox" required="" />
            <label for="{{ $prefix }}-checkpolicy">@lang('entity.page.contact.policy checkbox')</label>
        </p> -->
    </div>
    @if ($prefix === 'contact') <div id="RecaptchaContact" class="g-recaptcha"></div>
    @elseif ($prefix === 'estate') <div id="RecaptchaEstate" class="g-recaptcha"></div>
    @else <div id="RecaptchaPopup" class="g-recaptcha"></div> @endif
    <button type="submit" class="btn-send">@lang('entity.page.contact.submit')</button><img src="{{ asset('images/ajax-loader.gif') }}" class="ajax-loader hidden" alt="ajax loader">
</form>
