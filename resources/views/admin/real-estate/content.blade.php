<div class="form-group">
    <label for="product_id" class="col-sm-2 control-label nopadding">ID</label>
    <div class="col-sm-2">
        {{ Form::number('product_id', $estate->product_id, ['id' => 'product_id', 'class' => 'form-control', 'required' => 'required', 'min' => 10000]) }}
    </div>
    <label for="status" class="col-sm-2 control-label">@lang('admin.review.visible title')</label>
    <div class="col-sm-2">
        {{ Form::select('status', array(\App\Estate::VISIBILITY_PUBLIC  => trans('admin.review.visible.public'), \App\Estate::VISIBILITY_PRIVATE => trans('admin.review.visible.private'), \App\Estate::VISIBILITY_HIDDEN  => trans('admin.review.visible.hidden')), $estate->status, ['class' => 'selectpicker form-control']) }}
    </div>
    <label for="name" class="col-sm-2 control-label nopadding">@lang('admin.common.sticky')</label>
    <div class="col-sm-2">{{ Form::checkbox('sticky', null, $estate->is_sticky) }}</div>
</div>
<div class="form-group">
    <label for="title" class="col-sm-2 control-label nopadding">@lang('admin.review.title')</label>
    <div class="col-sm-6">
        @include('partials.lang_control', ['type' => 'text', 'attr' => "title", 'model' => 'estate'])
    </div>
</div>
<div class="form-group">
    <label for="price" class="col-sm-2 control-label nopadding">@lang('admin.apartment.price')</label>
    <div class="col-sm-2">
        {{ Form::number('price', $estate->price, ['id' => 'price', 'class' => 'form-control', 'required' => 'required', 'min' => 0]) }}
    </div>
    <div class="col-sm-1 control-label nopadding" style="text-align: left;">USD</div>
</div>
@if (!empty($estate->id))
<div class="form-group">
    <label for="updated-at" class="col-sm-2 control-label nopadding">@lang('admin.review.updated at')</label>
    <div class="col-sm-2">
        <input type="text" name="custom_updated_at" id="updated-at" class="form-control estate-timestamps datetimepicker" data-date-format="dd/mm/yyyy" value="{{ $estate->updated_at }}" readonly="">
    </div>
</div>
@endif
<div class="form-group">
    <label for="category_id" class="col-sm-2 control-label nopadding">@lang('admin.entity.category')</label>
    <div class="col-sm-10">
        <select name="category_ids[]" id="category_ids" class="selectpicker form-control" multiple>
            @foreach(\App\Category::all() as $value)
                @if(intval($value->status) != 2)
                <option value="{{ $value->id }}" {{ in_array($value->id, explode(',', $estate->category_ids)) ? 'selected' : '' }}>{{ $value->title }}</option>
                @endif
            @endforeach
        </select>
    </div>
</div>
<div class="form-group single">
   
    <?php $term_count = 1; ?>
    @if (!empty($above) && count($above) > 0)
    @foreach($above as $key => $data)
        <label for="{{$key}}" class="col-sm-2 control-label nopadding">{{ \App\Term::getLocaleValue($data['name']) }}</label>
        <div class="col-sm-2">
            @if (in_array($key, ['price', 'size']))
                {{ Form::number("term[{$key}]", (int) $estate->{$key}, ['min' => 0, 'class' => 'form-control', 'id' => $key]) }}
            @elseif ($data['type'] == 'text')
                {{ Form::text("term[{$key}]", $estate->{$key}, ['class' => 'form-control', 'id' => $key]) }}
            @elseif($data['type'] == 'single')
                <select name="term[{{$key}}]" id="{{$key}}" class="selectpicker form-control">
                    <option value="" {{ empty($estate->{$key."_raw"}) ? 'selected' : '' }}>--</option>
                    @foreach($data['values'] as $index => $value)
                        <option value="{{$index}}" {{ (int) $estate->{$key."_raw"} === $index ? 'selected' : '' }}>{!! \App\Term::getLocaleValue($value) !!}</option>
                    @endforeach
                </select>
            @endif
        </div>
    @endforeach
    @endif
</div>
@if (!empty($below) && count($below) > 0)
@foreach($below as $key => $data)
    <h3 class="block-title">{{ \App\Term::getLocaleValue($data['name']) }}</h3>
    <div class="row">
        @foreach($data['values'] as $index => $value)
            <div class="col-sm-2">
                <div class="checkbox"><label for="{{$key}}-{{$index}}">
                {{ Form::checkbox("term[{$key}][]", (string) $index, in_array($index, (array) $estate->{$key}), ['class' => 'checkbox ' . $key]) }} {{ \App\Term::getLocaleValue($value) }}</label></div>
            </div>
        @endforeach
    </div>
@endforeach
@endif

<h3 class="block-title">@lang('admin.apartment.description')</h3>
@include('partials.lang_control', ['type' => 'textarea', 'attr' => "description", 'model' => 'estate', 'class' => 'editor form-control'])
<h3 class="block-title">@lang('admin.apartment.map')</h3>
<div class="form-group">
    <div class="col-xs-12">
        <label for="lat">@lang('admin.apartment.lat')</label>
        {{ Form::text('lat', $estate->lat, ['id' => 'lat', 'class' => 'form-control', 'style' => 'display: inline-block; width: auto;']) }}&nbsp;&nbsp;&nbsp;
        <label for="lng">@lang('admin.apartment.lng')</label>
        {{ Form::text('lng', $estate->lng, ['id' => 'lng', 'class' => 'form-control', 'style' => 'display: inline-block; width: auto;']) }}
        <button type="button" id="btn-map" class="btn btn-sm btn-primary">@lang('admin.review.preview')</button>
    </div>
</div>
<input id="pac-input" class="controls" type="text" placeholder="@lang('admin.common.search')">
<div id="googlemap"></div>
<h3 class="block-title">@lang('admin.apartment.upload')</h3>
<div class="form-group">
    <div class="col-xs-12">
        <button type="button" class="btn btn-default insert-media add_media multi" data-toggle="modal" href="#modal-upload"><i class="fa fa-picture-o" aria-hidden="true"></i> @lang('admin.common.upload btn')</button>
    </div>
</div>
<ul class="images-container sortable">
    @foreach($estate->resources as $image)
        <li class="item">
            <img src="{{ $image->estate_thumbnail }}" width="300" height="300" class="img-responsive" alt="">
            <input type="hidden" name="images[]" value="{{ $image->id }}"><button class="resource-delete" type="button">X</button>
        </li>
    @endforeach
</ul>
<div class="clearfix"></div>
<div class="form-group">
    <div class="col-sm-4 col-sm-offset-4">
        <button type="submit" class="block-full-width btn btn-lg btn-primary">@lang('admin.common.save')</button>
    </div>
    @if (!empty($estate->id))
    <div class="col-sm-2 col-sm-offset-2">
        <button type="submit" class="block-full-width btn btn-lg btn-danger">@lang('admin.common.delete')</button>
    </div>
    @endif
</div>

@push('scripts')
    <script type="text/javascript" src="{{ asset('/js/ckeditor/ckeditor.js') }}"></script>
    <script src="//maps.googleapis.com/maps/api/js?key={{ env('APP_MAP_KEY') }}&libraries=places&callback=initMap&language={{ $current_locale }}" async defer></script>
    <script type="text/javascript">
        var map, init_marker,
            $btn_map    = $('#btn-map'),
            $lat        = $('#lat'),
            $lng        = $('#lng'),
            $size       = $('#size'),
            $size_range = $('#size_rangefor_search');
        @foreach (array_keys($all_locales) as $localeCode)
        CKEDITOR.replace( 'description-{{ $localeCode }}', {
            language: '{{ $localeCode }}'
        });
        @endforeach

        function initMap() {
            var latlng = new google.maps.LatLng(10.7883447, 106.6955799),
                lat = $lat.val(), lng = $lng.val();
            if ($.isNumeric(lat) && $.isNumeric(lng)) latlng = new google.maps.LatLng(Math.abs(parseFloat(lat)), Math.abs(parseFloat(lng)));

            map = new google.maps.Map(document.getElementById("googlemap"), {
                zoom: 13,
                center: latlng
            });

            init_marker = new google.maps.Marker({
                draggable: true,
                position: latlng,
                map: map
            });

            google.maps.event.addListener(init_marker, 'dragend', function (event) {
                document.getElementById("lat").value = this.getPosition().lat();
                document.getElementById("lng").value = this.getPosition().lng();
            });

            var input = document.getElementById('pac-input');
            var searchBox = new google.maps.places.SearchBox(input);
            var first_search = false;
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            // Bias the SearchBox results towards current map's viewport.
            map.addListener('bounds_changed', function() {
                searchBox.setBounds(map.getBounds());
                if (this.getZoom() > 13 && !first_search) {
                    first_search = true;
                    this.setZoom(13);
                }
            });

            var markers = [];
            searchBox.addListener('places_changed', function() {
                first_search = false;
                var places = searchBox.getPlaces();

                if (places.length === 0) return;

                markers.forEach(function(marker) {
                    marker.setMap(null);
                });
                markers = [];

                var bounds = new google.maps.LatLngBounds();
                places.forEach(function(place) {
                    if (!place.geometry) return;

                    var marker = new google.maps.Marker({
                        map: map,
                        title: place.name,
                        position: place.geometry.location,
                        draggable: true
                    });
                    google.maps.event.addListener(marker, 'dragend', function (event) {
                        document.getElementById("lat").value = this.getPosition().lat();
                        document.getElementById("lng").value = this.getPosition().lng();
                    });
                    markers.push(marker);

                    if (place.geometry.viewport) bounds.union(place.geometry.viewport);
                    else bounds.extend(place.geometry.location);
                });
                map.fitBounds(bounds);
                markers.forEach(function(marker) {
                    document.getElementById("lat").value = marker.getPosition().lat();
                    document.getElementById("lng").value = marker.getPosition().lng();
                });
            });
        }

        $('#create-estate').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        $btn_map.click(function(event) {
            var lat = $lat.val(), lng = $lng.val();
            if (!$.isNumeric(lat) || !$.isNumeric(lng)) {
                toastr.error('Lat and lng must be numeric');
                return;
            }
            var position = new google.maps.LatLng(Math.abs(parseFloat(lat)), Math.abs(parseFloat(lng)));
            map.panTo(position);
            marker.setPosition(position);
        });

        $('input.checkbox.facilities[value="1"]').closest('.col-sm-2').css({
            visibility: 'hidden',
            position: 'absolute',
            left: '-9999px'
        });

        $('input.checkbox.facilities').on('ifChecked', function() {
            if ($(this).val() === '212' || $(this).val() === '213')
                $('input.checkbox.facilities[value="1"]').iCheck('check');
        }).on('ifUnchecked', function() {
            if (!$('input.checkbox.facilities[value="212"]')[0].checked && !$('input.checkbox.facilities[value="213"]')[0].checked)
                $('input.checkbox.facilities[value="1"]').iCheck('uncheck');
        });

        jQuery.fn.reverse = [].reverse;

        $size.blur(function(event) {
            var size = $(this).val().match(/\d+/);
            if (size === null) return;
            size = parseInt(size[0]);
            $size_range.find('option').reverse().each(function(index, el) {
                var first = parseInt($(el).text().match(/\d+/)[0]);
                if ((first === 50 && size <= first) || (size >= first)) {
                    $size_range.select2().val($(el).val()).trigger('change');
                    return false;
                }
            });
        });
    </script>
@endpush
