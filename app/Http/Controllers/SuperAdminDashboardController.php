<?php

namespace App\Http\Controllers;

use App\Models\Flood;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SuperAdminDashboardController extends Controller
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
        return Inertia::render('dashboard/superadmin/index', ['floods' => $floods]);
    }

    public function showMasterDataPage()
    {
        $users = User::where('role', '!=', 'SUPERADMIN')->orderBy('created_at', 'asc')->get();
        return Inertia::render('dashboard/superadmin/master-data', ['users' => $users]);
    }
}
