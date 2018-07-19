@extends('admin.layout.base')

@section('styles')
	<style type="text/css">
		.ace_editor {
			height: 600px;
		}
		#preview {
			border: none;
			background: white;
			min-height: 500px;
		}
		.select2-container {
			width: 100% !important;
		}
	</style>
@endsection

@section('view-page')
    <a class="btn btn-info view-page" href="{{ url($page->permalink) }}" target="_blank">@lang('admin.common.view')</a>
@endsection

@section('content')
	<div class="content-wrapper">
		<section class="content-header">
			<h1>@lang('admin.entity.page')： @lang('admin.common.edit')</h1>
			<ol class="breadcrumb">
				<li><a href="{{ route('admin.dashboard') }}">@lang('admin.entity.home')</a></li>
				<li><a href="{{ action('Admin\PageController@index') }}">@lang('admin.entity.page')</a></li>
				<li class="active">@lang('admin.common.edit')</li>
			</ol>
		</section>
		<!-- Main content -->
		<section class="content">

			<div class="row">
				<section class="col-lg-12">
					<div class="box box-solid">
						<div class="box-body nopadding">
							@include('partials.validations')
							<form id="create-page" action="{{ action('Admin\PageController@update', $page->id) }}" method="POST" class="row" role="form" target="_self">
								{{ method_field('PUT') }}
								{{ csrf_field() }}
								<div class="col-sm-12">
								    <div class="form-group row">
								        <label for="title" class="col-sm-2 control-label">@lang('admin.review.title')</label>
								        <div class="col-sm-10">
								            @include('partials.lang_control', ['type' => 'text', 'attr' => "title", 'model' => 'page'])
								        </div>
								    </div>
								    <div class="form-group row">
								        <label for="permalink" class="col-sm-2 control-label">@lang('admin.common.permalink')</label>
								        <div class="col-sm-8">
								            <input type="text" class="form-control" id="permalink" name="permalink" value="{{ $page->permalink }}" required="" pattern="^[\w\-\/]+[a-zA-Z\d]$" title="{{ str_replace('.', '', trans('validation.url', ['attribute' => 'permalink'])) }}">
								        </div>
								    </div>
								    <div class="form-group row">
								        <label for="status" class="col-sm-2 control-label">@lang('admin.review.visible title')</label>
								        <div class="col-sm-2">
								        	{{ Form::select('status', array(\App\Page::VISIBILITY_PUBLIC  => trans('admin.review.visible.public'), \App\Page::VISIBILITY_PRIVATE => trans('admin.review.visible.private'), \App\Page::VISIBILITY_HIDDEN  => trans('admin.review.visible.hidden')), $page->status, ['class' => 'form-control']) }}
								        </div>
								    </div>
								    <div class="form-group row">
								        <div class="col-xs-12 text-right">
								        	<button class="btn btn-default btn-action btn-preview" type="submit" name="action" value="preview">@lang('admin.review.preview')</button>
								            <button class="btn btn-primary btn-action btn-save" type="submit" name="action" value="save">@lang('admin.common.edit')</button>
								            {{-- <button class="btn btn-danger btn-action btn-delete">@lang('admin.common.delete')</button> --}}
								        </div>
								    </div>
								    {{-- Nếu là contact thì không hiện --}}
								    @if (!in_array($page->id, [6]))
								    <div class="form-group">
								    	<button type="button" class="btn btn-default insert-media add_media multi" data-toggle="modal" href="#modal-upload"><i class="fa fa-picture-o" aria-hidden="true"></i> @lang('admin.common.upload btn')</button>
									    <div id="kcfinder_div_wrapper"><div id="kcfinder_div" class="kcfinder_div"></div></div>
								    </div>
								    <div class="form-group" role="tabpanel">
								        <ul class="nav nav-tabs" role="tablist">
								        	@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
									        	<li role="presentation" class="{{ $current_locale === $localeCode ? 'active' : '' }}">
									                <a class="text-uppercase" href="#html-{{ $localeCode }}" aria-controls="html-{{ $localeCode }}" role="tab" data-toggle="tab" data-tab-lang="{{ $localeCode }}">HTML-{{ $localeCode}}</a>
									            </li>
								        	@endforeach
								            <li role="presentation">
								                <a href="#css" aria-controls="css" role="tab" data-toggle="tab">CSS</a>
								            </li>
								        </ul>
								        <div class="tab-content">
								        	@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
								        	<div role="tabpanel" class="tab-pane{{ $current_locale === $localeCode ? ' active' : '' }}" id="html-{{ $localeCode }}">
								                <div id="editor-html-{{ $localeCode }}" class="editor editor-html">{{ $page->translate('html', $localeCode) }}</div>
								                <textarea class="hidden" name="html[{{ $localeCode }}]">{{ $page->translate('html', $localeCode) }}</textarea>
								            </div>
								            @endforeach
								            <div role="tabpanel" class="tab-pane" id="css">
								                <div id="editor-css" class="editor editor-css">{{ $page->css }}</div>
								                <textarea class="hidden" name="css">{{ $page->css }}</textarea>
								            </div>
								        </div>
								    </div>
								    @endif
								</div>
							</form>
						</div>
					</div>
				</section>
			</div>
		</section>
	</div>
@endsection

@section('scripts')
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/ace/1.2.3/ace.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/ace/1.2.3/mode-html.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/ace/1.2.3/mode-css.js"></script>
	<script type="text/javascript">
		editor      = [];
		form        = $('#create-page');
		$page_media = $('#page-media-button');
		_TOKEN      = $('input[name="_token"]').val();
		$('.editor').each(function(index, el) {
			var name = $(el).attr('id'),
				mode = $(el).attr('class').replace('editor editor-', '');
			$(el).css('font-size', '14px');
			editor[name] = ace.edit(name);
			editor[name].setTheme("ace/theme/monokai");
			editor[name].getSession().setMode("ace/mode/" + mode);
	    	//editor[name].getSession().setUseWrapMode(true);
	    	editor[name].getSession().on('change', function () {
		      	$(el).next('textarea').val(editor[name].getSession().getValue());
		   	});
		});

		form.submit(function(event) {
			var btn_val = $(this).find(".btn-action:focus").val();
			if (btn_val === 'preview') {
				form.attr({
					action: '{{ action('Admin\PageController@preview', $page->id) }}',
					target: 'vnh_preview'
				}).children('input[name="_method"]').val('POST');
			} else if (btn_val === 'save') {
				form.attr({
					action: '{{ action('Admin\PageController@update', $page->id) }}',
					target: '_self'
				}).children('input[name="_method"]').val('PUT');
			}
		});

		$('.btn-delete').click(function(event) {
			event.preventDefault();
			if (!confirm('{{ trans('admin.common.Are you sure?') }}')) return;
			$('<form>', {
                'action': '{{ action('Admin\PageController@destroy', $page->id) }}',
                'method': 'POST',
                'html': '<input name="_method" value="DELETE" type="hidden"><input name="_token" value="' + _TOKEN + '" type="hidden">'
            }).appendTo('body').submit();
		});

		/*$page_media.click(function(event) {
			event.preventDefault();
			openKCFinder(function($files) {
				var name = $('.tab-pane.active > .editor').attr('id');
				for (var i = 0; i < $files.length; i++) {
					editor[name].insert('<img src="' + $files[i].url.replace('-image(300x300-crop)', '') + '" class="img-responsive" alt="">\r\n');
				}
			});
		});*/
		dropzone_multi.destroy();
		dropzone_multi = new Dropzone("#upload-multi", {
		    url: '{{ LaravelLocalization::getNonLocalizedURL(action('Admin\ResourceController@upload')) }}',
		    parallelUploads: 5,
		    maxFilesize: 3,
		    paramName: 'upload',
		    uploadMultiple: true,
		    thumbnailWidth: 150,
		    thumbnailHeight: 150,
		    acceptedFiles: 'image/*',
		    sending: function(file, xhr, formData) {
		        formData.append("dir", 'page');
		    },
		    successmultiple: function(files, response) {
		        $('.editor').each(function(index, el) {
					for (var i = 0; i < response.length; i++) {
						editor[$(el).attr('id')].insert('<img src="' + response[i].mediumUrl + '" class="img-responsive" alt="">\r\n');
					}
		        });
		    }
		});
	</script>
@endsection
