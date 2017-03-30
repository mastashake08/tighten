<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JsonEntry;
class JsonController extends Controller
{
    //

    public function store(Request $request){
    //dd($request->input('json.data'));
      $this->validate($request,[
        'json' => 'required'
      ]);
      $accounts = collect($request->input('json.data'));
      $emails = $accounts->pluck('email');
      $sorted = [];
      foreach($accounts->sortByDesc('age') as $s){
        $s = array_add($s,'name',"{$s["first_name"]} {$s["last_name"]}");
        $sorted[] = $s;
      }
      $entry = JsonEntry::Create([
        'entry' => json_encode([
          'emails' => $emails,
          'sorted' => $sorted
        ])
      ]);
      return $entry;

    }
}
