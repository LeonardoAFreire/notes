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
    $notes = User::find($id)
      ->notes()
      ->whereNull('deleted_at')
      ->get()->toArray();

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

    // load note
    $note = Note::find($id);

    // show edit note view
    return view('edit_note', compact('note'));
  }

  public function editNoteSubmit(Request $request)
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

    // check if note id exists
    if ($request->note_id === null) {
      return redirect()->route('home');
    }
    // decrypt note id
    $id = Operations::decryptId($request->note_id);

    // load note
    $note = Note::find($id);

    // update note
    $note->title = $request->text_title;
    $note->text = $request->text_note;
    $note->save();

    // redirect to home
    return redirect()->route('home');
  }


  public function deleteNote($id)
  {
    $id = Operations::decryptId($id);

    // load note
    $note = Note::find($id);

    // show delete note confirmation

    return view('delete_note', compact('note'));
  }


  public function deleteNoteConfirm($id)
  {
    // check if id is encrypted
    $id = Operations::decryptId($id);

    // load note
    $note = Note::find($id);

    // Soft Delete using use SoftDelete (property in model)
    // With force delete can remove the register.
    $note->delete();

    // return to home
    return redirect()->route('home');
  }
}
