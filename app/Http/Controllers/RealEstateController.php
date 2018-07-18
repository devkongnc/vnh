<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Estate;
use App\Resource;
use App\TermRepository;
use Carbon\Carbon;
use DB;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use LaravelLocalization;
use Mail;
use Validator;

class RealEstateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $estates = Estate::with('resource')->whereIn('product_id', (array) $request->ids)->get();
            $response = [];
            foreach ($estates as $estate) {
                $response[] = [
                    'id'             => $estate->id,
                    'title'          => $estate->title,
                    'product_id'     => $estate->product_id,
                    'price'          => $estate->price,
                    'price_max'      => $estate->price_max,
                    'post_thumbnail' => $estate->post_thumbnail,

                ];
            }
            return response()->json($response);
        }
        return $this->arrival($request);
        //return redirect()->action('RealEstateController@arrival');
    }

    public function arrival(Request $request) {
        # BDS tạo hôm nay
        $today_estates = Estate::whereDate('updated_at', '=', Carbon::today())->orderBy('id', 'desc');
        $today_estates = ($request->has('page') and (int) $request->page >= 2) ? $today_estates->get() : $today_estates->with('resources')->get();
        $query = Estate::with('resources')->whereBetween('created_at', [Carbon::now()->subDays(7)->format('Y-m-d'), Carbon::now()->format('Y-m-d')])->whereNotIn('id', $today_estates->pluck('id')->all());
        # Order kết quả
        $order = $request->get('order', session('search_order', 'id-desc'));
        session(['search_order' => $order]);
        $orderExploded = explode("-", $order);
        # Giới hạn thuộc tính sắp xếp
        if (in_array($orderExploded[0], config('override.order field'))) $query = $query->orderBy($orderExploded[0], $orderExploded[1]);
        else $query = $query->orderBy('id', 'desc');
        # Phân trang
        $estates = $query->paginate(20);
        \SEO::setTitle(trans('menu.arrival'));
        return view('estate.arrival', compact('today_estates', 'estates', 'order'));
    }

    /**
     * Display the specified resource.
     *
     * @param Estate $estate
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $product_id)
    {
        $estate      = Estate::withoutGlobalScopes()->private()->with('resource', 'resources', 'categories')->where('product_id', $product_id)->firstOrFail();
        $terms       = $this->_prepareTerms();
        # Same Apartment
        $siblings    = NULL;
        # Recent Estate Parse from Session
        $recent_ids = $request->session()->get('recent_estates', function() { return []; });
        $recents    = NULL;
        if (!empty($recent_ids)) $recents = Estate::with('resource')->whereIn('product_id', $recent_ids)->get();
        # Push current estate to recent list
        array_unshift($recent_ids, $estate->product_id);
        $request->session()->put('recent_estates', $recent_ids);
        # Relative Estates
        /**
        Giá chênh lệch + - 20% (VD: 1000$ => 800$, 1200$)
        Cùng loại BDS (Cùng loại villa hay apartment)
        Cùng quận
        Có số phòng ngủ >=1 so với hiện tại (Vd BDS hiện tại có 1 phòng ngủ thì các bds liên quan sẽ có 1 hoặc 2 phòng)
         */
        $relatives   = Estate::with('resource')->whereBetween('price', [(int) $estate->price * 0.8, (int) $estate->price * 1.2])->where([
            'area' => $estate->area_raw,
        ])->take(24)->get();
        \SEO::setTitle($estate->title)->setDescription(\Illuminate\Support\Str::words($estate->description, 10));
        \SEO::opengraph()->setUrl($request->fullUrl())->addImage($estate->resource_id ? $estate->resource->url : NULL);
        \SEO::twitter()->setUrl($request->fullUrl())->addImage($estate->resource_id ? $estate->resource->url : NULL);
        return response()->view('estate.show', array_merge(compact('estate', 'siblings', 'recents', 'relatives'), $terms));
    }

    public function showAmp(Request $request, $product_id) {
        $estate = Estate::withoutGlobalScopes()->private()->with('resource', 'resources', 'categories')->where('product_id', $product_id)->firstOrFail();
        $terms       = $this->_prepareTerms();
        # Same Apartment
        $siblings    = NULL;
        # Recent Estate Parse from Session
        $recent_ids = $request->session()->get('recent_estates', function() { return []; });
        $recents    = NULL;
        if (!empty($recent_ids)) $recents = Estate::with('resource')->whereIn('product_id', $recent_ids)->get();
        # Push current estate to recent list
        array_unshift($recent_ids, $estate->product_id);
        $request->session()->put('recent_estates', $recent_ids);
        # Relative Estates
        /**
        Giá chênh lệch + - 20% (VD: 1000$ => 800$, 1200$)
        Cùng loại BDS (Cùng loại villa hay apartment)
        Cùng quận
        Có số phòng ngủ >=1 so với hiện tại (Vd BDS hiện tại có 1 phòng ngủ thì các bds liên quan sẽ có 1 hoặc 2 phòng)
         */
        $relatives   = Estate::with('resource')->whereBetween('price', [(int) $estate->price * 0.8, (int) $estate->price * 1.2])->where([
            'area' => $estate->area_raw,
        ])->take(24)->get();
        \SEO::setTitle($estate->title)->setDescription(\Illuminate\Support\Str::words($estate->description, 10));
        \SEO::opengraph()->setUrl($request->fullUrl())->addImage($estate->resource_id ? $estate->resource->url : NULL);
        \SEO::twitter()->setUrl($request->fullUrl())->addImage($estate->resource_id ? $estate->resource->url : NULL);
        return response()->view('estate.show-amp', array_merge(compact('estate', 'siblings', 'recents', 'relatives'), $terms));
    }

    public function landlord(Request $request) {
        # Validate
        $validator = Validator::make($request->all(), [
            'info.name'  => 'required|min:1|max:255',
            'info.phone' => 'required|min:8|max:15|regex:/^\+?[0-9\s]+$/',
            'info.email' => 'required|email',
            'info.address' => 'required|min:10',
            'term.price' => 'required|integer|min:10',
            'term.size'  => 'required|integer|min:1',
            'g-recaptcha-response' => 'required',
        ]);
        if ($validator->fails()) return back()->withInput()->withErrors($validator);
        # Verify ReCaptcha
        $recaptcha = new \ReCaptcha\ReCaptcha(config('services.recaptcha.secret'));
        $resp = $recaptcha->verify($request->get('g-recaptcha-response'), $_SERVER['REMOTE_ADDR']);
        if (!$resp->isSuccess()) return back()->withInput()->withErrors([trans('validation.captcha')]);

        $product_id = (int) Estate::withoutGlobalScopes()->max('product_id') + 1;

        DB::beginTransaction();
        try {
            # Save Resources
            $files = $request->files->get('resources');
            $dir = "owner/" . $product_id . '/';
            $resources = [];
            foreach ($files as $index => $file) {
                if ($file === null) continue;
                $name = $file->getClientOriginalName() . '_' .  date('d-m-Y-H-i-s') . '.' . $file->guessClientExtension();
                $name = preg_replace('/([^\w0-9\-.])/', '', $name); # Chỉ cho phép chữ, số, dấu chấm, dấu - trong tên
                $file->move(public_path('upload/' . $dir), $name);
                $resource = Resource::create([
                    'folder'   => $dir,
                    'filename' => $name,
                    'size'     => $file->getClientSize()
                ]);
                $resources[] = $resource->id;
            }
            # Tạo mới estate hidden
            $data = array_merge($request->term, [
                'status'      => Estate::VISIBILITY_HIDDEN,
                'product_id'  => $product_id,
                'resource_id' => !empty($resources) ? $resources[0] : NULL
            ]);
            $new_estate = Estate::create($data);
            $new_estate->resources()->sync($resources);
            # Gửi contact
            $user_info            = $request->info;
            $user_info['message'] = $request->has('description') ? $request->description[LaravelLocalization::getCurrentLocale()]: '';
            $term = $request->term;
            unset($term["price"]);
            Mail::send('email.owner-vnh', ['data' => $user_info, 'estate' => $new_estate, 'terms' => $term, 'config' => config('real-estate')], function ($m) use ($user_info) {
                $m->from(config('mail.from.address'), config('mail.from.name'));
                $m->to(config('mail.destination.landlord'))->subject(trans('email.title4', [ 'name' => $user_info['name'] ]));
            });
            Mail::send('email.owner-cus', ['data' => $user_info, 'estate' => $new_estate, 'terms' => $term, 'config' => config('real-estate')], function ($m) use ($user_info) {
                $m->from(config('mail.from.address'), config('mail.from.name'));
                $m->to($user_info['email'])->subject(trans('email.title3', [ 'name' => $user_info['name'] ]));
            });

            Contact::create($user_info);
            DB::commit();
            return back()->withFlashData(['status' => 'success', 'message' => trans('admin.message.success.create')]);
        } catch (\Exception $ex) {
            DB::rollBack();
            # Xóa ảnh nếu fail
            File::deleteDirectory(public_path('upload/' . $dir));
            return back()->withInput()->withFlashData(['status' => 'error', 'message' => $ex->getMessage()]);
        }
    }

    private function _prepareTerms(){
        $store = new TermRepository([]);
        $term_collection = new Collection($store->currentData);
        $above = $term_collection->filter(function($item, $key){
            return $item['type'] != 'multiple' and !in_array($key, ['price', 'deposit', 'size_rangefor_search']);
        });
        $below = $term_collection->filter(function($item){
            return $item['type'] == 'multiple';
        });
        $first = $below->pull('inclusive');
        $first['key'] = 'inclusive';
        return compact('below', 'above', 'first');
    }

}
