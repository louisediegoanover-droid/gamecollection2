<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    public function index()
    {
        // FIXED: contacts.blade.php instead of contacts.index
        return view('contacts');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|max:100',
            'subject' => 'required|string|max:200',
            'topic' => ['required', Rule::in(['General', 'Support', 'Partnership', 'Feedback', 'Bug Report', 'Other'])],
            'message' => 'required|string|min:10|max:5000'
        ], [
            'first_name.required' => 'First name is required.',
            'email.email' => 'Please enter a valid email address.',
            'message.min' => 'Message must be at least 10 characters.',
        ]);

        try {
            Log::info('Contact form submitted:', [
                'data' => $validated,
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Thank you! Your message has been sent. 🎮',
            ]);

        } catch (\Exception $e) {
            Log::error('Contact form error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }
}