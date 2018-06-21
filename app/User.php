<?php

namespace App;

use Cache;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    const USER_NORMAL = 0;
    const USER_CONTENT = 1;
    const USER_ADMIN = 2;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'profile', 'resource_id', 'phone', 'level'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected static function boot() {
        self::updated(function ($user) {
            Cache::forget("user_{$user->id}.userById");
            Cache::forget("user_{$user->id}.userByIdAndToken");
        });
    }

    public function can_edit() {
        return $this->level >= self::USER_CONTENT;
    }

    /* Relationships */
    public function resource() {
        return $this->belongsTo('App\Resource', 'resource_id');
    }

    /* Mutators */
    public function getIsAdminAttribute() {
        return $this->level == self::USER_ADMIN;
    }
    public function getAvatarImageAttribute() {
        if ($this->resource_id == null) {
            return "http://placehold.it/100x100";
        }
        return $this->resource->url;
    }
    public function getPostThumbnailIdAttribute() {
        return (string) $this->avatar;
    }
    public function getPostThumbnailAttribute() {
        if ($this->resource_id === null) return 'http://placehold.it/300x300';
        return $this->resource->thumbnail;
    }
}
