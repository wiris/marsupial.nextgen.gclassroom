<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if (auth()->user()->role != 'admin') {
            abort(403);
        }

        return Inertia::render('User', $user->only('id', 'name', 'email', 'role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if (auth()->user()->role != 'admin') {
            abort(403);
        }
        return Inertia::render('EditUser', $user->only('id', 'name', 'email', 'role'));
    }

    public function editByEmail(Request $request)
    {
        $email = $request->input('email');
        $user = User::query()->where('email', '=', $email)->first();

        if (!$user) {
            abort(404);
        }

        return to_route('users.edit', ['user' => $user->id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if (auth()->user()->role != 'admin') {
            abort(403);
        }

        $user->role = $request->input('role');
        $user->save();

        return to_route('admin');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
