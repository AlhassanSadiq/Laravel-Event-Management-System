<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $event = cache()->remember('event_details', 3600, function () {
            return Event::first();
        });

        if (!$event) {
            abort(404, 'Event not found');
        }
        return view('landing', compact('event'));
    }
}
