<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketReplyStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // A Ticket must be open to accept a Reply
        if(!$this->ticket->is_open){
            return false;
        }

        // Only the Ticket owner or an Admin can reply to the Ticket
        if (($this->ticket->user->id == auth()->user()->id) || auth()->user()->is_admin) {
            return true;
        };

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
            'reply'  =>  'required',
        ];
    }
}
