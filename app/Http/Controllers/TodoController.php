<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Models\Todo;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    const PAGESIZE = 3;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $todos = Auth::user()->todos()->simplePaginate(self::PAGESIZE);

        return response()->json($todos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTodoRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTodoRequest $request)
    {
        $params = $request->all();

        $params['user_id'] = Auth::user()->id;
        $todo = Todo::create($params);

        return response()->json($todo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\JsonResponse
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function destroy(Todo $todo)
    {
        $this->_abortIfNoAccess($todo);

        return response()->json([
            'deleted' => Todo::destroy($todo->id)
        ]);
    }

    /**
     * Mark as Complete the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\JsonResponse
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function complete(Todo $todo)
    {
        $this->_abortIfNoAccess($todo);

        $todo->status = Todo::STATUS_COMPLETE;
        $todo->save();

        return response()->json($todo);
    }

    /**
     * Mark as Incomplete the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\JsonResponse
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function incomplete(Todo $todo)
    {
        $this->_abortIfNoAccess($todo);

        $todo->status = Todo::STATUS_INCOMPLETE;
        $todo->save();

        return response()->json($todo);
    }
    
    /**
     * Check if user has access to todo. If doesn't return 401 error
     * _abortIfNoAccess
     *
     * @param  mixed $todo
     * @return void
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    private function _abortIfNoAccess(Todo $todo)
    {
        if ($todo->user->id != Auth::user()->id) {
            abort(401, 'Unauthenticated.');
        }
    }
}
