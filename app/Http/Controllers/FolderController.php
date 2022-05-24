<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class FolderController extends Controller
{
    /**
     * 顯示專案頁面
     *
     * @param Project $project
     * @param Folder|null $folder
     * @return void
     */
    public function show(Project $project, Folder $folder = null)
    {
        $this->authorize('view', $project);
        if ($folder === null) {
            $folder = new Folder([
                'project_id' => $project->id,
                'name' => $project->name
            ]);
            $folder->id = 0;
        }
        return view('projects.folders.show', [
            'project' => $project,
            'folder' => $folder
        ]);
    }

    /**
     * 建立專案資料夾
     *
     * @param Project $project
     * @param Folder|null $folder
     * @return void
     */
    public function create(Project $project, Folder $folder = null)
    {
        $this->authorize('update', $project);
        $folder = new Folder([
            'project_id' => $project->id,
            'parent_id' => $folder ? $folder->id : 0
        ]);
        return view('projects.folders.create', ['folder' => $folder]);
    }

    /**
     * 儲存建立專案資料夾
     *
     * @param Project $project
     * @param Folder|null $folder
     * @return void
     */
    public function store(Project $project, Folder $folder = null)
    {
        $this->authorize('update', $project);
        $router_parameters = [$project];
        $data = request()->validate([
            'name' => 'required'
        ]);
        $new_folders = collect(explode('/', $data['name']));
        $absolute = $new_folders[0] === '';
        if ($absolute || $folder === null) {
            $folder = new Folder();
            $folder->project_id = $project->id;
            $folder->id = 0;
        }
        foreach ($new_folders as $index => $new_folder) {
            if ($absolute && $index === 0 || $new_folder === '') continue;
            $new_folder_data = [
                'project_id' => $folder->project_id,
                'parent_id' => $folder->id,
                'name' => $new_folder
            ];
            $exists_folder = Folder::where($new_folder_data)->first();
            if ($exists_folder) {
                if ($index === $new_folders->count() - 1) {
                    throw ValidationException::withMessages([
                        'name' => 'folder already exist.'
                    ]);
                } else {
                    $folder = $exists_folder;
                }
            } else {
                $new_folder = $project->folders()->create($new_folder_data);
                $folder = $new_folder;
            }
        }

        $router_parameters[] = $folder;
        return redirect()->route('admin.projects.folders.show', $router_parameters);
    }

    /**
     * 更新資料夾
     *
     * @param Project $project
     * @param Folder $folder
     * @return void
     */
    public function edit(Project $project, Folder $folder)
    {
        $this->authorize('update', $project);
        return view('projects.folders.edit', compact('folder'));
    }

    /**
     * 儲存更新專案資料夾
     *
     * @param Project $project
     * @param Folder $folder
     * @return void
     */
    public function update(Project $project, Folder $folder)
    {
        $this->authorize('update', $project);
        $data = request()->validate(['name' => 'required']);
        $data['project_id'] = $folder->project_id;
        $data['parent_id'] = $folder->parent_id;
        preg_match('/[\/]/', $data['name'], $matches);
        $invalid_name = (bool) count($matches);
        if ($invalid_name) {
            throw ValidationException::withMessages([
                'name' => 'folder\'s name can\'t has \'/\'.'
            ]);
        }
        $exists = (bool) Folder::where('id', '!=', $folder->id)->where($data)->get()->count();
        if ($exists) {
            throw ValidationException::withMessages([
                'name' => 'folder already exist.'
            ]);
        } else {
            $folder->update($data);
        }
        return redirect()->route('admin.projects.folders.show', [$folder->project, $folder->parent]);
    }

    /**
     * 刪除專案資料夾
     *
     * @param Project $project
     * @param Folder $folder
     * @return void
     */
    public function destroy(Project $project, Folder $folder)
    {
        $this->authorize('update', $project);
        $route = route('admin.projects.folders.show', $folder->project, $folder->parent);
        $this->deleteFolder($folder);
        return redirect($route);
    }

    /**
     * 尋訪要刪除的資料夾
     *
     * @param Folder $folder
     * @return void
     */
    private function deleteFolder(Folder $folder)
    {
        foreach ($folder->folders as $sub_folder) {
            $this->deleteFolder($sub_folder);
        }
        return $folder->delete();
    }
}
