<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CandidateController extends Controller {

    public function index() {
        return response()->json(['candidates' => []]);
    }

    public function add(Request $request) {
        return response()->json(['message' => 'Candidate added']);
    }

    public function delete($index) {
        return response()->json(['message' => 'Candidate deleted']);
    }

    public function update($id){
        return response()->json(['message' => 'Candidate updated']);
    }
}
