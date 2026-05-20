<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $users = User::query()
            ->when($search, fn ($query) => $query->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"))
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.user.index', compact('users', 'search'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()->route('admin.user.index')->with('success', 'Data admin berhasil ditambahkan.');
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.user.index')->with('success', 'Data admin berhasil diperbarui.');
    }

    public function destroy(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        
        if (auth()->id() == $user->id) {
            return redirect()->route('admin.user.index')->with('error', 'Tidak dapat menghapus akun yang sedang digunakan.');
        }

        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'Data admin berhasil dihapus.');
    }
}
