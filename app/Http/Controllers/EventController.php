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
}
