<?php

namespace App\Http\Requests;
use App\Review;

class ReviewModelRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //TODO: Kiểm tra quyền
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
                    'title'       => 'required',
                    'description' => 'required',
                    'categories'  => 'required',
                    'status'      => 'required',
                    'timestamp'   => 'required',
                    'permalink'   => 'required|regex:/^[\w\-]+[a-zA-Z\d]$/|unique:reviews,permalink'
                ];
            case 'PUT':
                // Get Current Review requesting
                $review = $this->route()->parameter('review');
                return [
                    'title'       => 'required',
                    'description' => 'required',
                    'categories'  => 'required',
                    'status'      => 'required',
                    'timestamp'   => 'required',
                    'permalink'   => 'required|regex:/^[\w\-]+[a-zA-Z\d]$/'
                ];
        }
    }

    public function all()
    {
        $all = parent::all();
        if (empty($all['resource_id'])) unset($all['resource_id']);
        $all['categories']   = isset($all['categories']) ? array_map('intval', $all['categories']) : [0];
        $all['locales_only'] = isset($all['locales_only']) ? array_map('intval', $all['locales_only']) : [Review::ja_only, Review::en_only, Review::vi_only];
        return $all;
    }
}
