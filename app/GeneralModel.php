<?php
/**
 * Created by PhpStorm.
 * User: MyPC
 * Date: 6/17/2016
 * Time: 5:19 PM
 */

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait GeneralModel
{
    /**
     * Scope query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePrivate($query) {
        if (!auth()->check()) return $query->whereIn('status', [Apartment::VISIBILITY_PUBLIC, Apartment::VISIBILITY_HIDDEN]);
        return $query;
    }
    public function scopePublic($query) {
        return $query->where('status', Apartment::VISIBILITY_PUBLIC);
    }

    # Events
    protected static function boot() {
        parent::boot();
        static::addGlobalScope('public', function(Builder $builder) {
            if (!\App::runningInConsole() and \Route::current() != null && \Route::current()->getAction()['namespace'] === 'App\Http\Controllers')
                $builder->where('status', constant(static::class . "::VISIBILITY_PUBLIC"));
        });
        static::creating(function ($model) {
            $model->user_id = (auth()->check()) ? auth()->user()->id : NULL;
        });
    }

    # Relationships
    public function user() {
        return $this->belongsTo('App\User');
    }
    public function resource() {
        return $this->belongsTo('App\Resource');
    }

    # Mutators
    public function getFeatureImageAttribute() {
        if ($this->resource_id !== NULL) return $this->resource->thumbnail;
        return asset('images/300x300.png');
    }

    public function getPostThumbnailAttribute() {
        if ($this->resource_id !== NULL) return $this->resource->thumbnail;
        return asset('images/300x300.png');
    }

    public function getPostThumbnailIdAttribute() {
        return (string) $this->resource_id;
    }

    public function getCreatedAtAttribute($date) {
        return Carbon::parse($date)->format('d/m/Y');
    }

    public function getUpdatedAtAttribute($date) {
        return Carbon::parse($date)->format('d/m/Y');
    }

    public function getCustomCreatedAtAttribute() {
        return Carbon::parse($this->getOriginal('created_at'))->format('d M. Y');
    }

    public function getCustomUpdatedAtAttribute() {
        return Carbon::parse($this->getOriginal('updated_at'))->format('d M. Y');
    }

    public function getVisibilityAttribute() {
        switch ($this->status) {
            case self::VISIBILITY_PUBLIC:
                return '<label class="btn btn-xs btn-success">' . trans('admin.review.visible.public') . '</label>';
            case self::VISIBILITY_PRIVATE:
                return '<label class="btn btn-xs btn-warning">' . trans('admin.review.visible.private') . '</label>';
            case self::VISIBILITY_HIDDEN:
                return '<label class="btn btn-xs btn-danger">' . trans('admin.review.visible.hidden') . '</label>';
        }
    }
}
