<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use Cache;
use DB;

class Category extends Model
{
    use MultiLanguage, GeneralModel;

    const VISIBILITY_PUBLIC = 0;
    const VISIBILITY_PRIVATE = 1;
    const VISIBILITY_HIDDEN = 2;

    protected $fillable = ['permalink', 'status', 'sticky', 'resource_id', 'sql_data'];

    public $multilinguals = ['title', 'description', 'meta_keywords', 'meta_description', 'keywords'];

    protected $casts = ['sticky' => 'boolean', 'sql_data' => 'array'];

    public function results()
    {
        $values = (array)$this->sql_data;
        $terms = config('real-estate');
        $query = Estate::with('resources');
        if ($this->keywords !== '') {
            $query->whereHas('locales', function ($query) {
                $query->whereRaw("UPPER(title) LIKE UPPER('%" . $this->keywords . "%')");
            });
        }
        foreach ($values as $key => $value) {
            if ($key == "ids") {
                if (!empty($value)) {

                }
            }
            elseif(!empty($values['area'])){
                if ($key == "price") {
                    $price = explode("-", $value);
                    if (isset($price[0])) {
                        $query = $query->where("price", ">=", intval($price[0]));
                    }
                    if (isset($price[1])) {
                        $query = $query->where("price", "<=", intval($price[1]));
                    }
                }
                elseif ($terms[$key]['type'] === 'single') {
                    $query->whereIn($key, $value);
                }
                elseif ($terms[$key]['type'] === 'multiple') {
                    $query->whereRaw('MATCH(`' . $key . '`) AGAINST(\'' . implode(' ', $value) . '\' IN BOOLEAN MODE)');
                }
            }
        }

        $query->orWhere(function ($_query) use ($values, $terms) {

            foreach ($values as $key => $value) {
                if ($key == "ids") {
                    if (!empty($value)) {
                        $_query->whereIn("product_id", explode(",", $value));
                    }
                }
//            else if ($key == "price") {
//                $price = explode("-", $value);
//                if (isset($price[0])) {
//                    $_query = $_query->where("price", ">=", intval($price[0]));
//                }
//                if (isset($price[1])) {
//                    $_query = $_query->where("price", "<=", intval($price[1]));
//                }
//            }
            }

        });
        return $query;
    }

    /*public function getTermsAttribute() {
        if (!isset($this->attributes['sql_data']) || $this->attributes['sql_data'] == null) return [];
        return json_decode($this->attributes['sql_data'], true);
    }

    public function setTermsAttribute($value) {
        $this->attributes['sql_data'] = json_encode($value);
    }*/

    public function updateCategory($job, Category $category)
    {
        try {
            $estates = $category->results()->get();
            DB::table('category_estates')->where('category_id', $category->id)->delete();
            foreach ($estates as $estate) {
                DB::table('category_estates')->insert([
                    'estate_id' => $estate->id,
                    'category_id' => $category->id
                ]);
            }

        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage() . ' Line: ' . $e->getLine();
        }
    }
}
