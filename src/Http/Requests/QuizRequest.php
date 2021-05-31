<?php

namespace Arthurmelikyan\Quizable\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuizRequest extends FormRequest
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
            'title' => ['string','required','max:255'],
            'time_limit' => ['nullable', 'int','min:0','max:1440'],
            'description' => ['string','nullable','max:255'],
        ];
    }
}
