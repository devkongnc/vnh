@if (isset($term))
    {!! Form::open(['action' => ['Admin\TermController@update', 'apartment', $termId], 'method' => 'PUT']) !!}
@else
    {!! Form::open(['action' => ['Admin\TermController@store', 'apartment']]) !!}
@endif
{{ Form::hidden('type', 'apartment') }}
<div class="modal-header bg-primary">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">@lang('admin.common.term'): @lang('admin.common.' . ((isset($term) ? 'edit' : 'create new')))</h4>
</div>
<div class="modal-body">
    <div class="form-group">
        <label for="">@lang('admin.common.filter name')</label>
        @include('partials.lang_control', ['type' => 'text', 'model' => 'term', 'attr' => '_name', 'class' => 'translate form-control'])
    </div>
    <div class="form-group">
        <div class="radio">
            <label><input type="radio" name="group" value="basic" checked="checked" {{ isset($term) && $term->group == 'basic' ? 'checked' : '' }}>@lang('admin.apartment.basic')</label>
            <label><input type="radio" name="group" value="equipment" {{ isset($term) && $term->group == 'equipment' ? 'checked' : '' }}>@lang('admin.apartment.equipment')</label>
            <label><input type="radio" name="group" value="indoor_facilities" {{ isset($term) && $term->group == 'indoor_facilities' ? 'checked' : '' }}>@lang('admin.apartment.indoor_facilities')</label>
            <label><input type="radio" name="group" value="children_facilities" {{ isset($term) && $term->group == 'children_facilities' ? 'checked' : '' }}>@lang('admin.apartment.children_facilities')</label>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('admin.common.cancel')</button>
    <button type="submit" class="btn btn-sm btn-primary">@lang('admin.common.save')</button>
</div>
{!! Form::close() !!}
