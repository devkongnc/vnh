<?php

namespace App\Http\Requests;

class SaveApartmentRequest extends Request
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
            'permalink' => 'required|regex:/^[\w\-]+[a-zA-Z\d]$/|unique:apartments,permalink' . (($this->method() === 'PUT') ? ',' . $this->route()->parameter('apartment') : ''),
            'status'    => 'required|in:0,1,2',
            'area'      => 'integer',
            'recommend' => 'integer|min:0|max:99',
            'lat'       => 'numeric|min:0',
            'lng'       => 'numeric|min:0',
            'images'    => 'array'
        ];
    }

    public function all() {

        $attributes = parent::all();

        $attributes['resource_id'] = isset($attributes['images']) ? (int) $attributes['images'][0] : NULL;
        $attributes['sticky']      = isset($attributes['sticky']) ? (boolean) $attributes['sticky'] : false;

        return $attributes;

    }
}
