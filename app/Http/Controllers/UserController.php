<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function registerHandler(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
        ]);

        try {
            User::create($validatedData);
            return redirect()->route('login')->with('message', 'Register Success');
        } catch (\Exception $e) {
            return redirect()->route('register.index')->with('error', 'Register Failed: ' . $e->getMessage());
        }
    }

    public function loginHandler(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            // Mencari pengguna berdasarkan username
            $user = User::where('username', $request->username)->first();

            // Mengecek jika user ditemukan dan password yang dimasukkan sesuai
            if ($user && Hash::check($request->password, $user->password)) {
                // Melakukan login dan menyetel sesi pengguna
                Auth::login($user);

                return redirect()->route('home')->with('message', 'Login Success');
            }

            // Jika kredensial salah
            return redirect()->route('login')->withErrors(['login_error' => 'Invalid credentials'])->withInput();
        } catch (\Exception $e) {
            // Menangani kesalahan
            return redirect()->route('login')->withErrors(['login_error' => 'Login failed: ' . $e->getMessage()])->withInput();
        }
    }

    public function logoutHandler()
    {
        \Illuminate\Support\Facades\Auth::logout();
        return redirect()->route('login');
    }

    public function homeHandler()
    {
        //saya ingin mengambil semua data user kecuali user yang login
        $users = User::where('id', '!=', Auth::id())->get();
        return view('layouts.home', ['users' => $users]);
    }

    public function renderMessage($username)
    {
        $users = User::where('id', '!=', Auth::id())->get();
        $selectedUser = User::where('username', $username)->first();
        $messages = Message::where(function ($query) use ($selectedUser) {
            $query->where('from_user_id', Auth::id())
                ->where('to_user_id', $selectedUser->id);
        })->orWhere(function ($query) use ($selectedUser) {
            $query->where('from_user_id', $selectedUser->id)
                ->where('to_user_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        //update is_read
        Message::where('from_user_id', $selectedUser->id)
            ->where('to_user_id', Auth::id())
            ->where('is_read', 0)
            ->update(['is_read' => 1]);


        return view('layouts.home', ['users' => $users, 'selectedUser' => $selectedUser, 'messages' => $messages]);
    }

    public function sendMessage(Request $request, $username)
    {
        $request->validate([
            'messageType' => 'required|string'
        ]);
        $selectedUser = User::where('username', $username)->first();
        $message = new Message();

        switch ($request->messageType) {
            case 'message':
                $request->validate([
                    'message' => 'required|string'
                ]);
                $message->message = $request->message;
                break;
            case 'image':
                try {
                    $request->validate([
                        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                        'hiddenMessage' => 'required|string'
                    ]);

                    // Simpan gambar ke storage lokal
                    $image = $request->file('image');
                    $imagePath = $image->storeAs('images', $image->hashName(), 'public');

                    // Menyimpan URL gambar ke dalam database
                    $message->message = asset('storage/' . $imagePath);
                } catch (\Exception $e) {
                    // Tangkap dan log error
                    Log::error('Error uploading image: ' . $e->getMessage());

                    // Mengembalikan respon error dengan pesan yang sesuai
                    return response()->json([
                        'error' => 'There was an issue with uploading the image. Please try again later.',
                        'details' => $e->getMessage()
                    ], 500);
                }
                break;
            case 'file':
                try {
                    $request->validate([
                        'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar|max:2048'
                    ]);

                    // Simpan gambar ke storage lokal
                    $file = $request->file('file');
                    $filePath = $file->storeAs('files', $file->hashName(), 'public');

                    // Menyimpan URL gambar ke dalam database
                    $message->message = asset('storage/' . $filePath);
                } catch (\Exception $e) {
                    // Tangkap dan log error
                    Log::error('Error uploading file: ' . $e->getMessage());

                    // Mengembalikan respon error dengan pesan yang sesuai
                    return response()->json([
                        'error' => 'There was an issue with uploading the file. Please try again later.',
                        'details' => $e->getMessage()
                    ], 500);
                }
                break;
            default:
                return redirect()->route('chat', ['username' => $username])->withErrors(['message_error' => 'Invalid message type'])->withInput();
        }

        $message->from_user_id = Auth::id();
        $message->to_user_id = $selectedUser->id;
        $message->save();

        return redirect()->route('chat', ['username' => $username]);
    }
}
