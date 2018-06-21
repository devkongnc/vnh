return [
@foreach($repo->currentData as $key => $term)
    '{{ $key }}' => [
        'name' => '{!! $term['name'] !!}',
        'group' => '{!! $term['group'] !!}',
        @if (isset($term['type']))'type' => '{!! $term['type'] !!}',@endif
        @if (isset($term['deletable']))'deletable' => true,@endif
        @if (isset($term['unit']))'unit' => '{!! $term['unit'] !!}',@endif

        @if (isset($term['values']))@if (is_array($term['values']))'values' => [
            @foreach($term['values'] as $index => $value)
'{{ $index }}' => '{!! $value !!}',
            @endforeach

        ]
            @else
                'values' => '{!! $term['values'] !!}',
            @endif
        @endif

    ],
@endforeach
];
