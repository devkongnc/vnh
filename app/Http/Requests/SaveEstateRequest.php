<?php

namespace App\Http\Requests;

class SaveEstateRequest extends Request
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
            'product_id'   => 'required|integer|min:10000|unique:estates,product_id' . (($this->method() === 'PUT') ? ',' . $this->route()->parameter('real_estate') : ''),
            'status'       => 'required|in:0,1,2',
            'lat'          => 'numeric|min:0',
            'lng'          => 'numeric|min:0',
            'price'        => 'numeric|min:0',
            'size'         => 'integer|min:0',
            'resource_id'  => 'integer'
        ];
    }

    public function all() {

        $attributes = parent::all();

        $terms = config('real-estate');
        foreach ($terms as $key => $term) {
            if ($term['type'] == 'multiple') {
                if (!isset($attributes[$key])) {
                    $attributes[$key] = [];
                }
            }
        }

        if (!isset($attributes['category_ids'])){
            $attributes['category_ids'] = null;
        }

        $attributes['term']['size'] = preg_replace('/\D/', '', $attributes['term']['size']);
        $attributes['resource_id']  = isset($attributes['images']) ? (int) $attributes['images'][0] : NULL;
        $attributes['sticky']       = isset($attributes['sticky']) ? (boolean) $attributes['sticky'] : false;

        return $attributes;

    }
}
