<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    function __invoke()
    {
        //dd('Message from WelcomeController@index');
        //dump('Message from WelcomeController@index');

        // Business logic can be added here if needed

        return view('welcome');
    }
}
