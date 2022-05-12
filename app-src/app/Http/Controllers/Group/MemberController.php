<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MemberController extends Controller
{
    /**
     * 顯示group 頁面
     *
     * @param Group $group
     * @return void
     */
    public function index(Group $group)
    {
        $this->authorize('view', $group);
        return view('groups.members.index', compact('group'));
    }

    /**
     * 新增project member
     *
     * @param Group $group
     * @return void
     */
    public function create(Group $group)
    {
        $this->authorize('update', $group);
        $member = new Member();
        $member->group_id = $group->id;
        return view('groups.members.create', compact('member'));
    }

    /**
     * 顯示編輯member 權限的頁面
     *
     * @param Group $group
     * @param Member $member
     * @return void
     */
    public function edit(Group $group, Member $member)
    {
        $this->authorize('update', $group);
        return view('groups.members.edit', compact('member'));
    }

    /**
     * 驗證新增的成員，並將資料存入資料庫
     *
     * @param Group $group
     * @param Request $request
     * @return void
     */
    public function store(Group $group, Request $request)
    {
        $this->authorize('update', $group);
        $data = $request->validate([
            'admin_id' => 'required|int|exists:admins,id'
        ]);
        $old_member = $group->members()->where($data)->first();
        if ($old_member) {
            throw ValidationException::withMessages([
                'admin_id' => 'The User has already been added.'
            ]);
        }
        $data['edit'] = $request->has('editable');
        $group->members()->create($data);
        return redirect()->route('admin.projects.show', $group);
    }

    /**
     * 更新member 的權限
     *
     * @param Group $group
     * @param Member $member
     * @return void
     */
    public function update(Group $group, Member $member)
    {
        $this->authorize('update', $group);
        $member->update([
            'edit' => request()->has('editable')
        ]);
        return redirect()->route('admin.projects.show', $group);
    }

    /**
     * 移除project member
     *
     * @param Group $group
     * @param Member $member
     * @return void
     */
    public function destroy(Group $group, Member $member)
    {
        $this->authorize('update', $group);
        $member->delete();
        return redirect()->route('admin.projects.show', $group);
    }
}
