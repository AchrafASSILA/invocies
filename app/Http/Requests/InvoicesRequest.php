<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoicesRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "invoice_number" =>  $this->route('invoice') ? "required|max:255" : "required|unique:invoices|max:255",
            "invoice_Date" => "required|max:255",
            "Due_date" => "required",
            "section_id" => "required",
            // "product" => "required|max:255",
            "amount" => 'required',
            'pic' => 'mimes:jpg,png,pdf,jpeg|file|max:2024',

        ];
    }
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            "invoice_number" => "رقم الفاتورة",
            "invoice_Date" => "تاريخ الفاتورة",
            "Due_date" => "تاريخ الاستحقآق",
            "section_id" => "القسم",
            "product" => "المنتج",
            "Amount_collection" => 'المبلغ المقترض',
            "Amount_borrowed" => "مبلغ التحصيل",
            "pic" => "المرفق",
        ];
    }
}
