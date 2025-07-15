<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class DashboardUserController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('viewAny', User::class);

        // Validasi Input
        $validated = $request->validate([
            'search' => 'nullable|string|max:255',
        ]);

        // Ambil data validasi search
        $search = $validated['search'] ?? null;

        // Query User
        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.users.index', compact('users'));
    }

    public function create()
    {
        Gate::authorize('create', User::class);

        return view('dashboard.users.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('create', User::class);

        // Validasi Input
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email:dns|unique:users,email',
            'role'     => 'required|in:Admin,Inspector,Customer',
            'password' => 'required|string|min:8',
        ]);

        // Simpan User
        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'role'     => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('dashboard.user.index')->with('success', 'User successfully created.');
    }

    public function edit(string $id)
    {
        // Ambil User
        $user = User::findOrFail($id);

        Gate::authorize('update', $user);

        return view('dashboard.users.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        // Ambil User
        $user = User::findOrFail($id);

        Gate::authorize('update', $user);

        // Validasi input
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email:dns|unique:users,email,' . $user->id,
            'role'     => 'required|in:Admin,Inspector,Customer',
            'password' => 'nullable|string|min:8',
        ]);

        // Update user data
        $user->update([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'role'     => $validated['role'],
            'password' => $validated['password']
                ? Hash::make($validated['password'])
                : $user->password,
        ]);

        return redirect()->route('dashboard.user.index')->with('success', 'User successfully updated.');
    }


    public function destroy(string $id)
    {
        // Ambil User
        $user = User::findOrFail($id);

        Gate::authorize('delete', $user);

        // Hapus User
        $user->delete();

        return redirect()->route('dashboard.user.index')->with('success', 'User successfully deleted.');
    }
}
