<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
  public function index()
  {
    // load user's notes

    return view('home');
  }

  public function newNote()
  {
    echo 'Im creating a new note';
  }
}
