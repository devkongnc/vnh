<?php
namespace App\Http\Controllers;

use App\Apartment;
use App\Category;
use App\Contact;
use App\Estate;
use App\Page;
use App\Review;
use App\TermRepository;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use LaravelLocalization;
use Validator;

class HomeController extends Controller {
	public function home() {
		$data = Cache::remember('view.home', 720, function() {
			$data['offices'] = 	Estate::with('resource')
						->where('type', 13)
						->where('status', 0)
						->take(9)
						->get();
			$data['stickies'] = Estate::with('resource')->has('sticky')->get();
			return $data;
		});
		$data['reviews'] = Review::with('resource')->orderBy('id', 'desc')->take(7)->get();
		$data['categories'] = Category::orderBy('sticky', 'desc')->orderBy('id', 'desc')->take(4)->get();
		$data['apartments'] = Apartment::with('resource')->orderBy('sticky', 'desc')->orderBy('id', 'desc')->take(3)->get();
		$data['pages_home'] = [7, 2, 5, 6, 4, 12];

		return view('home', $data);
	}

	public function searchForm() {
		$categories = Category::orderBy('id', 'desc')->paginate(20);
		return view('estate.search', compact('categories'));
	}

	public function search(Request $request) {
		# Loại bỏ term rỗng
		$terms = array_filter((array) $request->term, function($item){
            return $item !== '';
        });

        $store = new TermRepository([]);
        $term_collection = new Collection($store->currentData);
        $above = $term_collection->filter(function($item, $key){
            return $item['type'] === 'single';
        })->keys()->all();
        $below = $term_collection->filter(function($item){
            return $item['type'] === 'multiple';
        })->keys()->all();

		# Query tìm kiếm estate
		$query = Estate::query();
		foreach ($terms as $key => $value) {
		    if ($key === 'price') {
				$prices = explode(',', $value);
				if (count($prices) !== 2) {
					unset($terms[$key]);
					continue;
				}
				if ($prices[1] === 'max') $query = $query->where($key, '>=', (int) $prices[0]);
				else $query = $query->whereBetween($key, array_map('intval', $prices));
			}elseif ($key === 'size') {
				$sizes = explode(',', $value);
				if (count($sizes) !== 2) {
					unset($terms[$key]);
					continue;
				}
				if ($sizes[1] === 'max') $query = $query->where($key, '>=', (int) $sizes[0]);
				else $query = $query->whereBetween($key, array_map('intval', $sizes));
			} elseif (is_array($value) and in_array($key, $above)) {
				$query = $query->whereIn($key, $value);
			} elseif (is_array($value) and in_array($key, $below)) {
				$query->whereRaw('MATCH(`' . $key . '`) AGAINST(\'' . implode(' ', array_map(function($val) { return '+' . $val; } , $value)) . '\' IN BOOLEAN MODE)');
			}
		}

		if ($request->ajax()) return $query->count();

		$query = $query->with('resources');

		# Order kết quả
		$order = htmlspecialchars(strip_tags(trim($request->get('order', session('search_order', 'id-desc')))));
		session(['search_order' => $order]);
		$orderExploded = explode("-", $order);
		# Giới hạn thuộc tính sắp xếp
		if (in_array($orderExploded[0], config('override.order field'))) $query = $query->orderBy($orderExploded[0], $orderExploded[1]);
		else $query = $query->orderBy('id', 'desc');
		# Phân trang
		$search_estates = $query->paginate(20, ['*'], 'list')->appends($request->except('list'));
		$apartments = Apartment::withoutGlobalScopes()->public()->get();

		return view('estate.result', compact('search_estates', 'terms', 'order', 'apartments'));
	}

	// add search maps function
	public function search_map(Request $request) {
		# Loại bỏ term rỗng
		$terms = array_filter((array) $request->term, function($item){
            return $item !== '';
        });

        // $store = new TermRepository([]);
        // $term_collection = new Collection($store->currentData);
        // $above = $term_collection->filter(function($item, $key){
        //     return $item['type'] === 'single';
        // })->keys()->all();
        // $below = $term_collection->filter(function($item){
        //     return $item['type'] === 'multiple';
        // })->keys()->all();

		# Query tìm kiếm estate
		$query = Estate::query();
		foreach ($terms as $key => $value) {
		    if ($key === 'price') {
				$prices = explode(',', $value);
				if (count($prices) !== 2) {
					unset($terms[$key]);
					continue;
				}
				if ($prices[1] === 'max') $query = $query->where($key, '>=', (int) $prices[0]);
				else $query = $query->whereBetween($key, array_map('intval', $prices));
			}elseif ($key === 'size') {
				$sizes = explode(',', $value);
				if (count($sizes) !== 2) {
					unset($terms[$key]);
					continue;
				}
				if ($sizes[1] === 'max') $query = $query->where($key, '>=', (int) $sizes[0]);
				else $query = $query->whereBetween($key, array_map('intval', $sizes));
			}
		}
		if ($request->ne_lat != '' && $request->ne_lng != '' && $request->sw_lat != '' && $request->sw_lng != '') {
			$ne_lats = floatval($request->ne_lat);
			$ne_lngs = floatval($request->ne_lng);
			$sw_lats = floatval($request->sw_lat);
			$sw_lngs = floatval($request->sw_lng);
			$query = $query->whereRaw("CAST(lat AS DOUBLE) between $sw_lats and $ne_lats and CAST(lng AS DOUBLE) between $sw_lngs and $ne_lngs");
		}

		$query = $query->with('resources');

		# Order kết quả
		// $order = htmlspecialchars(strip_tags(trim($request->get('order', session('search_order', 'id-desc')))));
		// session(['search_order' => $order]);
		// $orderExploded = explode("-", $order);
		// # Giới hạn thuộc tính sắp xếp
		// if (in_array($orderExploded[0], config('override.order field'))) $query = $query->orderBy($orderExploded[0], $orderExploded[1]);
		// else $query = $query->orderBy('id', 'desc');
		# Phân trang
		$search_estates = $query->paginate(20, ['*'], 'list')->appends($request->except('list'));
		// $apartments = Apartment::withoutGlobalScopes()->public()->get();
		// $query = $query->toSql();
		// return $query;
		return view('partials.three-grid-map', ['items' => $search_estates]);
		// return view('estate.result', compact('search_estates', 'terms', 'order', 'apartments'));
	}

	public function contact(Request $request) {
		# Validate
		$validator = Validator::make($request->all(), [
			'name'                 => 'required|max:255',
			'phone'                => 'required|min:8|max:15|regex:/^\+?[0-9\s]+$/',
			'email'                => 'required|email|max:255',
			'message'              => 'required|max:500',
			'g-recaptcha-response' => 'required',
			'estates'              => 'array'
	    ]);
	    if ($validator->fails()) return response()->json(['status' => 'error-validate', 'message' => $validator->errors()]);
	    # Verify ReCaptcha
	    $recaptcha = new \ReCaptcha\ReCaptcha(config('services.recaptcha.secret'));
		$resp = $recaptcha->verify($request->get('g-recaptcha-response'), $_SERVER['REMOTE_ADDR']);
		if (!$resp->isSuccess()) return response()->json(['status' => 'error-validate', 'message' => [trans('validation.captcha')]]);

	    $request->merge(['message' => htmlentities(strip_tags(trim($request->message)))]);
	    $estates = [];
	    if (!empty($request->estates)) $estates = Estate::whereIn('id', $request->estates)->get(['id', 'product_id']);
	    //try {
	    	/*$contact_name = $request->name;
	    	$contact_phone = $request->phone;
	    	\Mail::queue('auth.emails.contact', ['data' => $request->all()], function ($m) use ($contact_name, $contact_phone) {
	            $m->from(config('mail.from.address'), config('mail.from.name'));
	            $m->to(config('mail.destination'))->subject("Contact: {$contact_name} - {$contact_phone}");
	        });*/
	        \Mail::send('email.contact-vnh', ['data' => $request->all(), 'estates' => $estates], function ($m) use ($request) {
			    $m->from(config('mail.from.address'), config('mail.from.name'));
	            $m->to(config('mail.destination.' . LaravelLocalization::getCurrentLocale()))->subject(trans(empty($request->estates) ? 'email.title1' : 'email.title2', ['name' => $request->name]));
			});
			\Mail::send('email.contact-cus', ['data' => $request->all(), 'estates' => $estates], function ($m) use ($request) {
			    $m->from(config('mail.from.address'), config('mail.from.name'));
	            $m->to($request->email)->subject(trans('email.title3', ['name' => $request->name]));
			});
	        Contact::create($request->all());
	        return response()->json(['status' => 'success', 'popup' => view('partials.popup_thankyou')->render()]);
	    /*} catch (\Exception $ex) {
	    	return response()->json(['status' => 'error-mail', 'message' => $ex->getMessage()]);
	    }*/
	}

	public function about(Request $request, $permalink = '') {
		$route_prefix = explode('/', \Route::current()->getPrefix());
		$route_prefix = end($route_prefix);
		$page = Cache::remember("page.$route_prefix.$permalink", 720, function() use($route_prefix, $permalink) {
		    return Page::withoutGlobalScopes()->private()->where('permalink', $route_prefix . (($permalink == '') ? '' : '/' . $permalink))->firstOrFail();
		});
		\SEO::setTitle($page->title);
        \SEO::opengraph()->setUrl($request->fullUrl());
        if ($permalink === 'contact') {
        	return view('about.contact', compact('page'))->with('isForm', true);
        } elseif ($permalink === 'landlord') {
			$store      = new TermRepository([]);
			$terms_form = new Collection($store->currentData);
            return view('about.owner', compact('page', 'terms_form'))->with('isForm', true);
        } else {
        	return view('about.base', compact('page'));
        }
	}

	public function desktop(Request $request) {
		if ($request->action === 'desktop')	return back()->cookie('vnh_desktop', 'width=1280', 1440);
		else if ($request->action === 'normal')	return back()->withCookie(\Cookie::forget('vnh_desktop'));
	}

	public function clearCache() {
		Cache::forget('view.home');
		Cache::forget('new_arrival');
		Cache::forget('total_estate');
		Cache::forget('apartments_select');
		Cache::forget('static_pages');
		return back();
	}

	public function sitemap($model) {
		$type = $model;
		$model = '\\App\\' . ucfirst($model);
		$models = $model::orderBy('id', 'desc')->get();
		return response()->view('sitemap.show', [
				'models' => $models,
				'type' => $type
			])->header('Content-Type', 'text/xml');
	}


}