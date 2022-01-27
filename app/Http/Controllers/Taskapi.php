<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Resources\TaskResource;
class Taskapi extends Controller
{
    public function index(){
        $data=Task::latest()->get();
        //$data=["msg"=>"Task Api Call"];
        return response(['tasks'=>TaskResource::collection($data),"message"=>"Fetched Successfully"]);
    }
    public function addtask(Request $request){
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'description'=>'required'
        ]);
        if($validator->fails()){
            return response(["errors"=>TaskResource::collection($validator->errors())]);
        }else{
            $task=new Task();
            $task->name=$request->name;
            $task->description=$request->description;
            if($task->save()){
                return response(["Tasks"=>new TaskResource($task)]);
            }else{
                return response(["msg"=>"Task Not Added"]);
            }
            
            
        }
    }
}
