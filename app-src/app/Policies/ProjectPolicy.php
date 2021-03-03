<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\Admin as User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability = null)
    {
        if ($user->isSupervisor()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any projects.
     *
     * @param  \App\Models\Admin  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the project.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Project  $project
     * @return mixed
     */
    public function view(User $user, Project $project)
    {
        return $project->group->hasAdmin($user);
    }

    /**
     * Determine whether the user can create projects.
     *
     * @param  \App\Models\Admin  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the project.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Project  $project
     * @return mixed
     */
    public function update(User $user, Project $project)
    {
        return $project->group->canAdminEdit($user);
    }

    /**
     * Determine whether the user can delete the project.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Project  $project
     * @return mixed
     */
    public function delete(User $user, Project $project)
    {
        return $project->group->canAdminEdit($user);
    }

    /**
     * Determine whether the user can restore the project.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Project  $project
     * @return mixed
     */
    public function restore(User $user, Project $project)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the project.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Project  $project
     * @return mixed
     */
    public function forceDelete(User $user, Project $project)
    {
        //
    }
}
