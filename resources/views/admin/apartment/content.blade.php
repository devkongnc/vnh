<div class="form-group">
    <label for="status" class="col-sm-2 control-label">@lang('admin.review.visible title')</label>
    <div class="col-sm-2">
        {{ Form::select('status', array(\App\Page::VISIBILITY_PUBLIC  => trans('admin.review.visible.public'), \App\Page::VISIBILITY_PRIVATE => trans('admin.review.visible.private'), \App\Page::VISIBILITY_HIDDEN  => trans('admin.review.visible.hidden')), $apartment->status, ['class' => 'selectpicker form-control']) }}
    </div>
    <label for="sticky" class="col-sm-2 control-label">@lang('admin.common.sticky')</label>
    <div class="col-sm-2">
        {{ Form::checkbox('sticky', null, $apartment->sticky) }}
    </div>
</div>
<div class="form-group">
    <label for="title" class="col-sm-2 control-label">@lang('admin.review.title')</label>
    <div class="col-sm-6">
        @include('partials.lang_control', ['type' => 'text', 'attr' => "title", 'model' => 'apartment'])
    </div>
</div>
<div class="form-group">
    <label for="permalink" class="col-sm-2 control-label">@lang('admin.review.permalink')</label>
    <div class="col-sm-6">
        {{ Form::text('permalink', $apartment->permalink, ['id' => 'permalink', 'class' => 'form-control', 'required' => 'required']) }}
    </div>
</div>
<div class="form-group">
    <label for="meta_title" class="col-sm-2 control-label">@lang('admin.category.meta title')</label>
    <div class="col-sm-6">
        @include('partials.lang_control', ['type' => 'text', 'attr' => "meta_title", 'model' => 'apartment'])
    </div>
</div>
<div class="form-group">
    <label for="meta_keywords" class="col-sm-2 control-label">@lang('admin.category.meta keywords')</label>
    <div class="col-sm-6">
        @include('partials.lang_control', ['type' => 'text', 'attr' => "meta_keywords", 'model' => 'apartment'])
    </div>
</div>
<div class="form-group">
    <label for="meta_description" class="col-sm-2 control-label">@lang('admin.category.meta description')</label>
    <div class="col-sm-6">
        @include('partials.lang_control', ['type' => 'text', 'attr' => "meta_description", 'model' => 'apartment'])
    </div>
</div>
<div class="form-group">
    <label for="product_id" class="col-sm-2 control-label">{{ \App\Term::getLocaleValue(Config::get('real-estate.area.name')) }}</label>
    <div class="col-sm-2">
        <select name="area" id="area" class="selectpicker form-control">
            <option value="" {{ empty($apartment->area) ? 'selected' : '' }}>--</option>
            @foreach(Config::get('real-estate.area.values') as $index => $value)
                <option value="{{$index}}" {{ $apartment->area == $index ? 'selected' : '' }}>{{ \App\Term::getLocaleValue($value) }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <label for="recommend" class="col-sm-2 control-label">@lang('admin.apartment.recommend')</label>
    <div class="col-sm-2">
        {{ Form::number('recommend', $apartment->recommend, ['id' => 'recommend', 'class' => 'form-control', 'min' => 0, 'max' => 99]) }}
    </div>
</div>
<h3 class="block-title">@lang('admin.apartment.description')</h3>
@include('partials.lang_control', ['type' => 'textarea', 'attr' => "description", 'model' => 'apartment', 'class' => 'editor form-control'])
<h3 class="block-title">@lang('admin.apartment.map')</h3>
<div class="form-group">
    <div class="col-xs-12">
        <label for="lat">@lang('admin.apartment.lat')</label>
        {{ Form::text('lat', $apartment->lat, ['id' => 'lat', 'class' => 'form-control', 'style' => 'display: inline-block; width: auto;']) }}&nbsp;&nbsp;&nbsp;
        <label for="lng">@lang('admin.apartment.lng')</label>
        {{ Form::text('lng', $apartment->lng, ['id' => 'lng', 'class' => 'form-control', 'style' => 'display: inline-block; width: auto;']) }}
        <button type="button" id="btn-map" class="btn btn-sm btn-primary">@lang('admin.review.preview')</button>
    </div>
</div>
<input id="pac-input" class="controls" type="text" placeholder="@lang('admin.common.search')">
<div id="googlemap"></div>
<!-- <div class="form-group">
    <label for="" class="col-sm-2 control-label">@lang('admin.apartment.estates')</label>
    <div class="col-sm-6">
        <input id="tags" value="{{-- implode(',', $apartment->estates->pluck('product_id')->all()) --}}" />
    </div>
</div> -->
@foreach ($terms->pluck('group')->unique()->all() as $group)
    <h3 class="block-title">@lang('admin.apartment.' . $group)</h3>
    @foreach($terms->filter(function($item) use($group) { return $item['group'] === $group; }) as $key => $data)
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">{{ \App\Term::getLocaleValue($data['name']) }}</label>
            <div class="col-sm-6">
                @include('partials.lang_control', ['type' => 'text', 'attr' => $key, 'model' => 'apartment'])
            </div>
        </div>
    @endforeach
@endforeach
<h3 class="block-title">@lang('admin.apartment.upload')</h3>
<div class="form-group">
    <div class="col-xs-12">
        <button type="button" class="btn btn-default insert-media add_media multi" data-toggle="modal" href="#modal-upload"><i class="fa fa-picture-o" aria-hidden="true"></i> @lang('admin.common.upload btn')</button>
    </div>
</div>
<ul class="images-container sortable">
    @foreach($apartment->resources as $image)
        <li class="item">
            <img src="{{ $image->estate_thumbnail }}" class="img-responsive" width="300" height="300" alt="">
            <input type="hidden" name="images[]" value="{{ $image->id }}"><button class="resource-delete" type="button">X</button>
        </li>
    @endforeach
</ul>
<div class="clearfix"></div>
<div class="form-group">
    <div class="col-sm-4 col-sm-offset-4">
        <button type="submit" class="block-full-width btn btn-lg btn-primary">@lang('admin.common.save')</button>
    </div>
    @if (!empty($apartment->id))
    <div class="col-sm-2 col-sm-offset-2">
        <button type="submit" class="block-full-width btn btn-lg btn-danger">@lang('admin.common.delete')</button>
    </div>
    @endif
</div>

@section('scripts')
    <script type="text/javascript" src="{{ asset('/js/ckeditor/ckeditor.js') }}"></script>
    <script src="//maps.googleapis.com/maps/api/js?key={{ env('APP_MAP_KEY') }}&libraries=places&callback=initMap&language={{ $current_locale }}" async defer></script>
    <script type="text/javascript">
        var map, init_marker,
            $btn_map = $('#btn-map'),
            $lat     = $('#lat'),
            $lng     = $('#lng');
        //var estates_init = $('#tags').val();
        @foreach (array_keys($all_locales) as $localeCode)
        CKEDITOR.replace( 'description-{{ $localeCode }}', {
            language: '{{ $localeCode }}'
        });
        @endforeach

        function initMap() {
            var latlng = new google.maps.LatLng(10.821442395967052, 106.62719740742182),
                lat = $lat.val(), lng = $lng.val();
            if ($.isNumeric(lat) && $.isNumeric(lng)) latlng = new google.maps.LatLng(Math.abs(parseFloat(lat)), Math.abs(parseFloat(lng)));

            map = new google.maps.Map(document.getElementById("googlemap"), {
                zoom: 14,
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
                if (this.getZoom() > 14 && !first_search) {
                    first_search = true;
                    this.setZoom(14);
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

        $('#create-apartment').on('keyup keypress', function(e) {
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
        /*$('#tags').tagsInput({
            defaultText: '',
            width: '100%',
            onAddTag: function(tag) {
                if(!Math.floor(tag) == tag || !$.isNumeric(tag)) {
                    $(this).removeTag(tag);
                    $('#tags_tag').focus();
                }
            }
        });
        $('#create-apartment').submit(function(event) {
            var self    = $(this),
                inputs  = '',
                estates = self.find('#tags').val();
            if (estates !== '' && estates !== estates_init) {
                estates = estates.split(',');
                for (var i = 0; i < estates.length; i++) {
                    inputs += '<input type="hidden" name="estates[]" value="' + estates[i] + '" >';
                }
                $(this).append(inputs)
            }
        });*/
    </script>
@stop
