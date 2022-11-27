<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    public function store(Request $request)
    {
        $fields = $request->validate([
            'role_name' => 'required|string|unique:roles,role_name'
        ]);

        $role = Role::create($fields);

        $response = [
            'role' => $role,
            'message' => 'Role Created Successfully'
        ];
        return response($response, 201);
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        if ($role)
            $role->delete();
        else {
            $response = [
                'message' => 'Role not found'
            ];
        }
        return response($response, 400);
        return response()->json('Role Deleted Successfully');
    }
}
