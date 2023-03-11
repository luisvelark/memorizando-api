<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

   
    public function userProfile(Request $request)
    {
        return response()->json([
            "message" => "usuario ok",
            "userData"=>auth()->user()
        ],Response::HTTP_OK);
    }

}
