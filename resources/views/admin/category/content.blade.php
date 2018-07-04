<div class="form-group">
    <label for="title" class="col-sm-2 control-label">@lang('admin.common.title')</label>
    <div class="col-sm-6">
        @include('partials.lang_control', ['type' => 'text', 'attr' => "title", 'model' => 'category'])
    </div>
</div>
<div class="form-group">
    <label for="status" class="col-sm-2 control-label">@lang('admin.common.status')</label>
    <div class="col-sm-2">
        {{ Form::select('status', array(\App\Category::VISIBILITY_PUBLIC  => trans('admin.review.visible.public'), \App\Category::VISIBILITY_PRIVATE => trans('admin.review.visible.private'), \App\Category::VISIBILITY_HIDDEN  => trans('admin.review.visible.hidden')), $category->status, ['class' => 'form-control']) }}
    </div>
    <label for="sticky" class="col-sm-2 control-label">@lang('admin.common.sticky')</label>
    <div class="col-sm-2">
        {{ Form::checkbox('sticky', null, $category->sticky) }}
    </div>
</div>
<div class="form-group">
    <label for="permalink" class="col-sm-2 control-label">パーマリンク</label>
    <div class="col-sm-6">
        <div class="input-group"> <span class="input-group-addon" id="basic-addon1">//{{ Request::getHost() }}/category/</span>
            {{ Form::text('permalink', $category->permalink, ['id' => 'permalink', 'class' => 'form-control', "placeholder" => "short-link", "required" => "true", 'pattern' => '^[\w\-]+[a-zA-Z\d]$', 'title' => rtrim('.', trans('validation.url', ['attribute' => 'permalink']))]) }}
        </div>
    </div>
</div>
<div class="form-group">
    <label for="description" class="col-sm-2 control-label">@lang('admin.apartment.description')</label>
    <div class="col-sm-10">
        @include('partials.lang_control', ['type' => 'textarea', 'attr' => "description", 'model' => 'category', 'class' => 'editor'])
    </div>
</div>
<div class="form-group">
    <label for="meta_description" class="col-sm-2 control-label">@lang('admin.category.meta keywords')</label>
    <div class="col-sm-6">
        @include('partials.lang_control', ['type' => 'text', 'attr' => "meta_description", 'model' => 'category'])
    </div>
</div>
<div class="form-group">
    <label for="meta_keywords" class="col-sm-2 control-label">@lang('admin.category.meta description')</label>
    <div class="col-sm-6">
        @include('partials.lang_control', ['type' => 'text', 'attr' => "meta_keywords", 'model' => 'category'])
    </div>
</div>
<div id='kcfinder-single-select' class="form-group">
    <label class="col-sm-2 control-label">@lang('admin.common.set featured image')</label>
    <div class="col-xs-10">
        <img src="{{ asset($category->feature_image) }}" class="img-responsive" alt="featured_image">
        <input type="hidden" name="resource_id" value="{{ $category->post_thumbnail_id }}">
        <a class="set-featured{{ $category->post_thumbnail_id === '' ? '' : ' hidden' }}" data-toggle="modal" href="#modal-upload">@lang('admin.common.set featured image')</a>
        <a class="remove-featured{{ $category->post_thumbnail_id === '' ? ' hidden' : '' }}">@lang('admin.common.remove featured image')</a>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <h3 class="block-title">@lang('admin.category.keywords')</h3>
        @include('partials.lang_control', ['type' => 'text', 'attr' => 'keywords', 'model' => 'category'])
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <h3 class="block-title">@lang('admin.category.ids')</h3>
        {!! Form::text("sql_data[ids]", isset($category->sql_data['ids']) ? $category->sql_data['ids'] : '', ["class" => "form-control", "placeholder" => "Saparated by comma"]) !!}
    </div>
    <div class="col-sm-6">
        <h3 class="block-title">@lang('admin.category.price')</h3>
        {!! Form::text("sql_data[price]", isset($category->sql_data['price']) ? $category->sql_data['price'] : '', ["class" => "form-control", "placeholder" => "Price min - Price max"]) !!}
    </div>
</div>

@foreach($above as $key => $data)
    <h3 class="block-title">{{ \App\Term::getLocaleValue($data['name']) }}</h3>
    <div class="row">
        @if ($key === 'price')
            <div class="col-xs-12">
                {{ Form::number("sql_data[price][]", array_get($category->sql_data, 'price.0', ''), ['min' => 0, 'step' => 50, 'class' => 'price from']) }}<span style="margin: 0 1em;">-</span>{{ Form::number("sql_data[price][]", array_get($category->sql_data, 'price.1', ''), ['min' => 0, 'step' => 50, 'class' => 'price to']) }}
            </div>
        @else
            @foreach($data['values'] as $index => $value)
                <div class="col-sm-2">
                    <div class="checkbox"><label for="{{$key}}-{{$index}}">
                        {{ Form::checkbox("sql_data[{$key}][]", $index, in_array($index, (array) array_get($category->sql_data, $key, []), false)) }} {{ \App\Term::getLocaleValue($value) }}</label>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endforeach
@foreach($below as $key => $data)
    <h3 class="block-title">{{ \App\Term::getLocaleValue($data['name']) }}</h3>
    <div class="row">
        @foreach($data['values'] as $index => $value)
            <div class="col-sm-2">
                <div class="checkbox"><label for="{{$key}}-{{$index}}">
                        {{ Form::checkbox("sql_data[{$key}][]", $index, in_array($index, (array) array_get($category->sql_data, $key, []), false)) }} {{ \App\Term::getLocaleValue($value) }}</label></div>
            </div>
        @endforeach
    </div>
@endforeach

<div class="form-group">
    <div class="col-sm-4 col-sm-offset-4">
        <button type="submit" class="block-full-width btn btn-lg btn-primary">@lang('admin.common.save')</button>
    </div>
    @if (!empty($category->id))
    <div class="col-sm-2 col-sm-offset-2">
        <button type="submit" class="block-full-width btn btn-lg btn-danger">@lang('admin.common.delete')</button>
    </div>
    @endif
</div>

@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript">
        @foreach (array_keys($all_locales) as $localeCode)
        CKEDITOR.replace( 'description-{{ $localeCode }}', {
            language: '{{ $localeCode }}'
        });
        @endforeach
        $('#create-highlight').submit(function(event) {
            var self = $(this),
                from = parseInt(self.find('.price.from').val()) || 0,
                to   = parseInt(self.find('.price.to').val()) || 0;
            if (from === 0 && to === 0) self.find('.price').attr('disabled', true);
            else if (to === 0) self.find('.price.to').attr('type', 'text').val('max');
            else if (from >= to) {
                self.find('.price.from').val(to);
                self.find('.price.to').val(from);
            }
        });
    </script>
@endpush
