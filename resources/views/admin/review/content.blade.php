<div id="review-content" class="col-sm-9">
    <div class="form-group">
        <label for="name" class="control-label">@lang('admin.review.title')</label>
        @include('partials.lang_control', ['type' => 'text', 'attr' => "title", 'model' => 'review'])
    </div>
    <div class="form-group">
        <label for="permalink" class="control-label">@lang('admin.common.permalink')</label>
        {{-- <div class="input-group">  --}}
            {{-- <span class="input-group-addon" id="basic-addon1">http://{{ Request::getHost() }}/review/</span> --}}
            {{ Form::text('permalink', $review->permalink, ['class' => 'form-control', "placeholder" => "short-link", "aria-describedby" => "basic-addon1", "required" => "true"]) }}
        {{-- </div> --}}
    </div>
    @include('partials.lang_control', ['type' => 'textarea', 'attr' => "description", 'model' => 'review', 'class' => 'editor'])
</div>
<div id="review-box-container" class="col-sm-3">
    <div class="post-box">
        <h2><b>@lang('admin.review.publish')</b></h2>
        <div class="inside">
            <!-- Trạng thái -->
            <p>
                @lang('admin.review.state.title'): <b class="post-status">{{ $review->draft ? trans('admin.review.state.draft') : trans('admin.review.state.published') }}</b>
                <a class="edit edit-status" href="#edit_status">@lang('admin.common.edit')</a>
            </p>
            <div class="hidden status-edit">
                <div class="form-group">
                    <div class="radio">
                        <label>
                            {{ Form::radio('draft', 0, $review->draft == false, [ 'class' => 'input-status']) }}
                            <span>@lang('admin.review.state.published')</span>
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            {{ Form::radio('draft', 1, $review->draft == true, [ 'class' => 'input-status']) }}
                            <span>@lang('admin.review.state.draft')</span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <a href="#edit_status"
                       class="save-status btn btn-default btn-ok">OK</a>
                    <a href="#edit_status"
                       class="cancel-status btn btn-default btn-cancel">Cancel</a>
                </div>
            </div>
            <!-- Tầm nhìn  -->
            <p>
                @lang('admin.review.visible title'): <b class="post-visibility">{{ strip_tags($review->visibility) }}</b>
                <a class="edit edit-visibility" href="#edit_visibility">@lang('admin.common.edit')</a>
            </p>
            <div class="hidden visibility-edit">
                <div class="form-group">
                    <div class="radio">
                        <label>
                            {{ Form::radio('status', \App\Review::VISIBILITY_PUBLIC, $review->status == \App\Review::VISIBILITY_PUBLIC, ['class' => 'input-visibility']) }}
                            <span>@lang('admin.review.visible.public')</span>
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            {{ Form::radio('status', \App\Review::VISIBILITY_PRIVATE, $review->status == \App\Review::VISIBILITY_PRIVATE, ['class' => 'input-visibility']) }}
                            <span>@lang('admin.review.visible.private')</span>
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            {{ Form::radio('status', \App\Review::VISIBILITY_HIDDEN, $review->status == \App\Review::VISIBILITY_HIDDEN, ['class' => 'input-visibility']) }}
                             <span>@lang('admin.review.visible.hidden')</span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <a href="#edit_visibility"
                       class="save-visibility btn btn-default btn-ok">OK</a>
                    <a href="#edit_visibility"
                       class="cancel-visibility btn btn-default btn-cancel">Cancel</a>
                </div>
            </div>
            <!-- Thời gian -->
            <p>
                @lang('admin.review.updated at'): <b class="post-timestamp">{{ $review->timestamp }}</b>
                <a class="edit edit-timestamp" href="#edit_timestamp">@lang('admin.common.edit')</a>
            </p>
            <div class="hidden timestamp-edit">
                <div class="form-group">
                    {{ Form::text('timestamp', $review->timestamp, ['class' => 'input-timestamp block-full-width form-control datetimepicker', 'data-date-format' => 'dd/mm/yyyy', 'required' => 'true', 'readonly' => true]) }}
                </div>
                <div class="form-group">
                    <a href="#edit_timestamp" class="btn btn-default btn-ok">OK</a>
                    <a href="#edit_timestamp"
                       class="btn btn-default btn-cancel">Cancel</a>
                </div>
            </div>
            <!-- Action -->
            @if (!empty($review->id))
            <p><button type="submit" name="action" value="delete" class="btn btn-lg btn-block btn-danger">@lang('admin.common.delete')</button></p>
            @endif
            <p><button type="submit" name="action" value="preview" class="btn btn-lg btn-block btn-default">@lang('admin.review.preview')</button></p>
            <p><button type="submit" name="action" value="publish" class="btn btn-lg btn-block btn-primary">@lang('admin.common.save')</button></p>
        </div>
    </div>
    <div class="post-box">
        <h2><b>@lang('admin.review.category')</b></h2>
        <div class="inside">
            <ul id="categorychecklist" class="categorychecklist form-no-clear">
                @for ($i = 0; $i < Config::get('override.number of review categories'); $i++)
                <li class="popular-category">
                    <label class="selectit">{{ Form::checkbox('categories[]', $i, in_array($i, (array) $review->categories)) }}@lang('admin.review.categories.' . $i)</label>
                </li>
                @endfor
            </ul>
        </div>
    </div>
    <div class="post-box">
        <h2><b>@lang('admin.review.locales_only')</b></h2>
        <div class="inside">
            <ul id="localechecklist" class="localechecklist form-no-clear">
                @foreach ($all_locales as $localeCode => $properties)
                <li class="popular-category">
                    <label class="selectit">{{ Form::checkbox('locales_only[]', constant("App\Review::{$localeCode}_only"), in_array(constant("App\Review::{$localeCode}_only"), (array) $review->locales_only)) }}{{ $properties['native'] }}</label>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="post-box">
        <h2><b>@lang('admin.review.feature image')</b></h2>
        <div class="inside">
            <p id="kcfinder-single-select">
                <img src="{{ asset($review->post_thumbnail) }}" class="img-responsive center-block" alt="Featured Image">
                <input type="hidden" name="resource_id" value="{{ $review->post_thumbnail_id }}">
                <a class="set-featured{{ $review->post_thumbnail_id === '' ? '' : ' hidden' }}" data-toggle="modal" href="#modal-upload">@lang('admin.common.set featured image')</a>
                <a class="remove-featured{{ $review->post_thumbnail_id === '' ? ' hidden' : '' }}">@lang('admin.common.remove featured image')</a>
            </p>
        </div>
    </div>
</div>
<div id="kcfinder_div_wrapper"><div id="kcfinder_div" class="kcfinder_div"></div></div>

@section('scripts')
    <script type="text/javascript" src="{{ asset('/js/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript">
        var init_status = $('.input-status:checked'),
            init_visibility = $('.input-visibility:checked'),
            input_timestamp = $('.input-timestamp'),
            init_timestamp = input_timestamp.val(),
            myVar = {
                init_status_val: init_status.val(),
                init_status_text: init_status.next('span').text(),
                init_visibility_val: init_visibility.val(),
                init_visibility_text: init_visibility.next('span').text(),
                post_status: $('.post-status'),
                post_visibility: $('.post-visibility'),
                post_timestamp: $('.post-timestamp'),
                status_div: $('.status-edit'),
                visibility_div: $('.visibility-edit'),
                timestamp_div: $('.timestamp-edit'),
                edit_status: $('.edit-status'),
                edit_visibility: $('.edit-visibility'),
                edit_timestamp: $('.edit-timestamp')
            };

        var form = $('#create-review'),
            form_action = form.attr('action'),
            form_method = form.find('input[name="_method"]').val();

        var _TOKEN = $('input[name="_token"]').val();

        @foreach (array_keys($all_locales) as $localeCode)
        CKEDITOR.replace( 'description-{{ $localeCode }}', {
            language: '{{ $localeCode }}',
            height: 400
        });
        @endforeach

        $('.edit').click(function (event) {
            event.preventDefault();
            $(this).parent('p').next('.hidden').removeClass('hidden');
            $(this).addClass('hidden');
        });

        $('.btn-cancel').click(function (event) {
            event.preventDefault();
            var target = $(this).attr('href').replace('#edit_', '');
            switch (target) {
                case 'status':
                case 'visibility':
                    $('.input-' + target + '[value="' + myVar['init_' + target + '_val'] + '"]').prop('checked', true);
                    myVar['post_' + target].text(myVar['init_' + target + '_text']);
                    break;
                case 'timestamp':
                    input_timestamp.val(init_timestamp);
                    myVar['post_' + target].text(init_timestamp);
                    break;
                default:
                    break;
            }
            myVar[target + '_div'].addClass('hidden');
            myVar['edit_' + target].removeClass('hidden');
        });

        $('.btn-ok').click(function (event) {
            event.preventDefault();
            var target = $(this).attr('href').replace('#edit_', '');
            switch (target) {
                case 'status':
                case 'visibility':
                    myVar['post_' + target].text($('.input-' + target + ':checked').parent().next('span').text());
                    break;
                case 'timestamp':
                    myVar['post_' + target].text(input_timestamp.val());
                    break;
                default:
                    break;
            }
            myVar[target + '_div'].addClass('hidden');
            myVar['edit_' + target].removeClass('hidden');
        });

        form.submit(function(event) {
            var btn_val = $(this).find(".btn-lg:focus").val();
            if (btn_val === 'preview') {
                form.attr({
                    action: '{{ action('Admin\ReviewController@preview') }}',
                    target: 'vnh_preview'
                }).children('input[name="_method"]').val('PUT');
            } else if (btn_val === 'publish') {
                form.attr({
                    action: form_action,
                    target: '_self'
                }).children('input[name="_method"]').val(form_method);
            } else if (btn_val === 'delete') {
                event.preventDefault();
                if (!confirm('{{ trans('admin.common.Are you sure?') }}')) return;
                $('<form>', {
                    'action': '{{ action('Admin\ReviewController@destroy', $review->id) }}',
                    'method': 'POST',
                    'html': '<input name="_method" value="DELETE" type="hidden"><input name="_token" value="' + _TOKEN + '" type="hidden">'
                }).appendTo('body').submit();
            }
        });
    </script>
@endsection
