<?php

namespace App\Http\Controllers;

use App\Models\Flood;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class SuperAdminDashboardController extends Controller
{
    protected $userController;
    public function __construct(UserController $userController)
    {
        $this->userController = $userController;
    }
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
        $users = User::orderBy('created_at', 'asc')->get();
        return Inertia::render('dashboard/superadmin/master-data', ['users' => $users]);
    }

    public function createUserBySuperadmin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                'name' => ['required', 'string', 'min:3', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'max:32', 'confirmed'],
                'role' => ['required', 'string', 'in:USER,ADMIN,SUPERADMIN'],
            ], [
                // Email
                'email.required' => 'Alamat email wajib diisi.',
                'email.email' => 'Format alamat email tidak valid.',
                'email.max' => 'Alamat email tidak boleh lebih dari 255 karakter.',
                'email.unique' => 'Alamat email sudah digunakan, silakan gunakan email lain.',

                // Name
                'name.required' => 'Nama lengkap wajib diisi.',
                'name.min' => 'Nama lengkap minimal 3 karakter.',
                'name.max' => 'Nama lengkap maksimal 255 karakter.',

                // Password
                'password.required' => 'Password wajib diisi.',
                'password.min' => 'Password minimal 8 karakter.',
                'password.max' => 'Password maksimal 32 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak sesuai.',

                'role.required' => 'Password wajib diisi.',
                'role.in' => 'Role hanya bisa diisi User, Admin, Ataupun Superadmin.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors()->first());
            }

            $validated = $validator->validated();

            $emailTaken = User::where('email', $validated['email'])->count();
            if ($emailTaken > 0) {
                return redirect()->back()->withErrors('Email sudah digunakan, silahkan ganti');
            }

            $email = $validated['email'];
            $name = $validated['name'];
            $password = $validated['password'];
            $role = $validated['role'];
            $this->userController->createUser($name, $email, $password, $role);
            return redirect()->back();
        } catch (\Throwable $err) {
            if (config('app.debug')) {
                return redirect()->back()->withErrors($err->getMessage());
            }

            return redirect()->back()->withErrors('Coba Lagi beberapa saat');
        }

    }

    public function editUserBySuperadmin(Request $request, $id)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'email' => ['string', 'email', 'max:255', 'nullable'],
                    'name' => ['string', 'max:255', 'nullable'],
                    'password' => ['string', 'min:8', 'max:32', 'nullable'],
                    'role' => ['string', 'in:USER,ADMIN,SUPERADMIN', 'nullable'],
                ],
                [
                    // Email
                    'email.email' => 'Format alamat email tidak valid.',
                    'email.max' => 'Alamat email tidak boleh lebih dari 255 karakter.',

                    // Name
                    'name.string' => 'Nama harus berupa teks.',
                    'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',

                    // Password
                    'password.min' => 'Password minimal 8 karakter.',
                    'password.max' => 'Password maksimal 32 karakter.',

                    // Role
                    'role.in' => 'Role hanya bisa diisi User, Admin, Ataupun Superadmin.',
                ]
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors()->first());
            }

            $validated = $validator->validated();

            $user = $this->userController->getUserById($id);

            if (!$user) {
                return redirect()->back()->withErrors('Pengguna tidak ditemukan');
            }
            if ($validated['name']) {
                $user->update(['name' => $validated['name']]);
            }
            if ($validated['password']) {
                $user->update(['password' => $validated['password']]);
            }
            if ($validated['role']) {
                $user->update(['role' => $validated['role']]);
            }
            if ($validated['email']) {
                $emailExist = User::where('email', $validated['email'])->where('id', "!=", $user->id)->first();
                $isEmailTaken = $emailExist !== null;
                if ($isEmailTaken) {
                    return redirect()->back()->withErrors('Email sudah digunakan pengguna lain');

                }
                $user->update(['email' => $validated['email']]);
            }

            return redirect()->back();
        } catch (\Throwable $err) {
            if (config('app.debug')) {
                return redirect()->back()->withErrors($err->getMessage());
            }

            return redirect()->back()->withErrors('Coba Lagi beberapa saat');
        }
    }

    public function deleteUserBySuperadmin($id)
    {
        try {
            $user = $this->userController->getUserById($id);
            if (!$user) {
                return redirect()->back()->withErrors('Pengguna tidak valid');
            }
            $user->delete();
            return redirect()->back();
        } catch (\Throwable $err) {
            if (config('app.debug')) {
                return redirect()->back()->withErrors($err->getMessage());
            }

            return redirect()->back()->withErrors('Coba Lagi beberapa saat');
        }
    }
}
