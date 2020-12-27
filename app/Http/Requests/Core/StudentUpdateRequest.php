<?php

namespace App\Http\Requests\Core;

use Illuminate\Foundation\Http\FormRequest;

class StudentUpdateRequest extends FormRequest
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
            'email'     =>  'required|email|min:10|max:150|unique:users,email,'.$this->route('student'),
            'ci'        =>  'required|min:7|max:15|unique:information,ci,'.$this->route('student').',user_id',
            'rude'      =>  'required|min:7|max:20|unique:information,rude,'.$this->route('student').',user_id',
            'father_name'   =>  'max:150',
            'mother_name'   =>  'max:150',
            'phone'     =>  'max:30',
            'adress'    =>  'required|max:255',
            'birthday'  =>  'required',
            'site'      =>  'required|min:3|max:150',
            'gender'    =>  'required|in:M,F',
            'procedent' =>  'max:150',
            'father_occupation' =>  'max:100',
            'mother_occupation' =>  'max:100', 
            'father_email'      =>  'max:100',
            'mother_email'      =>  'max:100',
            'father_phone'      =>  'max:30',
            'mother_phone'      =>  'max:30',
            'tutor_phone'       =>  'max:30', 
            'tutor_email'       =>  'max:100',
            'size'              =>  'required',
            'medic'             =>  'required',
            'blood_type'        =>  'required'
        ];
    }
}
