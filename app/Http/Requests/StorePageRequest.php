<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

use Purifier;

class StorePageRequest extends Request
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
            'permalink' => 'required|regex:/^[\w\-\/]+[a-zA-Z\d]$/|unique:pages,permalink' . (($this->method() === 'PUT') ? ',' . $this->route()->parameter('static_page') : ''),
            'status'    => 'required|in:0,1,2',
        ];
    }
}
