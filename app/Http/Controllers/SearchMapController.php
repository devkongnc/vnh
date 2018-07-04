<?php
namespace App\Http\Controllers;

use App\Estate;
use App\TermRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SearchMapController extends Controller {

    private $terms;
	// add search maps function
	public function search(Request $request) {
        $query = $this->retrieve_data_map($request, 'view');
        $search_estates = $query->paginate(20, ['*'], 'list')->appends($request->except('list'));
        $push_maps = $search_estates;
        $terms= $this->terms;
		return view('estate.search-map', compact('search_estates','terms', 'push_maps'));
	}

//    public function search_map_ajax(Request $request) {
//        $search_estates = $this->retrieve_data_map($request, 'ajax');
//        return $search_estates;
//    }

    public function retrieve_data_map($request, $type = 'view') {
        # Loại bỏ term rỗng
        $this->terms = array_filter((array) $request->term, function($item){
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
        foreach ($this->terms as $key => $value) {
            if ($key === 'price') {
                $prices = explode(',', $value);
                if (count($prices) !== 2) {
                    unset($this->terms[$key]);
                    continue;
                }
                if ($prices[1] === 'max') $query = $query->where($key, '>=', (int) $prices[0]);
                else $query = $query->whereBetween($key, array_map('intval', $prices));
            }elseif ($key === 'size') {
                $sizes = explode(',', $value);
                if (count($sizes) !== 2) {
                    unset($this->terms[$key]);
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

        if ($type == 'view') {
            return $query;
        } elseif ($type == 'ajax') {
            return $query->get();
        }
        return $query->get();
    }

}
