<?php

namespace App\Http\Controllers;

use App\Models\Flood;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    private function getFloods()
    {
        try {
            return Flood::with(['user'])->orderBy('updated_at', 'desc')->get();
        } catch (\Throwable $th) {
            return [];
        }
    }
    public function index()
    {
        $floods = $this->getFloods();
        return Inertia::render('dashboard/admin/index', ['floods' => $floods]);
    }
}
