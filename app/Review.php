<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use LaravelLocalization;


class Review extends Model
{
    use MultiLanguage, GeneralModel;

    const VISIBILITY_PUBLIC  = 0;
    const VISIBILITY_PRIVATE = 1;
    const VISIBILITY_HIDDEN  = 2;

    const SAVE_REVIEW        = 'save';
    const PUBLISH_REVIEW     = 'publish';

    const ja_only            = 0;
    const en_only            = 1;
    const vi_only            = 2;

    protected $guarded       = ['id'];

    public $dates            = ['timestamp'];

    public $fillable         = ['permalink', 'draft', 'status', 'timestamp', 'categories', 'locales_only', 'resource_id'];

    public $multilinguals    = ['title', 'description'];

    protected $casts         = ['draft' => 'boolean', 'categories' => 'array', 'locales_only' => 'array'];

    public function scopePrivate($query) {
        if (!auth()->check()) return $query->where('draft', false)->whereIn('status', [Estate::VISIBILITY_PUBLIC, Estate::VISIBILITY_PRIVATE]);
        return $query;
    }

    # Events
    protected static function boot() {
        parent::boot();
        static::addGlobalScope('public', function(Builder $builder) {
            if (\Route::current()->getAction()['namespace'] === 'App\Http\Controllers')
                $builder->where('draft', false)->where('status', Review::VISIBILITY_PUBLIC)->where('locales_only', 'LIKE', '%' . constant('App\Review::' . LaravelLocalization::getCurrentLocale() . '_only') . '%');
        });
        static::creating(function ($model) {
            $model->user_id = (auth()->check()) ? auth()->user()->id : NULL;
        });
    }

    # Mutators
    public function getCategoryAttribute() {
        return $this->categories[0];
    }
    public function getCategorySlugAttribute() {
        return config('override.category.' . $this->category);
    }
    public function getUrlAttribute() {
        return action('ReviewController@show', [$this->category_slug, $this->permalink]);
    }
    public function getCategoriesNameAttribute() {
        if (!isset($this->attributes['categories'])) return [];
        $result = [];
        foreach ($this->categories as $category) {
            $result[] = trans('admin.review.categories.' . $category);
        }
        return $result;
    }
    /*public function setCategoriesAttribute($value) {
        $this->attributes['categories'] = json_encode(array_map('intval', $value));
    }*/
    public function setTimeStampAttribute($value) {
        $this->attributes['timestamp'] = Carbon::createFromFormat('d/m/Y', $value);
    }
    public function getTimeStampAttribute(){
        if (isset($this->attributes['timestamp']) && $this->attributes['timestamp'] != null) {
            return Carbon::createFromTimestamp(strtotime($this->attributes['timestamp']))->format('d/m/Y');
        }
        return Carbon::now()->format('d/m/Y');
    }
    public function getTimeStampDotAttribute() {
        if (isset($this->attributes['timestamp']) && $this->attributes['timestamp'] != null) {
            return Carbon::createFromTimestamp(strtotime($this->attributes['timestamp']))->format('d M. Y');
        }
        return Carbon::now()->format('d M. Y');
    }
    /*public function getFullPermalinkAttribute() {
        if (!isset($this->attributes['permalink'])) return '';
        return \URL::action('ReviewController@show', $this->attributes['permalink']);
    }*/
    public function getIconsAttribute() {
        $categories = $this->categories;
        $icons = "";
        foreach ($categories as $category) {
            switch ($category) {
                case 4:
                    $icons .= '<i class="icon-lamp" aria-hidden="true"></i>';
                    break;
                case 1:
                    $icons .= '<i class="icon-star" aria-hidden="true"></i>';
                    break;
                case 2:
                    $icons .= '<i class="icon-cart" aria-hidden="true"></i>';
                    break;
                case 3:
                    $icons .= '<i class="icon-cake" aria-hidden="true"></i>';
                    break;
                case 5:
                    $icons .= '<i class="icon-bookmark" aria-hidden="true"></i>';
                    break;
                case 0:
                    $icons .= '<i class="icon-paper-plane" aria-hidden="true"></i>';
                    break;
            }
        }
        return $icons;
    }

}
