<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SaveUserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required|min:3|max:255',
            'email'       => 'required|email|max:255' . (($this->method() === 'POST') ? '|unique:users' : ''),
            'password'    => (($this->method() === 'POST') ? 'required|' : '') . 'confirmed|min:6',
            'profile'     => 'min:6,max:500',
            'resource_id' => 'integer|exists:resources,id',
            'level'       => 'in:0,1,2'
        ];
    }

    public function all() {
        $attributes = parent::all();
        if (empty($attributes['resource_id'])) $attributes['resource_id'] = null;
        if (empty($attributes['password'])) {
            unset($attributes['password']);
            unset($attributes['password_confirmation']);
        }
        return $attributes;
    }
}
