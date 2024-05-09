<?php

namespace App\Http\Controllers;

use App\Client;
use App\Booking;

class BookingsController extends Controller
{
    public function index(Client $client)
    {
        $this->authorize('view', $client);

        return $client->bookings;
    }

    public function destroy(Booking $booking)
    {
        $this->authorize('delete', $booking->client);

        $booking->delete();

        return 'Deleted';
    }
}
