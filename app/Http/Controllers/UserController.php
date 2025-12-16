<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $this->authorize('viewAny', User::class);

        return Inertia::render('Admin/Users/Index', [
            'users' => User::select('id', 'name', 'email', 'role')
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function updateRole(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $request->validate([
            'role' => ['required', 'in:admin,editor,viewer'],
        ]);

        $user->update([
            'role' => $request->role,
        ]);

        return back()->with('success', 'Rol actualizado');
    }
}
