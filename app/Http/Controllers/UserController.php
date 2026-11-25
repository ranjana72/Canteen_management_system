<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * index() — Show a list of all users
     * Route: GET /users
     * View:  resources/views/users/index.blade.php
     */
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * create() — Show the form to register a new user
     * Route: GET /users/create
     * View:  resources/views/users/create.blade.php
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * store() — Save a new user to the database
     * Route: POST /users
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|max:150|unique:users,email',
            'password' => 'required|string|min:8|confirmed',   // needs password_confirmation field
            'role'     => 'required|in:admin,student',
        ]);

        // Password is auto-hashed by the User model cast
        User::create($validated);

        return redirect()->route('admin.users.index')
                         ->with('success', 'User created successfully.');
    }

    /**
     * show() — Show a single user's profile/details
     * Route: GET /users/{user}
     * View:  resources/views/users/show.blade.php
     */
    public function show(User $user)
    {
        // Eager load orders and payments for this user
        $user->load(['orders', 'payments']);

        return view('admin.users.show', compact('user'));
    }

    /**
     * edit() — Show the form to edit an existing user
     * Route: GET /users/{user}/edit
     * View:  resources/views/users/edit.blade.php
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * update() — Save the updated user data to the database
     * Route: PUT /users/{user}
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email,' . $user->id,  // ignore current user's own email
            'role'  => 'required|in:admin,student',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')
                         ->with('success', 'User updated successfully.');
    }

    /**
     * destroy() — Delete a user from the database
     * Route: DELETE /users/{user}
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'User deleted successfully.');
    }
}