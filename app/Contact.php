<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['name', 'phone', 'email', 'message', 'estates', 'unread'];

    protected $casts = [
		'estates' => 'array',
		'unread'  => 'boolean'
    ];

    public function getStatusAttribute() {
    	if ((boolean) $this->unread === true) return '<label class="btn btn-xs btn-danger">' . trans('admin.contact.unread') . '</label>';
    	else return '<label class="btn btn-xs btn-success">' . trans('admin.contact.read') . '</label>';
    }

    public function setEstatesAttribute($value) {
        $this->attributes['estates'] = json_encode($value, JSON_FORCE_OBJECT);
    }
}
