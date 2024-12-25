<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Http\Request;


class MainController extends Controller
{
  public function index()
  {
    // load user's notes
    $id = session('user.id');
    $notes = User::find($id)->notes()->get()->toArray();

    return view('home', compact('notes'));
  }

  public function newNote()
  {
    // show newNote view
    return view('new_note');
  }

  public function newNoteSubmit(Request $request)
  {

    // validate request
    $request->validate(
      [
        'text_title' => 'required|min:3|max:200',
        'text_note' => 'required|min:3|max:3000'
      ],
      // Messages errors
      [
        'text_title.required' => 'Title is required.',
        'text_title.min' => 'Title must have more than :min characters.',
        'text_title.max' => 'Title must have no more than :max characters.',
        'text_note.required' => 'Note is required.',
        'text_note.min' => 'Note must have more than :min characters.',
        'text_note.max' => 'Note must have no more than :max characters.',
      ]
    );

    // get user id
    $id = session('user.id');
    // create new note
    $note = new Note();
    $note->user_id = $id;
    $note->title = $request->text_title;
    $note->text = $request->text_note;
    $note->save();

    // redirect to home
    return redirect()->route('home');
  }


  public function editNote($id)
  {
    $id = Operations::decryptId($id);
  }


  public function deleteNote($id)
  {
    $id = Operations::decryptId($id);
  }
}
