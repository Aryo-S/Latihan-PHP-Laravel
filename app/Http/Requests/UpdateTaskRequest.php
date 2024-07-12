<?php

namespace App\Http\Requests;

class UpdateTaskRequest extends StoreTaskRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    // code dibawah bila false, akan membuat endpoint ini inaccessible dan kembalinya akan error 403
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    // code dibawah adalah bentuk validasi request agar memiliki kriteria tertentu
    // 'name' => 'required|string|max:255' berarti column name harus ada, harus string dan max 255 JIKA GAGAL AKAN MUNCUL ERROR 422
    public function rules(): array
    {
        return [
            'name'=> 'required|string|max:255',
        ];
    }
}
