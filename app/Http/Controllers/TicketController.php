<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketStoreRequest;
use App\Http\Requests\TicketUpdateRequest;
use App\Models\Ticket;
use App\Models\TicketPriority;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Admins see all Tickets and Associated User, Ticket owners only see Tickets they have created
        if (auth()->user()->is_admin) {
            $tickets = Ticket::with('priority', 'user')->get();
        }
        else {
            $tickets = Ticket::where('user_id', auth()->user()->id)
                ->with('priority')
                ->get();
        }

        return view('ticket.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $priorities = TicketPriority::all();

        return view('ticket.create')->with([
            'priorities'  =>  $priorities,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketStoreRequest $request)
    {
        $priority = TicketPriority::where('name', $request->validated('priority'))->first();

        Ticket::create([
            'user_id' => auth()->user()->id,
            'title'  =>  $request->validated('title'),
            'description' => $request->validated('title'),
            'priority_id'  =>  $priority->id,
        ]);

        $request->session()->flash('status', 'Thank you, your ticket ticket has been submitted.');

        return to_route('ticket.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ticket = Ticket::where('id', $id)
            ->with(['priority', 'replies', 'replies.user'])
            ->firstOrFail();

        // Only Ticket owners and Admins can see Tickets
        if (auth()->user()->id !== $ticket->user_id && !auth()->user()->is_admin) {
            abort(403);
        }

        return view('ticket.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param TicketUpdateRequest $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TicketUpdateRequest $request, string $id)
    {
        if ($request->get('status') == 0){
            $ticket = Ticket::where('id', $id)->firstOrFail();
            $ticket->is_open = 0;
            $ticket->save();

            $request->session()->flash('status', 'Ticket#' . $ticket->id . " was marked as CLOSED.");
        }

        return to_route('ticket.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
