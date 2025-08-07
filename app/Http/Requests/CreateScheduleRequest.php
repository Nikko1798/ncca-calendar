<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'title' => ['required', 'string', 'max:255'],
            'details' => ['nullable', 'string'],
            'start_date' => ['required', 'date', 'after_or_equal:today', 'before_or_equal:end_date'],
            'start_time' => ['required', 'date_format:H:i',],
            'end_date' => ['required', 'date', 'after_or_equal:today'],
            'end_time' => ['required', 'date_format:H:i'],
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $startDate = $this->input('start_date');
            $endDate = $this->input('end_date');
            $startTime = $this->input('start_time');
            $endTime = $this->input('end_time');

            if ($startDate === $endDate && strtotime($startTime) >= strtotime($endTime)) {
                $validator->errors()->add('start_time', 'Start time must be before end time when dates are the same.');
            }
        });
    }
}
