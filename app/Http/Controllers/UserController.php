<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'type' => 'required|integer|in:0,1,2',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')), // Enkripsi password
            'type' => $request->input('type'),
        ]);

        return redirect()->back()->with('success', 'User berhasil dibuat.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'type' => 'required|integer|in:0,1,2',
        ]);

        $user->update($validatedData);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }


    public function search(Request $request)
    {
        $query = $request->input('searchorders');
        $users = User::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->get();

        return view('users.index', compact('users'));
    }

    public function profile(Request $request)
    {
        $user = $request->user();
        return view('profile.edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }

        if ($request->hasFile('photo')) {
            if ($user->photo && file_exists(public_path('foto/' . $user->photo))) {
                unlink(public_path('foto/' . $user->photo));
            }

            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('foto'), $filename);
            $user->photo = $filename;
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profile berhasil diperbarui!');
    }
}
