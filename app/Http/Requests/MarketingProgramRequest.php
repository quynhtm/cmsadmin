<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MarketingProgramRequest extends FormRequest
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
        switch($this->method())
        {
            case 'POST':
                {
                    return [
                        'name' => 'required|min:5|max:100',
                        'campaign_id' => 'required',
                        'budget' => 'required',
                        'created_at' => 'required|date',
                        'date_start' => 'required|date',
                        'date_end' => 'required|date',
                        'applicable_subjects' => 'required',
                        'careers_id' => 'required',
                        'policy_program' => 'required',
                        'unit'=> 'required',
                        'value'=> 'required',
                    ];
                }
            case 'PATCH':
                {
                    return [
                        'name' => 'required|min:5|max:100',
                        'campaign_id' => 'required',
                        'budget' => 'required',
                        'created_at' => 'required|date',
                        'date_start' => 'required|date',
                        'date_end' => 'required|date',
                        'applicable_subjects' => 'required',
                        'careers_id' => 'required',
                        'note' => 'required',
                        'policy_program' => 'required',
                        'unit'=> 'required|number',
                        'value'=> 'required|number',
                    ];
                }
            default: break;
        }
    }

    public function messages ()
    {
        return [
            'name.required' => 'Bạn phải nhập tên chương trình',
            'name.min' => 'Bạn phải nhập tên chương trình ít nhất là 5 ký tự',
            'name.max' => 'Bạn phải nhập tên chương trình nhiều nhất không được vượt quá 100 ký tự',
            'campaign_id.required' => 'Bạn phải chọn chiến dịch',
            'budget.required' => 'Bạn phải nhập ngân sách dự kiến',
            'created_at.required' => 'Bạn phải nhập ngày tạo',
            'date_end.required' => 'Bạn phải nhập ngày kết thúc',
            'date_start.required' => 'Bạn phải nhập ngày bắt đầu',
            'applicable_subjects.required' => 'Bạn phải chọn đối tượng áp dụng',
            'careers_id.required' => 'Bạn phải chọn nghề nghiệp',
            'note.required' => 'Bạn phải nhập mô tả',
            'policy_program.required' => 'Bạn phải nhập chính sách',
            'unit.required' => 'Bạn phải nhập đơn vị',
            'unit.number' => 'Đơn vị nhập vào phải là số nguyên',
            'value.required' => 'Bạn phải nhập giá trị',
            'value.number' => 'Giá trị nhập vào phải là số nguyên',
        ];
    }
}
