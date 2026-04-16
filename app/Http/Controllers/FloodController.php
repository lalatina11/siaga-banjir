<?php

namespace App\Http\Controllers;

use App\Models\Flood;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Laravolt\Avatar\Avatar;

class FloodController extends Controller
{
    private function getFloodbyId($id)
    {
        try {
            $flood = Flood::where('id', $id)->first();
            if ($flood != null) {
                return $flood;
            }
            return null;
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function index()
    {
        $floods = Flood::get();
        $avatar = new Avatar([]);
        $avatar->create("Mulyono");

        return Inertia::render('home', ['floods' => $floods, 'avatar' => $avatar->toBase64()]);
    }

    public function show($id)
    {
        $flood = $this->getFloodbyId($id);
        if ($flood == null) {
            return Inertia::render('error/not-found-error');
        }
        return Inertia::render('single-flood', ['flood' => $flood]);
    }
}
