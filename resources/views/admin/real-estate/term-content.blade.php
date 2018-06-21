{{-- */
    $length = 10;
    $id     = 'local-' . str_shuffle(substr(str_repeat(md5(mt_rand()), 2 + $length / 32), 0, $length));
/* --}}
@if (isset($termId))
    {!! Form::open(['action' => ['Admin\TermController@update', 'real-estate', $termId], 'method' => 'PUT', $term->group . "." . $term->key]) !!}
@else
    {!! Form::open(['action' => ['Admin\TermController@store', 'real-estate'], 'id' => 'create-term', 'class' => 'modal-content']) !!}
@endif
{{ Form::hidden('type', 'real-estate') }}
<div class="modal-header bg-primary">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">@lang('admin.common.term'): @lang('admin.common.' . (isset($termId) ? 'edit' : 'create new'))</h4>
</div>
<div class="modal-body">
    <div class="form-group">
        <label for="">@lang('admin.common.filter name')</label>
        @include('partials.lang_control', ['type' => 'text', 'model' => 'term', 'attr' => '_name', 'class' => 'translate form-control'])
    </div>
    <div class="form-group">
        <div class="radio">
            <label><input type="radio" name="group" value="basic" {{ $term->group == 'basic' ? 'checked' : '' }}>@lang('admin.apartment.basic')</label>
            <label><input type="radio" name="group" value="details" {{ $term->group == 'details' ? 'checked' : '' }}>@lang('admin.apartment.equipment')</label>
        </div>
    </div>
    <div class="form-group">
        <div class="radio">
            <label><input type="radio" name="type" value="text" {{ isset($term) && $term->type == 'text' ? 'checked' : '' }}>Text</label>
            <label><input type="radio" name="type" value="single" {{ isset($term) && $term->type == 'single' ? 'checked' : '' }}>Select</label>
            <label><input type="radio" name="type" value="multiple" {{ isset($term) && $term->type == 'multiple' ? 'checked' : '' }}>Checkbox</label>
        </div>
    </div>
    <div class="{{ $term->type == 'text' ? 'hidden' : '' }}" id="values-wrapper">
        <div class="form-group row add-new-value">
            <div class="col-sm-9">
                @include('partials.lang_control', ['type' => 'text', 'class' => 'term-value translate form-control'])
            </div>
            <div class="col-sm-3">
                <button type="button" class="table-insert btn btn-primary btn-block">@lang('admin.common.add new')</button>
            </div>
        </div>
        <table class="dataTable display" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @if (isset($term) && is_array($term->_values))
                @foreach($term->_values as $index => $values)
                    <tr>
                        <td><i class="fa fa-arrows"></i></td>
                        <td>@include('partials.lang_control', ['type' => 'text', 'model' => 'values', 'array_index' => $index, 'class' => 'translate form-control'])</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger">@lang('admin.common.delete')</button>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('admin.common.cancel')</button>
    <button type="submit" class="btn btn-sm btn-primary" data-loading-text="Saving...">@lang('admin.common.save')</button>
</div>
{!! Form::close() !!}
