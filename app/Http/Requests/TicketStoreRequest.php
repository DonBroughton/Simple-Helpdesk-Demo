<?php

namespace App\Http\Requests;

use App\Models\TicketPriority;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TicketStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (!auth()->user()->is_admin) return true;

        // For this example, Admins will not be allowed to create tickets
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'  =>  'required|min:3',
            'description'  =>  'required|min:3',
            'priority'  =>  [
                'required',
                'exists:ticket_priorities,name'
            ],
        ];
    }
}
