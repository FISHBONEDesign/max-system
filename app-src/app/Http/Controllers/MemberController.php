<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminProject;
use App\Models\Member;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MemberController extends Controller
{
     /**
     * 顯示project 頁面
     *
     * @param Project $project
     * @return void
     */
    public function index(Project $project)
    {
        $this->authorize('view', $project);
        return view('admin.projects.folders.show', compact('project'));
    }

    /**
     * 新增project member 頁面
     *
     * @param Project $project
     * @return void
     */
    public function create(Project $project)
    {
        // $this->authorize('update', $project);
        $member = new AdminProject();
        $member->project_id = $project->id;
        dd($member->project_id);
        return view('projectmembers.create', compact('member'));
    }

    /**
     * 顯示編輯member 權限的頁面
     *
     * @param AdminProject $adminProject
     * @return void
     */
    public function edit(Project $project, AdminProject $adminProject)
    {
        // $this->authorize('update', $group);
        $member = $adminProject;
        return view('projectmembers.edit', compact('member'));
    }

    /**
     * 驗證新增的成員，並將資料存入資料庫
     *
     * @param Project $project
     * @param Request $request
     * @return void
     */
    public function store(Project $project, Request $request)
    {
        // $this->authorize('update', $project);
        $data = $request->validate([
            'admin_id' => 'required|int|exists:admins,id'
        ]);
        $old_member = $project->admin()->where($data)->first();
        if ($old_member) {
            throw ValidationException::withMessages([
                'admin_id' => 'The User has already been added.'
            ]);
        }
        $data['edit'] = $request->has('editable');
        $project->adminProject()->create($data);
        return redirect()->route('admin.projects.show', $project);
    }

    /**
     * 更新member 的權限
     *
     * @param Project $project
     * @param AdminProject $adminProject
     * @return void
     */
    public function update(Project $project, AdminProject $adminProject)
    {
        // $this->authorize('update', $project);
        $adminProject->update([
            'edit' => request()->has('editable')
        ]);
        return redirect()->route('admin.projects.show', $project);
    }

    /**
     * 移除project member
     *
     * @param Project $project
     * @param AdminProject $adminProject
     * @return void
     */
    public function destroy(Project $project, AdminProject $adminProject)
    {
        // $this->authorize('update', $project);
        $adminProject->delete();
        return redirect()->route('admin.projects.show', $project);
    }
}
