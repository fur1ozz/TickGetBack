<?php
// app/Http/Controllers/EventController.php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();

        $eventsData = [];

        foreach ($events as $event) {
            $standartTicket = Ticket::find($event->standart_ticket_id);
            $vipTicket = Ticket::find($event->vip_ticket_id);

            if (!$standartTicket || !$vipTicket) {
                continue; // Skip events with missing tickets
            }

            $standartTicketPrice = $standartTicket->price;
            $vipTicketPrice = $vipTicket->price;

            $eventData = $event->toArray();
            $eventData['standart_ticket_price'] = $standartTicketPrice;
            $eventData['vip_ticket_price'] = $vipTicketPrice;

            $eventsData[] = $eventData;
        }

        return response()->json(['events' => $eventsData]);
    }

    public function show($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }

        $standartTicket = Ticket::find($event->standart_ticket_id);
        $vipTicket = Ticket::find($event->vip_ticket_id);
        $premiumTicket = Ticket::find($event->premium_ticket_id);

        if (!$standartTicket) {
            return response()->json(['error' => 'Standart ticket not found'], 404);
        }

        if (!$vipTicket) {
            return response()->json(['error' => 'VIP ticket not found'], 404);
        }

        if (!$premiumTicket) {
            return response()->json(['error' => 'Premium ticket not found'], 404);
        }

        $eventData = $event->toArray();
        // Standard Ticket
        $eventData['standart_ticket_price'] = $standartTicket->price;
        $eventData['standart_ticket_quantity'] = $standartTicket->quantity;

        // VIP Ticket
        $eventData['vip_ticket_price'] = $vipTicket->price;
        $eventData['vip_ticket_quantity'] = $vipTicket->quantity;

        // Premium Ticket
        $eventData['premium_ticket_price'] = $premiumTicket->price;
        $eventData['premium_ticket_quantity'] = $premiumTicket->quantity;


        return response()->json(['event' => $eventData]);
    }

//insert
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|string',
            'description' => 'required|string',
            'standart_ticket_price' => 'required|numeric',
            'standart_ticket_quantity' => 'required|integer',
            'premium_ticket_price' => 'required|numeric',
            'premium_ticket_quantity' => 'required|integer',
            'vip_ticket_price' => 'required|numeric',
            'vip_ticket_quantity' => 'required|integer',
        ]);

        // Extract data from the request
        $eventData = $request->only(['name', 'location', 'date', 'time', 'description']);
        $ticketData = $request->only([
            'standart_ticket_price', 'standart_ticket_quantity',
            'premium_ticket_price', 'premium_ticket_quantity',
            'vip_ticket_price', 'vip_ticket_quantity',
        ]);

        // Call the function to create event with tickets
        $event = $this->createEventWithTickets($eventData, $ticketData);

        return response()->json(['eventAdd' => "ok"], 201);
    }

    private function createEventWithTickets($eventData, $ticketData)
    {
        // Create tickets
        $standartTicket = $this->createTicket($ticketData['standart_ticket_price'], $ticketData['standart_ticket_quantity']);
        $premiumTicket = $this->createTicket($ticketData['premium_ticket_price'], $ticketData['premium_ticket_quantity']);
        $vipTicket = $this->createTicket($ticketData['vip_ticket_price'], $ticketData['vip_ticket_quantity']);

        // Insert tickets with non-zero quantity into the events table
        $event = Event::create([
            'name' => $eventData['name'],
            'location' => $eventData['location'],
            'date' => $eventData['date'],
            'time' => $eventData['time'],
            'description' => $eventData['description'],
            'standart_ticket_id' => $standartTicket ? $standartTicket->id : null,
            'premium_ticket_id' => $premiumTicket ? $premiumTicket->id : null,
            'vip_ticket_id' => $vipTicket ? $vipTicket->id : null,
        ]);

        return $event;
    }

    private function createTicket($price, $quantity)
    {
        // Insert ticket only if quantity is greater than 0
        if ($quantity > 0) {
            return Ticket::create([
                'price' => $price,
                'quantity' => $quantity,
            ]);
        }

        return null;
    }
}
