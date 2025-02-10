<?php
namespace App\Http\Controllers;

use App\Http\Requests\changePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
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