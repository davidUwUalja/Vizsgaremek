<?php
namespace App\Http\Controllers;

use App\Http\Requests\changePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;



class UserController extends Controller
{
    public function index(){
        Gate::authorize('list-users');

        return UserResource::collection(User::all());
    }
    public function profile(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }

    public function update(UpdateUserRequest $request): JsonResponse
    {
        $user = $request->user();
        $user->update($request->validated());

        return response()->json(['message' => 'Profil sikeresen frissítve', 'user' => $user]);
    }

    public function changePassword(changePasswordRequest $request): JsonResponse
    {

        $user = $request->user();

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'A régi jelszó nem megfelelő!'], 400);
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        return response()->json(['message' => 'Jelszó sikeresen módosítva']);
    }
}