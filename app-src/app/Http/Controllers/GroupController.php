<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::all();

        return view('groups.index', compact('groups'));
    }

    public function create()
    {
        $models = $this->list_models();
        $group = new Group();
        return view('groups.create', compact('group', 'models'));
    }

    public function edit(Group $group)
    {
        $models = $this->list_models();
        return view('groups.edit', compact('group', 'models'));
    }

    public function show(Group $group)
    {
        return view('groups.show', compact('group'));
    }

    public function store(Request $request)
    {
        Group::create($this->validate_model($request));
        return redirect()->route('admin.groups.index');
    }

    public function update(Group $group)
    {
        $group->update($this->validate_model(request()));
        return redirect()->route('admin.groups.index');
    }

    public function destroy(Group $group)
    {
        $group->delete();
        return redirect()->route('admin.groups.index');
    }

    private function list_models()
    {
        $result = scandir(app_path('Models'));
        unset($result[0], $result[1]);
        return collect($result)->map(function ($model_file) {
            $namespace = 'App\\Models';
            $fileinfo = pathinfo($model_file);
            return (object) [
                'label' => $fileinfo['filename'],
                'value' => $namespace . '\\' . $fileinfo['filename']
            ];
        });
    }

    private function validate_model(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'model_name' => 'required',
            'model_id' => 'required'
        ]);
        if (class_exists($request->model_name)) $model  = $request->model_name;
        else {
            throw ValidationException::withMessages([
                'model_name' => 'The Model Name was invalid.'
            ]);
        }
        $instance = $model::find($request->model_id);
        $group = Group::where([
            'model_name' => $request->model_name,
            'model_id' => $request->model_id
        ])->first();
        if (!$instance || $group) {
            throw ValidationException::withMessages([
                'model_id' => 'The Model Object was invalid or duplicate.'
            ]);
        }
        return $data;
    }
}
