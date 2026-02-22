<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:20'],
            'equipment_id' => ['nullable', 'exists:equipment,id'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
            'rental_date_from' => ['nullable', 'date', 'after_or_equal:today'],
            'rental_date_to' => ['nullable', 'date', 'after_or_equal:rental_date_from'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Imię i nazwisko jest wymagane.',
            'email.required' => 'Adres e-mail jest wymagany.',
            'email.email' => 'Podaj prawidłowy adres e-mail.',
            'message.required' => 'Wiadomość jest wymagana.',
            'message.min' => 'Wiadomość musi mieć co najmniej 10 znaków.',
            'rental_date_from.after_or_equal' => 'Data rozpoczęcia nie może być w przeszłości.',
            'rental_date_to.after_or_equal' => 'Data zakończenia musi być po dacie rozpoczęcia.',
        ];
    }
}
