<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        // Ambil user yang role-nya 'Customer'
        $customers = User::whereHas('role', function($q) {
            $q->where('name', 'Customer');
        })->with('profile')->latest()->paginate(10);

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'nullable|string',
            'gender' => 'nullable|in:Male,Female',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Cari Role Customer
            $roleCustomer = Role::where('name', 'Customer')->firstOrFail();

            // 2. Buat User Baru
            $user = User::create([
                'role_id' => $roleCustomer->id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // 3. Buat User Profile
            UserProfile::create([
                'user_id' => $user->id,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'birth_date' => $request->birth_date
            ]);
        });

        return redirect()->route('customers.index')->with('success', 'Customer registered successfully');
    }

    public function show(User $customer)
    {
        // Load profil, alamat, dan riwayat pesanan
        $customer->load(['profile', 'addresses', 'orders']);
        return view('customers.show', compact('customer'));
    }

    public function edit(User $customer)
    {
        $customer->load('profile');
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, User $customer)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $customer->id,
            'phone' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $customer) {
            // Update User Utama
            $customer->update([
                'name' => $request->name,
                'email' => $request->email,
                // Password diupdate hanya jika diisi
                'password' => $request->filled('password') ? Hash::make($request->password) : $customer->password,
            ]);

            // Update Profile (Gunakan updateOrCreate jika profile belum ada)
            UserProfile::updateOrCreate(
                ['user_id' => $customer->id],
                [
                    'phone' => $request->phone,
                    'gender' => $request->gender,
                    'birth_date' => $request->birth_date
                ]
            );
        });

        return redirect()->route('customers.index')->with('success', 'Customer data updated');
    }

    public function destroy(User $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted');
    }
}
