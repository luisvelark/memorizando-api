<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','unique:users'],
            'password' => [
            'required',
            'confirmed',
            'string',
            'min:8',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'
        ],
            'email' => ['required','email','unique:users'],
            'birth_date'=>['required'],
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }
        // 'name' => [
        //     'required'=>"El usuario es obligatorio",'unique:users'=>'El usurio ya existe, elija otro'],
        // 'password' => [
        //     'required'=>'La contraseña es obligatoria'],
        // 'email' => [
        //     'required'=>'El correo es obligatorio','email'=>'Ingrese un email válido','unique:users'=>'Este correo ya extiste elija otro'],
        // 'birth_date'=>[
        //     'required'=>'Su fecha de nacimiento es obligatorio'],


        // alta del usuario
        $user = new User();
        $user->name = $request->name;
        $user->password=Hash::make($request->password);
        $user->email = $request->email;
        $user->birth_date = $request->birth_date;
        $user->save();

        //respuesta
        return response()->json([
            'success' => true,
            'data' => $user,
        ], Response::HTTP_CREATED);
        // return response($user,Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'password' => [ 'required'],
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'access' => false,
                'errors' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $credentials = $request->all();

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            $cookie = cookie('cookie_token', $token, 60 * 24);
            return response(["token"=>$token], Response::HTTP_OK)->withoutCookie($cookie);
        } else {
            return response(["message"=> "Credenciales inválidas"],Response::HTTP_UNAUTHORIZED);
        }
        // return response(["message"=> "Credenciales válidas"],Response::HTTP_CREATED);

        // if (Auth::attempt($credentials)) {
        //     $user = Auth::user();
        //     $token = $user->createToken("token")->plainTextToken;
        //     $cookie = cookie('cookie_token', $token, 60 * 24);
        //     return response(["token"=>$token], Response::HTTP_OK)->withoutCookie($cookie);
        // }
        // else{
        //     return response(["message"=> "Credenciales inválidas"],Response::HTTP_UNAUTHORIZED);
        // }

    }

    public function userProfile(Request $request)
    {
        if (auth()->check()) {
            return response()->json([
                "message" => "usuario ok",
                "userData"=>auth()->user()
            ],Response::HTTP_OK);
        } 
        else {
            return response(["message"=> "dame el token"],Response::HTTP_UNAUTHORIZED);
        }

        // $user = Auth::user();
        
        // if ($request->user()->tokenCan('user:get')) {
        //     return response()->json([
        //         'message' => 'Token de usuario válido.',
        //         'user' => $user
        //     ], 200);
        // } else {
        //     return response()->json([
        //         'message' => 'Token de usuario no válido.',
        //     ], 401);
        // }
        
    }

    public function logout(Request $request)
    {
        # code...
    }

    public function allUsers(Request $request)
    {
        # code...
    }
}

