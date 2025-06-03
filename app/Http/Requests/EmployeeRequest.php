<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'id' => 'nullable|exists:employees,id',
            'email' => 'required|email',
            'name' => 'required',
            'city' => 'required',
            'domicile' => 'required',
            'blood_type' => 'required',
            'place_birth' => 'required',
            'date_birth' => 'required|date',
            'gender' => 'required',
            'religion' => 'required',
            'marriage' => 'required',
            'education' => 'required',
            'whatsapp' => 'required|regex:/^[0-9]+$/',
            'bank' => 'required',
            'bank_number' => 'required|numeric',
            'position_id' => 'required|integer',
            'joining_date' => 'required|date',
            'employee_status' => 'required',
            'sales_status' => 'required',
            'workDay' => 'required|array|min:1',
            'officeLocations' => 'required|array|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'workDay.required' => 'Jadwal kerja wajib dipilih.',
            'workDay.array' => 'Jadwal kerja harus berupa array.',
            'workDay.min' => 'Minimal satu jadwal kerja harus dipilih.',
            'officeLocations.required' => 'Lokasi kantor wajib dipilih.',
            'officeLocations.array' => 'Lokasi kantor harus berupa array.',
            'officeLocations.min' => 'Minimal satu lokasi kantor harus dipilih.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'name.required' => 'Nama wajib diisi.',
            'city.required' => 'Kota wajib diisi.',
            'domicile.required' => 'Domisili wajib diisi.',
            'place_birth.required' => 'Tempat lahir wajib diisi.',
            'date_birth.required' => 'Tanggal lahir wajib diisi.',
            'date_birth.date' => 'Tanggal lahir harus berupa tanggal yang valid.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'religion.required' => 'Agama wajib dipilih.',
            'marriage.required' => 'Status pernikahan wajib dipilih.',
            'education.required' => 'Pendidikan wajib dipilih.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'whatsapp.regex' => 'Nomor WhatsApp hanya boleh angka.',
            'bank.required' => 'Nama bank wajib dipilih.',
            'bank_number.required' => 'Nomor rekening wajib diisi.',
            'bank_number.numeric' => 'Nomor rekening harus berupa angka.',
            'position_id.required' => 'Jabatan wajib dipilih.',
            'position_id.integer' => 'Jabatan tidak valid.',
            'joining_date.required' => 'Tanggal bergabung wajib diisi.',
            'joining_date.date' => 'Tanggal bergabung harus berupa tanggal yang valid.',
            'employee_status.required' => 'Status karyawan wajib dipilih.',
            'sales_status.required' => 'Status sales wajib dipilih.',
        ];
    }
}
