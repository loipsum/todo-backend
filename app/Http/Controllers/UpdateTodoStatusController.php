<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Exception;
use Illuminate\Http\Request;
use Validator;

class UpdateTodoStatusController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Todo $todo)
    {
        try {
            if ($request->user()->id != $todo->user_id) {
                throw new Exception('Cannot access other user\'s todo item', 403);
            }

            $validator = Validator::make(
                $request->all(),
                [
                    'status' => 'required|in:done,pending'
                ],
                [
                    'status.in' => 'Invalid status, status must be one of: done,pending'
                ]
            );

            if ($validator->fails()) {
                return response(
                    ['message' => array_values($validator->getMessageBag()->getMessages())],
                    422
                );
            }

            $todo->update(
                ['status' => $request->status]
            );

            return response(['message' => 'Todo item status updated successfully']);
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
