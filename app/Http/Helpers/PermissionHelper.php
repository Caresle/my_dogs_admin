<?php

namespace App\Http\Helpers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RoleHasPermission;

final class PermissionHelper
{
    const ADMIN = 1;

    // User
    const GET_USER = 2;
    const POST_USER = 3;
    const PUT_USER = 4;
    const DELETE_USER = 5;

    // Role
    const GET_ROLE = 6;
    const POST_ROLE = 7;
    const PUT_ROLE = 8;
    const DELETE_ROLE = 9;

    // DOG
    const GET_DOG = 10;
    const POST_DOG = 11;
    const PUT_DOG = 12;
    const DELETE_DOG = 13;

    // DOG
    const GET_DOG_TYPE = 14;
    const POST_DOG_TYPE = 15;
    const PUT_DOG_TYPE = 16;
    const DELETE_DOG_TYPE = 17;

    public static function hasRight(Role $role, int $right = -1) : bool
    {
        if (!isset($role) || $right == -1) return false;

        $rights_role = RoleHasPermission::where('role_id', '=', $role->id)->get();

        // Get the permission linked with the rol
        $rights = [];
        foreach ($rights_role as $right_to_get) {
            array_push($rights, $right_to_get->permission_id);
        }

        if (!in_array($right, $rights) && !in_array(PermissionHelper::ADMIN, $rights))
            return false;

        return true;
    }
}
