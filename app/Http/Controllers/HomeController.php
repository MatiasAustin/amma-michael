<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Countdown;
use App\Models\Guest;
use App\Models\Rsvp;

class HomeController extends Controller
{
    public function index()
    {
        // Countdown (satu record saja)
        $countdown = Countdown::first();

        // Gallery photos
        $photos = Photo::latest()->get();

        // ===== Wishes (gabung dari guests + rsvps) =====

        // Dari tabel guests → nama diambil dari first + last, ucapan dari dietary
        $guestWishes = Guest::select('first_name', 'last_name', 'dietary')
            ->get()
            ->map(function ($g) {
                return [
                    'name'    => trim($g->first_name . ' ' . ($g->last_name ?? '')),
                    'message' => $g->dietary,   // pakai dietary sebagai ucapan
                ];
            });

        // Dari tabel rsvps → nama dari contact_name, ucapan dari message
        $rsvpWishes = Rsvp::select('contact_name', 'message')
            ->get()
            ->map(function ($r) {
                return [
                    'name'    => $r->contact_name,
                    'message' => $r->message,
                ];
            });

        // Gabung, buang yang message kosong, lalu acak
        $wishes = $guestWishes
            ->merge($rsvpWishes)
            ->filter(fn ($w) => !empty($w['message']))
            ->shuffle()
            ->values(); // reset index

        return view('home', compact('countdown', 'photos', 'wishes'));
    }
}