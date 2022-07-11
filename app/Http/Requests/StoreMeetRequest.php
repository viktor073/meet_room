<?php

namespace App\Http\Requests;

use App\Interface\Meet\Data\MeetInterface;
use Illuminate\Foundation\Http\FormRequest;

class StoreMeetRequest extends FormRequest
{
    /**
     * Min and Max Interval value
     */
    const MIN_INTERVAL = 30;
    const MAX_INTERVAL = 1440;

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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string',],
            'description' => ['required', 'string',],
            'time_from' => ['required', 'date',],
            'time_to' => ['required', 'date', 'after:time_from',],
            MeetInterface::PARTICIPANT_IDS => ['required', 'array',],
        ];
    }

    /**
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function passedValidation()
    {
        $interval = round((strtotime($this->time_to) - strtotime($this->time_from)) / 60,2);
        if ($interval < self::MIN_INTERVAL || $interval > self::MAX_INTERVAL) {
            $validator = $this->getValidatorInstance();
            $validator->getMessageBag()->add(
                'time_to', __('The interval should be at least 30 minutes and no more than 24 hours')
            );
            $this->failedValidation($validator);
        }
    }
}
