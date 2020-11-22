<?php


namespace App\Request;


use Hyperf\Validation\Request\FormRequest;

class AbstractRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}