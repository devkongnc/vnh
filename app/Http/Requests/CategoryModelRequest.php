<?php

namespace App\Http\Requests;

class CategoryModelRequest extends Request
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
        switch ($this->method()) {
            case 'POST':
                return [
                    'status'      => 'required|in:0,1,2',
                    'permalink'   => 'required|regex:/^[\w\-]+[a-zA-Z\d]$/|unique:categories,permalink',
                    'resource_id' => 'integer',
                    'sql_data'    => 'array',
                ];
            case 'PUT':
                // Get Current Review requesting
                $id = $this->route()->parameter('category');
                return [
                    'status'      => 'required|in:0,1,2',
                    'permalink'   => 'required|regex:/^[\w\-]+[a-zA-Z\d]$/|unique:categories,permalink,' . $id,
                    'resource_id' => 'integer',
                    'sql_data'    => 'array',
                ];
        }
    }

    public function all() {
        $attributes = parent::all();
        if (empty($attributes['resource_id'])) $attributes['resource_id'] = null;
        if (!isset($attributes['sql_data'])) $attributes['sql_data'] = [];
        $attributes['sticky'] = array_key_exists('sticky', $attributes) ? (boolean) $attributes['sticky'] : false;
        return $attributes;
    }
}
