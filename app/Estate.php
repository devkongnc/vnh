<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Estate extends Model
{
    use MultiLanguage, GeneralModel;

    const VISIBILITY_PUBLIC  = 0;
    const VISIBILITY_PRIVATE = 1;
    const VISIBILITY_HIDDEN  = 2;

    protected $fillable = [
        'slug_en',
        'slug_vi',
        'status',
        'product_id',
        'resource_id',
        'category_ids',
        'lat',
        'lng',
        'price',
        'deposit',
        'city',
        'area',
        'size',
        'time_to_super',
        'facilities',
        'inclusive',
        'surroundings',
        'address',
        'contract_limit',
        'floor',
        'conditioning_system',
        'anniversary',
        'commiss',
        'size_rangefor_search',
        'building_name',
        'user_id',
        ];

    public $multilinguals = ['title', 'description', 'meta_keywords', 'meta_description', 'meta_title'];

    protected $guarded  = ['id', 'title', 'description', 'images', 'user_id', 'g-recaptcha-response'];

    protected $casts    = ['price' => 'integer', 'size' => 'integer'];

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->multilinguals = ['title', 'description'];
    }

    public function updateEstate() {
        $categories = Category::all();
        foreach ($categories as $category) {
            $category->fireModelEvent('saved');
        }
    }

    # Relations
    public function resources() {
        return $this->belongsToMany('App\Resource')->orderBy('order', 'ASC')->orderBy('id', 'ASC');
    }
    
    public function categories() {
        return $this->belongsToMany('App\Category', 'category_estates');
    }
    public function sticky() {
        return $this->hasOne('App\EstateSticky');
    }

    # Mutators
    public function getPostThumbnailAttribute() {
        if ($this->resource_id !== NULL) return $this->resource->medium;
        return asset('images/300x200.png');
    }

    public function getPostThumbnail($size = 'medium') {
        if ($this->resource_id !== NULL) return $this->resource->{$size};
        return asset('images/300x200.png');
    }

    public function getIsStickyAttribute() {
        return !empty($this->sticky);
    }

    public function getAreaPermalinkAttribute() {
        if (array_key_exists($this->area_raw, config('override.district')))
            return action('CategoryController@show', config("override.district.$this->area_raw"));
        else return '#';
    }

    public function getUrlAttribute() {
        return action('RealEstateController@show', $this->product_id);
    }

    public function getAttribute($key) {
        if (ends_with($key, "_raw")) return parent::getAttribute(str_replace("_raw", "", $key));

        $value = parent::getAttribute($key);

        if (in_array($key, $this->multilinguals)) return $value;

        if (isset(config('real-estate')[$key])) {
            $term = config('real-estate')[$key];
            switch ($term['type']) {
                case 'text':
                    if (array_key_exists('unit', $term)) $value .= $term['unit'];
                    return $value;
                    break;
                case 'single':
                    if (isset($term['values'][$value])) return Term::getLocaleValue($term['values'][$value]);
                    else return '';
                    break;
                case 'multiple':
                    return (array) json_decode($value, true);
                    break;
                default:
                    break;
            }
        }

        /*if (is_string($value)) {
            $json = json_decode($value, true);
            if (is_array($json)) return $json;
        }

        if (isset(config("real-estate.{$key}.values")[$value])) {
            return Term::getLocaleValue(config("real-estate.{$key}.values.{$value}"));
        }*/

        return $value;
    }

    public function setCustomUpdatedAtAttribute($date) {
        $this->attributes['updated_at'] = \Carbon\Carbon::createFromFormat('d/m/Y', $date);
    }

    public function setAttribute($key, $value) {
        # Nếu set giá trị dạng array và không nằm trong mảng đa ngôn ngữ thì chuyển sang json
        if (is_array($value) && !in_array($key, $this->multilinguals)) {
            $value = json_encode($value);
        }
        return parent::setAttribute($key, $value);
    }
    
    # Mutators
    public function getLatAttribute($value) {
        return empty($value) ? '10.7883447' : $value;
    }
    public function getLngAttribute($value) {
        return empty($value) ? '106.6955799' : $value;
    }
    public function getAreaTextAttribute() {
        return getLocaleValue(config("real-estate.area.values.{$this->area}"));
    }

}
