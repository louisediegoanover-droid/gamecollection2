<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with users
     */
    public function index()
    {
        $users = User::select('id', 'name', 'email', 'gender', 'role', 'status')
                    ->orderBy('id', 'desc')
                    ->get();
        
        return view('dashboard', compact('users'));
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'gender' => 'required|in:male,female,other',
            'role' => 'required|in:user,admin',
            'status' => 'required|in:active,inactive',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'role' => $request->role,
            'status' => $request->status,
        ]);

        return redirect()->route('dashboard.index')
                        ->with('success', 'User created successfully!');
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:6|confirmed',
            'gender' => 'required|in:male,female,other',
            'role' => 'required|in:user,admin',
            'status' => 'required|in:active,inactive',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'role' => $request->role,
            'status' => $request->status,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('dashboard.index')
                        ->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified user
     */
    public function destroy(Request $request, User $user)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Prevent deleting yourself
        if ($user->id == auth()->id()) {
            return redirect()->route('dashboard.index')
                           ->with('success', 'Cannot delete your own account!');
        }

        $user->delete();

        return redirect()->route('dashboard.index')
                        ->with('success', 'User deleted successfully!');
    }
}