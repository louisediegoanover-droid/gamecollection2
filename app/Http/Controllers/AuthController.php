<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    /* =========================
        SHOW LOGIN FORM - ✅ ADDED MISSING METHOD
    ========================= */
    public function showLogin()
    {
        return view('login');
    }

    /* =========================
        LOGIN - FIXED TO LANDING
    ========================= */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // ✅ GOES TO LANDING PAGE
           return redirect('/landing')
           ->with('login_success', auth()->user()->name);
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->withInput();
    }

    /* =========================
        SHOW REGISTER
    ========================= */
    public function showRegister()
    {
        return view('register');
    }

    /* =========================
        REGISTER - GOES TO LOGIN
    ========================= */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'gender' => 'required|in:male,female,other'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'role' => 'user',
            'status' => 'active'
        ]);

        // ✅ REDIRECTS TO LOGIN
        return redirect()->route('login')
                       ->with('success', 'Registration successful! Please login.');
    }

    /* =========================
        DASHBOARD
    ========================= */
    public function dashboard()
    {
        $currentUser = Auth::user();
        if ($currentUser->role === 'admin') {
            $users = User::select('id', 'name', 'email', 'gender', 'role', 'status')
                        ->orderBy('id', 'desc')
                        ->get();
        } else {
            $users = User::where('id', '!=', $currentUser->id)
                        ->select('id', 'name', 'email', 'gender', 'role', 'status')
                        ->orderBy('id', 'desc')
                        ->get();
        }
        
        return view('dashboard', compact('users'));
    }

    /* =========================
        PROFILE & UPDATE (unchanged)
    ========================= */
    public function profile()
    {
        return view('profile');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required','email','max:255',Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'bio' => 'nullable|string|max:1000',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:6',
            'confirm_password' => 'nullable|same:new_password',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('phone')) $updateData['phone'] = $request->phone;
        if ($request->filled('address')) $updateData['address'] = $request->address;
        if ($request->filled('bio')) $updateData['bio'] = $request->bio;

        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->with('error', 'Current password is incorrect!');
            }
            if ($request->new_password !== $request->confirm_password) {
                return back()->with('error', 'New passwords do not match!');
            }
            $updateData['password'] = Hash::make($request->new_password);
        }

        $user->update($updateData);
        return back()->with('success', 'Profile updated successfully!');
    }

    /* =========================
        AVATAR (unchanged)
    ========================= */
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = Auth::user();
        if ($user->avatar) {
            $oldPath = public_path('storage/uploads/' . $user->avatar);
            if (file_exists($oldPath)) unlink($oldPath);
        }

        $file = $request->file('avatar');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('storage/uploads'), $filename);

        $user->update(['avatar' => $filename]);
        return back()->with('success', 'Profile picture updated!');
    }

    public function removeAvatar()
    {
        $user = Auth::user();
        if ($user->avatar) {
            $oldPath = public_path('storage/uploads/' . $user->avatar);
            if (file_exists($oldPath)) unlink($oldPath);
            $user->update(['avatar' => null]);
        }
        return back()->with('success', 'Profile picture removed!');
    }

    /* =========================
        CRUD (unchanged)
    ========================= */
    public function storeUser(Request $request)
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

        return redirect()->back()->with('success', 'User created successfully!');
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => ['required','email','max:255',Rule::unique('users')->ignore($user)],
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

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);
        return redirect()->back()->with('success', 'User updated successfully!');
    }

    public function destroyUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Cannot delete your own account!');
        }

        if ($user->avatar) {
            $path = public_path('storage/uploads/' . $user->avatar);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully!');
    }

    /* =========================
        LOGOUT - FIXED TO LANDING
    ========================= */
   public function logout()
{
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/login');
}
}