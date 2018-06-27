@extends('admin.layout.base')

@section('styles')
    <link rel="stylesheet" type="text/css"
          href="//cdn.datatables.net/rowreorder/1.1.2/css/rowReorder.dataTables.min.css">
    <style type="text/css">
        h3 {
            border-bottom: 2px solid black;
            padding-bottom: 5px;
        }

        .radio > label {
            margin-right: 10px;
        }

        .radio > label > input[type="radio"] {
            margin-left: -17px;
        }

        .dataTable  > tbody > tr > td:first-child {
            width: 10px;
            text-align: center;
        }

        table > tbody > tr > td:last-child {
            text-align: right;
        }

        .table-insert {
            margin-top: 1.8em;
        }

        tbody > tr > td > .property-languages {
            display: none;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>@lang('admin.entity.estate')： @lang('admin.common.term')</h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">@lang('admin.entity.home')</a></li>
                <li><a href="{{ action('Admin\RealEstateController@index') }}">@lang('admin.entity.estate')</a></li>
                <li class="active">@lang('admin.common.term')</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <section class="col-lg-12">
                    <div class="row">
                        <div class="col-xs-12">@include('partials.validations')</div>
                        <div class="col-sm-2"><button type="button" class="btn btn-primary" data-toggle="modal" href='#modal-term-edit' data-mode="create">@lang('admin.common.create new')</button></div>
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <h3>@lang('admin.apartment.basic')</h3>
                            <table class="table table-hover term">
                                <tbody>
                                    <?php
                                    $conf_real_estate = is_array(Config::get('real-estate')) ? Config::get('real-estate') : [];
                                    if (!empty($conf_real_estate) && count($conf_real_estate) > 0 ) {
                                        $basic = array_filter(Config::get('real-estate'), function($item) { return $item['group'] == 'basic'; });
                                    } else {
                                        $basic = [];
                                    } ?>
                                    @if (!empty($basic))
                                    @foreach($basic as $key => $data)
                                        <tr>
                                            <td>{{ \App\Term::getLocaleValue($data['name']) }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary" data-key="basic.{{ $key }}" data-mode="edit">@lang('admin.common.edit')</button>
                                                @if (isset($data['deletable']))
                                                    <button type="button" class="btn btn-sm btn-danger" data-name="{{\App\Term::getLocaleValue($data['name'])}}" data-key="basic.{{ $key }}" data-toggle="modal" href="#deleteModal">@lang('admin.common.delete')</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h3>@lang('admin.apartment.equipment')</h3>
                            <table class="table table-hover term">
                                <tbody>
                                <?php
                                if (!empty($conf_real_estate) && count($conf_real_estate) > 0 ) {
                                    $details = array_filter(Config::get('real-estate'), function($item) { return $item['group'] == 'details'; });
                                } else {
                                    $details = [];
                                }
                                ?>
                                @if (!empty($details))
                                @foreach($details as $key => $data)
                                    <tr>
                                        <td>{{ \App\Term::getLocaleValue($data['name']) }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" data-key="details.{{ $key }}" data-mode="edit">@lang('admin.common.edit')</button>
                                            @if (isset($data['deletable']))
                                                <button type="button" class="btn btn-sm btn-danger" data-key="details.{{ $key }}" data-name="{{ \App\Term::getLocaleValue($data['name']) }}" data-toggle="modal" href="#deleteModal">@lang('admin.common.delete')</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </section>
        <div class="modal fade" id="modal-term-edit" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">

            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="deleteModal" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    {!! Form::open(['action' => ['Admin\TermController@destroy', 'real-estate'], 'method' => 'DELETE']) !!}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">@lang('admin.common.term'): @lang('admin.common.delete')</h4>
                    </div>
                    <div class="modal-body">
                            <p>Do you really want to delete this term - <b id="deleteTermName"></b>?</p>
                            {!! Form::hidden('key', null, ['id' => 'term-id']) !!}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('admin.common.cancel')</button>
                        <button type="submit" class="btn btn-primary">@lang('admin.common.delete')</button>
                    </div>
                    {!! Form::close() !!}
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
@endsection

@section('scripts')
    <script type="text/javascript"
            src="//cdn.datatables.net/rowreorder/1.1.2/js/dataTables.rowReorder.min.js"></script>
    <script type="text/javascript">
        var languages = JSON.parse('{!! json_encode(LaravelLocalization::getSupportedLanguagesKeys()) !!}'),
            languages_label = JSON.parse('{!! json_encode(LaravelLocalization::getSupportedLocales()) !!}');

        var table, initialized = false;

        $('.modal').on('change', '[name="type"]', function(){
            if ($(this).val() == 'text') {
                $("#values-wrapper").addClass('hidden');
            } else {
                $("#values-wrapper").removeClass('hidden');
            }
        });

        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                if ($(event.target).is('.term-value')) {
                    $(event.target).parents("#values-wrapper").find(".table-insert").trigger("click");
                }
                event.preventDefault();
                return false;
            }
        });
        $('.modal').on('click', '.table-insert', function (event) {
            var parent = $(event.target).parents(".modal"),
                value = parent.find(".tab-pane.active .term-value").val(),
                order = null,
                input = '<ul class="property-languages list-unstyled">',
                id = Math.random() * 100000;

            if (value === '') return;

            if ($("#values-wrapper .dataTable tbody tr").find('.dataTables_empty').length > 0) order = 0;
            else {
                var keys = parent.find('tr .tab-pane.active > .form-control').map(function(index, elem) {
                    return parseInt($(elem).attr('name').match(/\d+/)[0]);
                }).get();
                order = Math.max.apply(Math, keys) + 1;
            }
            var id = order;

            $(languages).each(function (_, language) {
                var active = (language == current_locale) ? 'active' : '';
                input += '<li class="' + active + '"> <a href="#local-' + id + '-' + language +'" data-toggle="tab" data-tab-lang="' + language + '">' + languages_label[language]['native'] + '</a> </li>';
            });

            input += '</ul><div class="tab-content">';
            $(languages).each(function (_, language) {
                var active = (language == current_locale) ? 'active' : '';
                input += '<div class="tab-pane ' + active + '" id="local-' + id + '-' + language + '"> <input class="form-control translate form-control" data-lang="' + language + '" id="values[' + order + '][' + language + ']" name="values[' + order + '][' + language + ']" type="text" value="' + ((language == current_locale) ? value : '') + '"> </div>';
            });

            input += '</div>';

            table.row.add(['<i class="fa fa-arrows"></i>', input , '<button type="button" class="btn btn-sm btn-danger">@lang('admin.common.delete')</button>']);
            table.draw();

            $(".tab-pane .term-value").val("");
        });

        $('.table.term').on('click', '.btn', function (event) {
            if ($(this).hasClass('btn-primary')) {
                $('#modal-term-edit').modal('show', event.target);
            }
        });

        $("#deleteModal").on('show.bs.modal', function(e){
            var invoker = $(e.relatedTarget),
                key = invoker.data("key"),
                name = invoker.data('name');
            $(this).find("#term-id").val(key);
            $(this).find("#deleteTermName").text(name);
        });

        $('#modal-term-edit').on('show.bs.modal', function (e) {
            var $invoker = $(e.relatedTarget);
            var mode = $invoker.data("mode");
            $('#modal-term-edit .modal-dialog').html("@include('partials.css3-loading')");
            if (mode == "edit") {
                $.get('{{ action('Admin\TermController@edit', ['type' => 'real-estate', 'id' => 'id']) }}'.replace('id', $invoker.data('key')), function(data){
                    $('#modal-term-edit .modal-dialog').html(data);
                    initTables();
                });
            } else {
                $.get('{{ action('Admin\TermController@create', 'real-estate') }}', function(data){
                    $('#modal-term-edit .modal-dialog').html(data);
                    initTables();
                });
            }
        });

        function initTables() {
            table = $('.dataTable').DataTable({
                retrieve: true,
                columnDefs: [
                    {className: '', targets: 0}
                ],
                pageLength: -1,
                paging: false,
                ordering: false,
                filter: false,
                info: false,
                select: false,
                rowReorder: true
            });

            table.on('row-reorder', function ( e, diff, edit ) {
                console.log(diff);
            });

            table.on('click', '.btn-danger', function (event) {
                var wrapper = $(event.target).parents("form");
                var row = $(this).parents('tr');
                table.row(row).remove();
                table.draw();
            });
        }
    </script>
@endsection
