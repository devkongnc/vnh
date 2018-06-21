@extends('admin.layout.base')

@section('styles')
	<style type="text/css">
		.form-group > label {
			margin-bottom: 5px;
		}
		.btn.btn-primary {
			display: block;
			margin-top: 20px;
		}
	</style>
@endsection

@section('content')
<div class="content-wrapper">
	<section class="content-header">
		<h1>@lang('admin.entity.page')： @lang('admin.entity.menu')</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('admin.dashboard') }}">@lang('admin.entity.home')</a></li>
			<li><a href="{{ action('Admin\PageController@index') }}">@lang('admin.entity.page')</a></li>
			<li class="active">@lang('admin.entity.menu')</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<section class="col-lg-12">
				<div class="box box-solid">
					<div class="box-body no-padding">
						@include('partials.validations')
						<div class="wrap-box row">
							<div class="left-menu-page col-sm-3">
								<h2>@lang('admin.common.list')</h2>
								<div class="contain-page">
									<form id="menu-add">
							            <div class="form-group">
							            	@foreach ($pages as $page)
							            		<div><label><input class="icheck checkmenu" type="checkbox" name="itmenus[]" data-text="{{ "$page->title ($page->permalink)" }}" value="{{ $page->id }}" />{{ "$page->title ($page->permalink)" }}</label></div>
							            	@endforeach
							            </div>
							            <button class="btn btn-primary" id="addButton">@lang('admin.common.add new')</button>
							        </form>
								</div>
							</div>
							<div class="col-sm-3">
								<h2>@lang('admin.page.custom link')</h2>
								<div class="contain-page">
									<form id="form-custom-link" action="" method="POST" role="form">
										<div class="form-group">
											<label for="url">URL</label>
											<input type="url" class="form-control" id="url" placeholder="Input field" value="http://" required="">
										</div>
										<div class="form-group">
											<label for="link-text">@lang('admin.page.link text')</label>
											@include('partials.lang_control', ['type' => 'text', 'class' => "link-text", 'attr' => 'link_text', 'placeholder' => 'Menu Item', 'required' => ''])
											{{-- <input type="text" class="form-control" id="link-text" placeholder="Menu Item" value="" required=""> --}}
										</div>
										<button class="btn btn-primary">@lang('admin.common.add new')</button>
									</form>
								</div>
							</div>
							<div class="right-menu-page col-sm-4 col-sm-offset-2">
								<h2>@lang('admin.entity.menu')</h2>
								<div class="list-menu">
									<form id="nestable" class="dd nestable" action="{{ action('Admin\PageController@menu') }}" method="post">
										{{ csrf_field() }}
										{{ showMenuAdmin($menu, $pages_by_id) }}
										<textarea id="json-output" class="hidden form-control" name="menu"></textarea>
										<button class="btn btn-primary" type="submit">@lang('admin.common.save')</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</section>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">

		/*jslint browser: true, devel: true, white: true, eqeq: true, plusplus: true, sloppy: true, vars: true*/
		/*global $ */

		/*************** General ***************/

		var updateOutput = function(e) {
		    var list = e.length ? e : $(e.target),
		        output = list.data('output');
		    if (window.JSON) {
		        if (output) {
		            output.val(window.JSON.stringify(list.nestable('serialize')));
		        }
		    } else {
		        alert('JSON browser support required for this page.');
		    }
		};

		var nestableList = $("#nestable > .dd-list");

		/***************************************/


		/*************** Delete ***************/

		var deleteFromMenuHelper = function(target) {
		    if (target.data('new') == 1) {
		        // if it's not yet saved in the database, just remove it from DOM
		        target.fadeOut(function() {
		            target.remove();
		            updateOutput($('#nestable').data('output', $('#json-output')));
		        });
		    } else {
		        // otherwise hide and mark it for deletion
		        target.appendTo(nestableList); // if children, move to the top level
		        target.data('deleted', '1');
		        target.fadeOut();
		    }
		};

		var deleteFromMenu = function() {
		    var targetId = $(this).data('owner-id');
		    var target = $('[data-id="' + targetId + '"]');

		    var result = confirm("Delete " + target.data('name') + " and all its subitems ?");
		    if (!result) {
		        return;
		    }

		    // Remove children (if any)
		    target.find("li").each(function() {
		        deleteFromMenuHelper($(this));
		    });

		    // Remove parent
		    deleteFromMenuHelper(target);

		    // update JSON
		    updateOutput($('#nestable').data('output', $('#json-output')));
		};

		/***************************************/


		/*************** Edit ***************/

		var menuEditor = $("#menu-editor");
		var editButton = $("#editButton");
		var editInputName = $("#editInputName");
		var editInputSlug = $("#editInputSlug");
		var currentEditName = $("#currentEditName");

		// Prepares and shows the Edit Form
		var prepareEdit = function() {
		    var targetId = $(this).data('owner-id');
		    var target = $('[data-id="' + targetId + '"]');

		    editInputName.val(target.data("name"));
		    editInputSlug.val(target.data("slug"));
		    currentEditName.html(target.data("name"));
		    editButton.data("owner-id", target.data("id"));

		    console.log("[INFO] Editing Menu Item " + editButton.data("owner-id"));

		    menuEditor.fadeIn();
		};

		// Edits the Menu item and hides the Edit Form
		var editMenuItem = function() {
		    var targetId = $(this).data('owner-id');
		    var target = $('[data-id="' + targetId + '"]');

		    var newName = editInputName.val();
		    var newSlug = editInputSlug.val();

		    target.data("name", newName);
		    target.data("slug", newSlug);

		    target.find("> .dd-handle").html(newName);

		    menuEditor.fadeOut();

		    // update JSON
		    updateOutput($('#nestable').data('output', $('#json-output')));
		};

		/***************************************/


		/*************** Add ***************/

		var newIdCount = 1;

		var addToMenu = function() {
		    var val = [];
		    var text = [];
		    $('.checkmenu:checkbox:checked').each(function(i) {
		        val[i] = $(this).val();
		        text[i] = $(this).data('text');
		        var newId = val[i];
		        nestableList.append(
		            '<li class="dd-item" ' +
		            'data-id="' + newId + '" ' +
		            'data-new="1" ' +
		            'data-deleted="0">' +
		            //'<input hidden name="menus[]" value="' + val[i] + '">' +
		            '<div class="dd-handle">' + text[i] + '</div> ' +
		            '<span class="button-delete btn btn-default btn-xs pull-right" ' +
		            'data-owner-id="' + newId + '"> ' +
		            '<i class="fa fa-times-circle-o" aria-hidden="true"></i> ' +
		            '</span>' +
		            '</li>'
		        );
		        $(this).iCheck('uncheck');
		    });

		    newIdCount++;

		    // update JSON
		    updateOutput($('#nestable').data('output', $('#json-output')));

		    // set events
		    $("#nestable .button-delete").on("click", deleteFromMenu);
		    $("#nestable .button-edit").on("click", prepareEdit);
		};



		/***************************************/



		$(function() {

		    // output initial serialised data
		    updateOutput($('#nestable').data('output', $('#json-output')));

		    // set onclick events
		    editButton.on("click", editMenuItem);

		    $("#nestable .button-delete").on("click", deleteFromMenu);

		    $("#nestable .button-edit").on("click", prepareEdit);

		    $("#menu-editor").submit(function(e) {
		        e.preventDefault();
		    });

		    $("#menu-add").submit(function(e) {
		        e.preventDefault();
		        addToMenu();
		    });

		    $('#form-custom-link').submit(function(event) {
		    	event.preventDefault();
		    	var self = $(this),
		    		url = self.find('#url').val();
		    		text = '';
		    	self.find('.link-text').each(function(index, el) {
		    		text += '[:' + $(el).data('lang') + ']' + $(el).val();
		    	});
		    	text += '[:]';
		    	var render_text = self.find('.link-text[data-lang="{{ $current_locale }}"]').val();

		    	nestableList.append(
		            '<li class="dd-item" data-id="' + text + '" data-url="' + url + '" data-new="1" data-deleted="0">' +
			            '<div class="dd-handle">' + render_text + '</div> ' +
			            '<span class="button-delete btn btn-default btn-xs pull-right" data-owner-id="' + text + '"> ' +
			            	'<i class="fa fa-times-circle-o" aria-hidden="true"></i> ' +
			            '</span>' +
		            '</li>'
		        );
		        newIdCount++;
			    // update JSON
			    updateOutput($('#nestable').data('output', $('#json-output')));
			    // set events
			    $("#nestable .button-delete").on("click", deleteFromMenu);
			    $("#nestable .button-edit").on("click", prepareEdit);
		    });

		});

    </script>

    <script type="text/javascript">
    	$nestable = $('#nestable');
    	$nestable.nestable({
    		maxDepth: 3
    	}).on('change', updateOutput);
    </script>
@endsection
