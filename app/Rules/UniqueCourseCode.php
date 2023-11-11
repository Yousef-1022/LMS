<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Course;
use Illuminate\Support\Facades\Validator;

class UniqueCourseCode implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $validator = Validator::make([$attribute => $value], [
            $attribute => ['required', 'regex:/^IK-[A-Z]{3}\d{3}$/'],
        ]);

        if ($validator->fails()) {
            $fail("Please choose a valid code (IK-SSSNNN)! eg. IK-WEB420");
        }

        $courses = Course::all();
        foreach ($courses as $course) {
            if ($course->code === $value) {
                $fail("This course code is in use!");
                break;
            }
        }
        //$course = Course::where('code', $value)->first();
    }
}
