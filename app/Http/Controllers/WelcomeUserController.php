<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeUserController extends Controller
{
    /*public function __invoke($name, $nickname = null)
    {
        $name = ucfirst($name);
        if ($nickname){
            return "Bienvenido {$name}, tu apodo es {$nickname}";
        } else {
            return "Bienvenido {$name}";
        }
    }*/

    public function with_nickname($name, $nickname)
    {
        $name = ucfirst($name);
        return "Bienvenido {$name}, tu apodo es {$nickname}";
    }

    public function without_nickname($name)
    {
        $name = ucfirst($name);
        return "Bienvenido {$name}";
    }
}
