<?php

namespace Arthurmelikyan\Quizable\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreateQuestionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'type' => [
                Rule::in(
                    [
                        'multiple',
                        'dropdown',
                        'file',
                        'radio',
                        'text',
                        'textarea'
                    ])
            ],
            'file_type' => [
//                'required',
                Rule::in(
                    [
                        '',
                        'image',
                        'video',
                        'youtube',
                        'image_url',
                    ])

            ],
            'file' => [
                'file',
//                'required_if:url, ""'
            ],
            'url' => [
//                'string',
//                'required_if:file, ""'
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(['errors' => $errors
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
