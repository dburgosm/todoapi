<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

	private $rules = [
		'title' => 'required'
	];

    private $rulesTask = [
        'title' => 'required',
        'description' => 'required',
        'done' => 'required|boolean'
    ];

	public function index(Request $request)
	{
		return $this->sendResponse($request, Project::all(), 200);
	}
    
    public function show(Request $request, $id)
    {
        $code = (($data = Project::find($id)) == null) ? 404:200;

		return $this->sendResponse($request, $data, $code);

    }

    public function store(Request $request)
    {
    	$this->validate($request, $this->rules);
    	
    	$data = new Project($request->all());
		$data->save();

		return $this->sendResponse($request, $data, 201);
    }

    public function update(Request $request, $id)
    {
    	$code = 404;
    	


    	$this->validate($request, $this->rules);
    	
    	$data = Project::find($id);

    	if($data != null){
    		$data->title = $request->get('title');
    		$data->save();
    		$code = 200;
    	}

    	return $this->sendResponse($request, $data, $code);
    }

    public function destroy(Request $request, $id)
    {
    	$code = 404;

    	$data = Project::find($id);

    	if($data != null){
    		$data->delete();
    		$code = 204;
    	}

    	return $this->sendResponse($request, null, $code);
    }

    public function addTask(Request $request, $id)
    {

        $this->validate($request, $rulesTask);

        $code = (($data = Project::find($id)) == null) ? 404:200;

        $task = new Task();
        $task->title = $request->get('title');
        $task->description = $request->get('description');
        $task->done = $request->get('done');

        $project = $data->tasks()->save($task);

        return $this->sendResponse($request, $data, $code);

    }

}