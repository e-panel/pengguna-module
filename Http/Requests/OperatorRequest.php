<?php

namespace Modules\Pengguna\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Pengguna\Entities\Operator;

class OperatorRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    // 'role_id' => 'required',
                    'nama' => 'required',
                    'username' => 'required|unique:operator,username',
                    'password' => 'required',
                    'avatar' => 'mimes:jpg,jpeg,png',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                $operator = Operator::uuid(request()->segment(4))->firstOrFail();
                return [
                    // 'role_id' => 'required',
                    'nama' => 'required',
                    'username' => 'required|unique:operator,username,'.$operator->id,
                    'avatar' => 'mimes:jpg,jpeg,png',
                ];
            }
            default:break;
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
