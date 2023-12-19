<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompteController extends Controller
{

public function register(Request $request)
    {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
                'nom' => 'required',
                'prenom' => 'required',
                'tel' => 'required',
                'age' => 'required',

            ]);
       
            if($validator->fails()){
    
                return  response()->json(['message' => $validator->errors()],401);
            }
        $user = new User();
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->tel = $request->tel;
        $user->age = $request->age;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->role = "candidat";
        $user->save();
        return response()->json("compte creer avec succes : $user",201);
        
    }
}