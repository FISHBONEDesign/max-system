<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MemberController extends Controller
{
    public function index(Group $group)
    {
        $this->authorize('view', $group);
        return view('groups.members.index', compact('group'));
    }

    public function create(Group $group)
    {
        $this->authorize('update', $group);
        $member = new Member();
        $member->group_id = $group->id;
        return view('groups.members.create', compact('member'));
    }

    public function edit(Group $group, Member $member)
    {
        $this->authorize('update', $group);
        return view('groups.members.edit', compact('member'));
    }

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
        return redirect()->route('admin.groups.show', $group);
    }

    public function update(Group $group, Member $member)
    {
        $this->authorize('update', $group);
        $member->update([
            'edit' => request()->has('editable')
        ]);
        return redirect()->route('admin.groups.show', $group);
    }

    public function destroy(Group $group, Member $member)
    {
        $this->authorize('update', $group);
        $member->delete();
        return redirect()->route('admin.groups.show', $group);
    }
}
