<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class VideoRequest extends Request
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
        $rules = [
            'title' => 'required|min:5|max:100',
            'category_id' => 'required',
            'video_link' => 'required',
            'tags' => 'required',
            'content' => 'required|min:250'
        ];
        return $rules;
    }
}
