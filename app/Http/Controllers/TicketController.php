<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketStoreRequest;
use App\Models\Ticket;
use App\Models\TicketPriority;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $priorities = TicketPriority::all();

        return view('support.create')->with([
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

        $request->session()->flash('status', 'Thank you, your support ticket has been submitted.');

        return to_route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
