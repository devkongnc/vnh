<?php
namespace App\Http\Controllers;

use App\Estate;
use App\TermRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SearchMapController extends Controller {

    private $terms;
    private $limit = 10;

	// add search maps function
	public function search(Request $request) {
	    $data_request = $request->all();
        $query = $this->retrieve_data_map($request);
        $search_estates = $query->paginate($this->limit, ['*'], 'list')->appends($request->except('list'));
        $push_maps = $search_estates;
        $terms= $this->terms;
		return view('estate.search-map', compact('search_estates','terms', 'push_maps', 'data_request'));
	}

    public function data_map_ajax(Request $request) {
        $search_estates = array();
        $search_estates = $this->retrieve_data_map($request);
        $search_estates = $search_estates->paginate($this->limit, ['*'], 'list')->appends($request->except('list'));
        return view('partials.three-grid-map', ['items'=>$search_estates]);
    }

    public function retrieve_data_map($request) {
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

        if ($request->ne_lat != '' && $request->ne_lng != '' && $request->sw_lat != '' && $request->sw_lng != '' ) {
            $ne_lats = floatval($request->ne_lat);
            $ne_lngs = floatval($request->ne_lng);
            $sw_lats = floatval($request->sw_lat);
            $sw_lngs = floatval($request->sw_lng);
            $query = $query->whereRaw("CAST(lat AS DECIMAL(17,15)) between $sw_lats and $ne_lats and CAST(lng AS DECIMAL(18,15)) between $sw_lngs and $ne_lngs");
        }

        $query = $query->with('resources');

        return $query->orderBy('updated_at','desc');
    }

}
