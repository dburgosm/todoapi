<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

	private $rules = [
		'title' => 'required',
	    'description' => 'required',
        'done' => 'required|boolean'
	];

	public function index(Request $request)
	{
		return $this->sendResponse($request, Task::all(), 200);
	}
    
    public function show(Request $request, $id)
    {
        $code = (($data = Task::find($id)) == null) ? 404:200;

		return $this->sendResponse($request, $data, $code);

    }

    public function store(Request $request)
    {
    	$this->validate($request, $this->rules);
    	
    	$data = new Task($request->all());
		$data->save();

		return $this->sendResponse($request, $data, 201);
    }

    public function update(Request $request, $id)
    {
    	$code = 404;
    	


    	$this->validate($request, $this->rules);
    	
    	$data = Task::find($id);

    	if($data != null){
    		$data->title = $request->get('title');
    		$data->description = $request->get('description');
    		$data->done = $request->get('done');
    		$data->save();
    		$code = 200;
    	}

    	return $this->sendResponse($request, $data, $code);
    }

    public function destroy(Request $request, $id)
    {
    	$code = 404;

    	$data = Task::find($id);

    	if($data != null){
    		$data->delete();
    		$code = 204;
    	}

    	return $this->sendResponse($request, null, $code);
    }

}