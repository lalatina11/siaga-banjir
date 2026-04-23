<?php

namespace App\Http\Controllers;

use App\Models\Flood;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserDashboardController extends Controller
{
    public function getFloods()
    {
        try {
            return Flood::where('user_id', request()->user()->id)->with(['user'])->orderBy('updated_at', 'desc')->get();
        } catch (\Throwable $th) {
            return [];
        }
    }
    public function index()
    {
        $floods = $this->getFloods();
        return Inertia::render('dashboard/user/index', ['floods' => $floods]);
    }
}
