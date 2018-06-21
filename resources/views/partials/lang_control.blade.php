{{-- */
$length = 10;
$id     = 'local-' . str_shuffle(substr(str_repeat(md5(mt_rand()), 2 + $length / 32), 0, $length));
$disabled = isset($disabled) ? true : null;
$data = isset($$model) ? (isset($attr) ? (method_exists($$model, 'translate') ? $$model->translate($attr) : $$model->{$attr}) : (is_array($$model) ? $$model : [])) : [];
$nameString = isset($attr) ? "{$attr}" : (isset($model) ? $model : '');
if (isset($array_index)) $nameString .= "[{$array_index}]";
/* --}}
<ul class="property-languages list-unstyled">
    @foreach($all_locales as $localeCode => $properties)
        <li class="{{ ($current_locale == $localeCode) ? 'active' : '' }}">
            <a href="#{{ "{$id}-{$localeCode}" }}" data-toggle="tab" data-tab-lang="{{ $localeCode }}">{{{ $properties['native'] }}}</a>
        </li>
    @endforeach
</ul>
<div class="tab-content">
    @foreach($all_locales as $localeCode => $properties)
        <div class="tab-pane {{ ($current_locale == $localeCode) ? 'active' : '' }}" id="{{ "{$id}-{$localeCode}" }}">
            @if (isset($preAddon))
                <div class="input-group">
                    <span class="input-group-addon">{{ $preAddon }}</span>
                    {{ Form::text("{$nameString}[{$localeCode}]", ($data ? array_get($data, $localeCode) : Input::old("{$nameString}[{$localeCode}]")), ['class' => ('form-control ' . (isset($class) ? $class : '')), 'disabled' => $disabled, 'data-lang' => $localeCode, 'id' => "$nameString-$localeCode"]) }}
                </div>
            @else
                @if ($type == 'textarea')
                    {{ Form::textarea("{$nameString}[{$localeCode}]", ($data ? array_get($data, $localeCode) : Input::old("{$nameString}[{$localeCode}]")), ['class' => ('form-control ' . (isset($class) ? $class : '')), 'disabled' =>  $disabled, 'data-lang' => $localeCode, 'id' => "$nameString-$localeCode"]) }}
                @else
                    {{ Form::text("{$nameString}[{$localeCode}]", ($data ? array_get($data, $localeCode) : Input::old("{$nameString}[{$localeCode}]")), ['class' => ('form-control ' . (isset($class) ? $class : '')), 'disabled' =>  $disabled, 'data-lang' => $localeCode, 'id' => "$nameString-$localeCode"]) }}
                @endif
            @endif
        </div>
    @endforeach
</div>
