<?php

namespace App\Http\Requests;

use App\Rules\UniqueCourseCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CourseFormRequest extends FormRequest
{

    /**
     * Modified constructor
     */
    //protected $user;
//
    //public function __construct($user)
    //{
    //    $this->user = $user;
    //}
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {   
        $user = Auth::user();
        return $user->is_teacher;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:3',
            'description' => 'required',
            'code' => new UniqueCourseCode,
            'credit' => 'required|numeric|min:0',
            'image_url' => 'nullable|url',
        ];
    }
}
