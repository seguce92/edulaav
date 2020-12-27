<?php

namespace App\Http\Requests\Core;

use Illuminate\Foundation\Http\FormRequest;

class TeacherUpdateRequest extends FormRequest
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
            'name'  =>  'required|min:3|max:255',
            'lastname'  =>  'max:255',
            'email'     =>  'required|email|min:10|max:150|unique:users,email,'.$this->route('teacher'),
            'ci'        =>  'required|min:7|max:15|unique:information,ci,'.$this->route('teacher').',user_id',
            'birthday'  =>  'required'
        ];
    }
}
