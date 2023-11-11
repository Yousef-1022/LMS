<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;
use App\Models\Course;

class RedundantCourseCode implements ValidationRule
{

    private $oldValue;

    public function __construct($oldValue)
    {
        $this->oldValue = $oldValue;
    }

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
            if ($this->oldValue === $course->code) {
                continue;
            }
            if ($course->code === $value) {
                $courses = Course::all();
                $fail("This course code is in use!");
                break;
            }
        }
    }
}
