<?php

namespace App\Http\Controllers;

use App\Models\PurchaseHistory;
use App\Models\Ticket;
use Illuminate\Http\Request;

class PurchaseHistoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'event_id' => 'required|integer',
            'ticket_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        // Find the ticket
        $ticket = Ticket::find($request->input('ticket_id'));

        if (!$ticket) {
            return response()->json(['error' => 'Ticket not found']);
        }

        // Ensure there are enough tickets available
        if ($ticket->quantity < $request->input('quantity')) {
            return response()->json(['error' => 'Not enough tickets available']);
        }

        // Deduct the purchased quantity from the ticket in the tickets table
        $newQuantity = max(0, $ticket->quantity - $request->input('quantity'));
        $ticket->update(['quantity' => $newQuantity]);

        // Create a new purchase history record
        $purchaseHistory = PurchaseHistory::create([
            'user_id' => $request->input('user_id'),
            'event_id' => $request->input('event_id'),
            'ticket_id' => $request->input('ticket_id'),
            'quantity' => $request->input('quantity'),
        ]);

        return response()->json([
            'message' => 'Tickets purchased!',
            'purchase_history' => $purchaseHistory,
            'dataAdd' => 'ok'
        ], 201);
    }
    public function index()
    {
        $purchaseHistory = PurchaseHistory::all();

        return response()->json(['purchase_history' => $purchaseHistory]);
    }
}
