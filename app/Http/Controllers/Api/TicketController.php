<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $tickets = Ticket::where('user_id', $user->id)
                        ->with('user')
                        ->orderBy('created_at', 'desc')
                        ->paginate($request->get('per_page', 10));

        return response()->json($tickets);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'type' => 'required|in:voice,non-voice',
            'priority' => 'required|string',
            'comment' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'country' => 'required|string',
            'language' => 'required|string',
            'form_fields' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
        }

        $ticket = Ticket::create([
            'title' => $request->title,
            'type' => $request->type,
            'priority' => $request->priority,
            'comment' => $request->comment,
            'attachment' => $attachmentPath,
            'country' => $request->country,
            'language' => $request->language,
            'form_fields' => $request->form_fields,
            'status' => 'Open',
            'user_id' => $request->user()->id,
        ]);

        return response()->json(['ticket' => $ticket->load('user'), 'message' => 'Ticket created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $user = $request->user();
        $ticket = Ticket::where('id', $id)
                       ->where('user_id', $user->id)
                       ->with('user')
                       ->firstOrFail();

        return response()->json($ticket);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = $request->user();
        $ticket = Ticket::where('id', $id)
                       ->where('user_id', $user->id)
                       ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|in:voice,non-voice',
            'priority' => 'sometimes|required|string',
            'comment' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'country' => 'sometimes|required|string',
            'language' => 'sometimes|required|string',
            'form_fields' => 'nullable|array',
            'status' => 'sometimes|in:Open,In Progress,Closed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->only(['title', 'type', 'priority', 'comment', 'country', 'language', 'form_fields', 'status']);

        if ($request->hasFile('attachment')) {
            // Delete old attachment if exists
            if ($ticket->attachment) {
                Storage::disk('public')->delete($ticket->attachment);
            }
            $data['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        $ticket->update($data);

        return response()->json(['ticket' => $ticket->load('user'), 'message' => 'Ticket updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $user = $request->user();
        $ticket = Ticket::where('id', $id)
                       ->where('user_id', $user->id)
                       ->firstOrFail();

        // Delete attachment if exists
        if ($ticket->attachment) {
            Storage::disk('public')->delete($ticket->attachment);
        }

        $ticket->delete();

        return response()->json(['message' => 'Ticket deleted successfully']);
    }
}
