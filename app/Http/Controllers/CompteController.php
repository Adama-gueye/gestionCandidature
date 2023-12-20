<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *      title="Compte API",
 *      version="1.0.0",
 *      description="API Documentation for managing user accounts"
 * )
 */

class CompteController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Register a new user account",
     *     tags={"Compte"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nom", type="string", example="John"),
     *             @OA\Property(property="prenom", type="string", example="Doe"),
     *             @OA\Property(property="tel", type="string", example="123456789"),
     *             @OA\Property(property="age", type="integer", example=25),
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User account created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", description="Account created successfully"),
     *             @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
     *         )
     *     ),
     *     @OA\Response(response=401, description="Validation Error")
     * )
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'tel' => 'required|string',
            'age' => 'required|integer',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 401);
        }

        $user = new User();
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->tel = $request->tel;
        $user->age = $request->age;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = "candidat";
        $user->save();

        return response()->json(['message' => 'Account created successfully', 'user' => $user], 201);
    }
}
