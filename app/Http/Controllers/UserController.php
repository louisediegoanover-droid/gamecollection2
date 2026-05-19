<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display users listing (for dashboard)
     */
    public function index()
    {
        $users = User::select('id', 'name', 'email', 'gender', 'role', 'status')
                    ->orderBy('id', 'desc')
                    ->get();
        
        return view('dashboard', compact('users'));
    }

    /**
     * Store new user - FIXED
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
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

        return redirect()->back()->with('success', 'User added successfully!');
    }

    /**
     * Update user - FIXED ✅
     */
    public function update(Request $request, User $user)
    {
        // ✅ Use Model Binding - matches route {user}
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'gender' => 'required|in:male,female,other',
            'role' => 'required|in:user,admin',
            'status' => 'required|in:active,inactive',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // ✅ Check for changes
        $hasChanges = (
            $user->name !== $request->name ||
            $user->email !== $request->email ||
            $user->gender !== $request->gender ||
            $user->role !== $request->role ||
            $user->status !== $request->status ||
            $request->filled('password')
        );

        if (!$hasChanges) {
            return back()->with('error', 'No changes detected!');
        }

        // ✅ Prepare update data
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'role' => $request->role,
            'status' => $request->status,
        ];

        // ✅ Add password if provided
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return back()->with('success', 'User updated successfully!');
    }

    /**
     * Delete user - FIXED ✅
     */
    public function destroy(User $user)
    {
        // ✅ Prevent self-deletion
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Cannot delete your own account!');
        }

        // ✅ Delete avatar if exists
        if ($user->avatar) {
            $avatarPath = public_path('storage/uploads/' . $user->avatar);
            if (file_exists($avatarPath)) {
                unlink($avatarPath);
            }
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully!');
    }
}