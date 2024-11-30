<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserControlerApi extends Controller

{
    public function getUserId()
    {
        // Obtener el ID del usuario autenticado usando Spatie y Laravel
        $userId = Auth::id();
        return response()->json(['userId' => $userId]);
    }

    public function getFullName()
    {
        // Obtener el ID del usuario autenticado usando Spatie y Laravel
        return response()->json(['fullName' =>  Auth::user()->name]);
    }

}
