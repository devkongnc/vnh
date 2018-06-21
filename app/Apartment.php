<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use MultiLanguage, GeneralModel;

    const VISIBILITY_PUBLIC  = 0;
    const VISIBILITY_PRIVATE = 1;
    const VISIBILITY_HIDDEN  = 2;
    const VISIBILITY_OWNER = 3;

    protected $fillable   = ['product_id', 'permalink', 'status', 'recommend', 'resource_id', 'sticky', 'lat', 'lng', 'area'];

    public $multilinguals = ['title', 'description', 'meta_keywords', 'meta_description', 'meta_title'];

    protected $casts      = ['sticky' => 'boolean'];

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->multilinguals = array_merge($this->multilinguals, array_keys(config('apartment')));
    }

    /* Relationships */
    public function resources() {
        return $this->belongsToMany('App\Resource')->orderBy('order', 'ASC')->orderBy('id', 'ASC');
    }
    public function estates() {
        return $this->hasMany('App\Estate', 'apartment_id');
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
    public function getUrlAttribute() {
        return action('ApartmentController@show', $this->permalink);
    }
}
