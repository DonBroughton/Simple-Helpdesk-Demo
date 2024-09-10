<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Http\Requests\TicketReplyStoreRequest;

class TicketReplyController extends Controller
{
    public function store(TicketReplyStoreRequest $request, Ticket $ticket)
    {
        $ticket->replies()->create([
            'user_id' => auth()->user()->id,
            'body'  =>  $request->validated('reply'),
        ]);

        return redirect()->back();
    }
}
