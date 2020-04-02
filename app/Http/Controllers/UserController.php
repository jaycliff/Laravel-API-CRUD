<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Cookie;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $per_page = $request->input('per_page');
        if (empty($per_page)) {
            $cookie_value = $request->cookie('per_page');
            $per_page = !empty($cookie_value) ? $cookie_value : 10;
        }
        Cookie::queue('per_page', $per_page);
        return response()->json(User::paginate($per_page), 201);
        // return User::paginate($per_page);
        // return $cookie_value;
        // return User::get();
    }

    public function users(Request $request)
    {
        $per_page = $request->input('per_page');
        if (empty($per_page)) {
            $cookie_value = $request->cookie('per_page');
            $per_page = !empty($cookie_value) ? $cookie_value : 10;
        }
        Cookie::queue('per_page', $per_page);
        return response()->json(User::paginate($per_page), 201);
        // return User::paginate($per_page);
        // return $cookie_value;
        // return User::get();
    }

    // Route should be outside the sanctum middleware!!!
    public function login(Request $request) {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'error' => 'Invalid login',
                'message' => 'Your login credentials did not match any records.'
            ], 404);
        }
        $token = $user->createToken('app-access')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function revoke(Request $request) {
        $user = $request->user();
        $data = $request->post();
        if (!empty($data['id'])) {
            $user->tokens()->where('id', $data['id'])->delete();
            return response()->json([
                'message' => 'Token at #' . $data['id'] . ' has been revoked.'
            ], 201);
        }
        $user->tokens()->delete();
        return response()->json([
            'message' => 'All tokens have been revoked.',
            'user' => $user
        ], 201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    private $fields = [
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required',
        'role' => 'nullable',
        'information' => 'nullable'
    ];

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->fields);
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->role = $data['role'] ?? 'member';
        $user->information = $data['information'] ?? '';
        $user->save();
        return response()->json($user, 201);
        // return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return response()->json($user, 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return response()->json($user, 201);
        // return $user;
    }

    private function assignIfExists($object, $field, $value) {
        if (!empty($value)) {
            $trimmed = trim($value);
            if (!empty($trimmed)) {
                $object[$field] = $trimmed;
                return true;
            }
        }
        return false;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $data = $request->post();
        $fields = $this->fields;
        foreach ($fields as $name => $value) {
            if ($name === 'email' && !empty($data['email'])) {
                $validated_data = $request->validate([
                    'email' => 'email'
                ]);
                $user->email = $validated_data['email'];
            } else {
                $this->assignIfExists($user, $name, $data[$name] ?? NULL);
            }
        }
        $user->save();
        return response()->json($user, 201);
        // return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json($user, 201);
        // return $user;
    }
}
