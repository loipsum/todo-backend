<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Validator;

class UserTodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = Todo::where('user_id', '=', request()->user()->id)
            ->orderBy('status', 'desc');
        return response()->json($todos->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        // try {
        //     $todos = Todo::where('user_id', $user->id);
        //     return response()->json($todos->get());
        // } catch (\Exception $e) {
        //     return response($e->getMessage(), $e->getCode());
        // }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        try {
            $this->check_user($request->user()->id, $todo->user_id);

            $validator = Validator::make(
                $request->all(),
                [
                    'status' => 'required|in:done,pending'
                ],
                [
                    'status.in' => 'Invalid status, status can be one of: done,pending'
                ]
            );

            if ($validator->fails()) {
                return response(
                    ['message' => array_values($validator->getMessageBag()->getMessages())],
                    422
                );
            }

            $todo->update(['status' => $request->status]);
            return response('Todo item updated successfully');
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        try {
            $this->check_user(request()->user()->id, $todo->user_id);
            $todo->delete();
            return response('Todo item deleted successfully');
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 400);
        }
    }

    /**     
     * Check if the user is manipulating other user's todo item
     */
    public static function check_user(int $user_id, int $todo_user_id)
    {
        if ($user_id != $todo_user_id) {
            throw new Exception("Cannot access other user's todo item", 403);
        }
    }
}
