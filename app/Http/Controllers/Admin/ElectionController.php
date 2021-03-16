<?php

namespace App\Http\Controllers\Admin;

// models 
use App\Models\User;
use App\Models\Election;
use App\Models\ElectionPost;
use App\Models\ElectionCandidate;

// helpers
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DateTime;
use Illuminate\Support\Facades\Validator;

class ElectionController extends Controller
{
    // get all elections 
    public function getAllElection(Request $request)
    {
        return Election::all();
    }

    // paginate all elections 
    public function paginateElection(Request $request)
    {
        $page = isset($request->page) ? $request->page : 1;
        return Election::paginate(20, ["*"], 'page', $page);
    }

    // add new election
    public function addNewElection(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'date_and_time' => ['required'],
        ]);
        if ($validation->fails()) {
            return response()->json($validation->messages(), 401);
        } else {
            // return date($request->date_and_time);
            $election = Election::create([
                'name' => $request->name,
                'date_and_time' => (new DateTime($request->date_and_time))->format("Y-m-d H:i:s")
            ]);
            return $election;
        }
    }

    // edit election
    public function updateElection(Request $request, $id)
    {
        $check = Auth::user();
        if (!$check || $check['role'] != 'admin') {
            return response()->json([
                'message' => 'You are not authorized update!'
            ], 401);
        }

        $check = Election::where('id', $id)->first();
        if (!isset($check)) {
            return response()->json([
                'message' => 'Invalid Request!'
            ], 403);
        }
        return Election::where('id', $id)->update([
            'name' => $request->name,
            'date_and_time' => (new DateTime($request->date_and_time))->format("Y-m-d H:i:s"),
        ]);
    }

    // delete election
    public function deleteElection($id)
    {
        $check = Auth::user();
        if (!$check || $check['role'] != 'admin') {
            return response()->json([
                'message' => 'You are not authorized to delete!'
            ], 401);
        }

        $check = Election::where('id', $id)->count();
        if ($check == 0) {
            return response()->json([
                'message' => 'Invalid Request!'
            ], 403);
        }

        return Election::where('id', $id)->delete();
    }

    // get all election posts
    public function getAllElectionPosts(Request $request)
    {
        return ElectionPost::all();
    }

    // paginate election posts
    public function paginateElectionPosts(Request $request)
    {
        $page = isset($request->page) ? $request->page : 1;
        return ElectionPost::with('election')->paginate(20, ["*"], 'page', $page);
    }

    // add new election post
    public function addNewElectionPost(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'election_id' => ['required'],
        ]);
        if ($validation->fails()) {
            return response()->json($validation->messages(), 401);
        } else {
            // return date($request->date_and_time);
            $election = ElectionPost::create([
                'name' => $request->name,
                'election_id' => $request->election_id,
            ]);
            return $election;
        }
    }

    // edit election post
    public function updateElectionPost(Request $request, $id)
    {
        $check = Auth::user();
        if (!$check || $check['role'] != 'admin') {
            return response()->json([
                'message' => 'You are not authorized update!'
            ], 401);
        }

        $check = ElectionPost::where('id', $id)->first();
        if (!isset($check)) {
            return response()->json([
                'message' => 'Invalid Request!'
            ], 403);
        }
        return ElectionPost::where('id', $id)->update([
            'name' => $request->name,
            'election_id' => $request->election_id,
        ]);
    }

    // delete election post
    public function deleteElectionPost($id)
    {
        $check = Auth::user();
        if (!$check || $check['role'] != 'admin') {
            return response()->json([
                'message' => 'You are not authorized to delete!'
            ], 401);
        }

        $check = ElectionPost::where('id', $id)->count();
        if ($check == 0) {
            return response()->json([
                'message' => 'Invalid Request!'
            ], 403);
        }

        return Election::where('id', $id)->delete();
    }







    // paginate election candidates
    public function paginateElectionCandidates(Request $request)
    {
        $page = isset($request->page) ? $request->page : 1;
        return ElectionCandidate::with('user')
            ->with('election')
            ->with('post')
            ->paginate(20, ["*"], 'page', $page);
    }

    // add new election post
    public function addNewElectionCandidate(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'user_id' => ['required'],
            'election_id' => ['required'],
            'election_post_id' => ['required'],
            'symbol' => ['required'],
        ]);
        if ($validation->fails()) {
            return response()->json($validation->messages(), 401);
        } else {

            $election = ElectionCandidate::create([
                'symbol' => $request->symbol,
                'election_id' => $request->election_id,
                'user_id' => $request->user_id,
                'election_post_id' => $request->election_post_id,
            ]);
            return $election;
        }
    }

    // edit election post
    public function updateElectionCandidate(Request $request, $id)
    {
        $check = Auth::user();
        if (!$check || $check['role'] != 'admin') {
            return response()->json([
                'message' => 'You are not authorized update!'
            ], 401);
        }

        $check = ElectionCandidate::where('id', $id)->first();
        if (!isset($check)) {
            return response()->json([
                'message' => 'Invalid Request!'
            ], 403);
        }
        return ElectionCandidate::where('id', $id)->update([
            'symbol' => $request->symbol,
            'election_id' => $request->election_id,
            'user_id' => $request->user_id,
            'election_post_id' => $request->election_post_id,
        ]);
    }

    // delete election post
    public function deleteElectionCandidate($id)
    {
        $check = Auth::user();
        if (!$check || $check['role'] != 'admin') {
            return response()->json([
                'message' => 'You are not authorized to delete!'
            ], 401);
        }

        $check = ElectionCandidate::where('id', $id)->count();
        if ($check == 0) {
            return response()->json([
                'message' => 'Invalid Request!'
            ], 403);
        }

        return ElectionCandidate::where('id', $id)->delete();
    }


    // get non candidate user
    public function getNonCandidate()
    {
        $ids = ElectionCandidate::distinct()->pluck('user_id');
        return User::whereNotIn('id', $ids)
            ->where('role', 'alumni')
            ->get();
    }

    // get non alumni
    public function getAlumni()
    {
        return User::where('role', 'alumni')->get();
    }
}