<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MainController extends Controller
{
  public function index()
  {
    // load user's notes
    $id = session('user.id');
    $user = User::find($id)->toArray();
    $notes = User::find($id)->notes()->get()->toArray();


    echo '<pre>';
    print_r($user);
    print_r($notes);

    return view('home');
  }

  public function newNote()
  {
    echo 'Im creating a new note';
  }
}
