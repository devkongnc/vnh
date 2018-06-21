<header class="main-header">
	<a href="{{ route('home') }}" class="logo">
		<span class="logo-mini"><b>VNH</b></span>
		<span class="logo-lg">VietNamHouse</span>
	</a>
	<nav class="navbar navbar-static-top">
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"><span class="sr-only">Toggle navigation</span></a>
		@yield('view-page')
		<div class="navbar-custom-menu">
		    <ul class="nav navbar-nav">
		    	<li class="dropdown">
				    <a href="#" class="dropdown-toggle" data-toggle="dropdown">@lang('front.language') <span class="caret"></span></a>
				    <ul class="dropdown-menu" role="menu">
				    	@foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <li>
                            <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}">
                                {{ $properties['native'] }}
                            </a>
                        </li>
                        @endforeach
				    </ul>
				</li>

		        <li class="dropdown user user-menu">
		            <a aria-expanded="false" href="#" class="dropdown-toggle" data-toggle="dropdown">
		                <img src="{{ auth()->user()->post_thumbnail }}" class="user-image" alt="User Image">
		                <span class="hidden-xs">{{ auth()->user()->name }}</span>
		            </a>
		            <ul class="dropdown-menu">
		                <li class="user-header">
		                    <img src="{{ auth()->user()->post_thumbnail }}" width="160" class="img-circle" alt="User Image">
		                    <p>
		                        {{ auth()->user()->name }}
		                        <small>Member since {{ auth()->user()->created_at }}</small>
		                    </p>
		                </li>
		                <li class="user-footer">
		                    <div class="pull-left">
		                        <a href="{{ action('Admin\UserController@edit', 1) }}" class="btn btn-default btn-flat">Profile</a>
		                    </div>
		                    <div class="pull-right">
		                        <a href="{{ action('Auth\AuthController@getLogout') }}" class="btn btn-default btn-flat">Sign out</a>
		                    </div>
		                </li>
		            </ul>
		        </li>
		    </ul>
		</div>
	</nav>
</header>
<aside class="main-sidebar">
	<section class="sidebar">
		<ul class="nav sidebar-menu">
			<li class="treeview">
				<a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
			</li>
			<li class="treeview {{ Active::getClassIf(Active::checkController(['App\Http\Controllers\Admin\RealEstateController']) or Active::checkUriPattern(['*real-estate*'])) }}">
			    <a href="javascript:void(0)"><i class="fa fa-circle-o"></i> <span>Real Estate</span></a>
			    <ul class="nav treeview-menu">
			    	<li class="{{ Active::getClassIf(Active::checkAction(['App\Http\Controllers\Admin\RealEstateController@index'])) }}"><a href="{{ URL::action('Admin\RealEstateController@index') }}">Real Estate</a></li>
			        <li class="{{ Active::getClassIf(Active::checkAction(['App\Http\Controllers\Admin\RealEstateController@create'])) }}"><a href="{{ URL::action('Admin\RealEstateController@create') }}">Create New</a></li>
			        @can('manage-user')
						<li class="{{ Active::getClassIf(Active::checkAction(['App\Http\Controllers\Admin\TermController@index']) and Active::checkUriPattern(['*real-estate*'])) }}"><a href="{{ URL::action('Admin\TermController@index', 'real-estate') }}">Term</a></li>
					@endcan
			        <li class="{{ Active::getClassIf(Active::checkAction(['App\Http\Controllers\Admin\RealEstateController@search'])) }}"><a href="{{ URL::action('Admin\RealEstateController@search') }}">Search</a></li>
			    </ul>
			</li>
			<li class="treeview {{ Active::getClassIf(Active::checkController(['App\Http\Controllers\Admin\ApartmentController']) or Active::checkUriPattern(['*apartment*'])) }}">
			    <a href="javascript:void(0)"><i class="fa fa-circle-o"></i> <span>Apartment</span></a>
			    <ul class="nav treeview-menu">
			    	<li class="{{ Active::getClassIf(Active::checkAction(['App\Http\Controllers\Admin\ApartmentController@index'])) }}"><a href="{{ URL::action('Admin\ApartmentController@index') }}">Apartment</a></li>
			        <li class="{{ Active::getClassIf(Active::checkAction(['App\Http\Controllers\Admin\ApartmentController@create'])) }}"><a href="{{ URL::action('Admin\ApartmentController@create') }}">Create New</a></li>
					@can('manage-user')
			        	<li class="{{ Active::getClassIf(Active::checkAction(['App\Http\Controllers\Admin\TermController@index']) and Active::checkUriPattern(['*apartment*'])) }}"><a href="{{ URL::action('Admin\TermController@index', 'apartment') }}">Term</a></li>
					@endcan
			    </ul>
			</li>
			<li class="treeview {{ Active::getClassIf(Active::checkController(['App\Http\Controllers\Admin\ReviewController'])) }}">
			    <a href="javascript:void(0)"><i class="fa fa-circle-o"></i> <span>Review</span></a>
			    <ul class="nav treeview-menu">
			    	<li class="{{ Active::getClassIf(Active::checkAction(['App\Http\Controllers\Admin\ReviewController@index'])) }}"><a href="{{ URL::action('Admin\ReviewController@index') }}">Review</a></li>
			        <li class="{{ Active::getClassIf(Active::checkAction(['App\Http\Controllers\Admin\ReviewController@create'])) }}"><a href="{{ URL::action('Admin\ReviewController@create') }}">Create New</a></li>
			    </ul>
			</li>
			<li class="treeview {{ Active::getClassIf(Active::checkController(['App\Http\Controllers\Admin\CategoryController'])) }}">
			    <a href="javascript:void(0)"><i class="fa fa-circle-o"></i> <span>Category</span></a>
			    <ul class="nav treeview-menu">
			    	<li class="{{ Active::getClassIf(Active::checkAction(['App\Http\Controllers\Admin\CategoryController@index'])) }}"><a href="{{ URL::action('Admin\CategoryController@index') }}">Category</a></li>
			        <li class="{{ Active::getClassIf(Active::checkAction(['App\Http\Controllers\Admin\CategoryController@create'])) }}"><a href="{{ URL::action('Admin\CategoryController@create') }}">Create New</a></li>
			    </ul>
			</li>
			<li class="treeview {{ Active::getClassIf(Active::checkController(['App\Http\Controllers\Admin\PageController'])) }}">
			    <a href="javascript:void(0)"><i class="fa fa-circle-o"></i> <span>Static Page</span></a>
			    <ul class="nav treeview-menu">
			    	<li class="{{ Active::getClassIf(Active::checkAction(['App\Http\Controllers\Admin\PageController@index'])) }}"><a href="{{ URL::action('Admin\PageController@index') }}">Static Page</a></li>
			        <li class="{{ Active::getClassIf(Active::checkAction(['App\Http\Controllers\Admin\PageController@create'])) }}"><a href="{{ URL::action('Admin\PageController@create') }}">Create New</a></li>
			        <li class="{{ Active::getClassIf(Active::checkAction(['App\Http\Controllers\Admin\PageController@menu'])) }}"><a href="{{ URL::action('Admin\PageController@menu') }}">Menu</a></li>
			    </ul>
			</li>
			<li class="treeview">
				<a href="{{ action('Admin\ContactController@index') }}"><i class="fa fa-circle-o"></i> <span>Contact</span></a>
			</li>
			@can('manage-user')
			<li class="treeview {{ Active::getClassIf(Active::checkController(['App\Http\Controllers\Admin\UserController'])) }}">
			    <a href="javascript:void(0)"><i class="fa fa-circle-o"></i> <span>User</span></a>
			    <ul class="nav treeview-menu">
			    	<li class="{{ Active::getClassIf(Active::checkAction(['App\Http\Controllers\Admin\UserController@index'])) }}"><a href="{{ URL::action('Admin\UserController@index') }}">User</a></li>
			        <li class="{{ Active::getClassIf(Active::checkAction(['App\Http\Controllers\Admin\UserController@create'])) }}"><a href="{{ URL::action('Admin\UserController@create') }}">Create New</a></li>
			    </ul>
			</li>
			@endcan
		</ul>
	</section>
</aside>
