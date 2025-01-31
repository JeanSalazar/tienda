<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use Illuminate\Http\Request;

class PermisoControlador extends Controller
{
    public function index()
    {
        return response()->json(Permiso::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:permissions']);
        $permission = Permiso::create(['name' => $request->name]);
        return response()->json($permission, 201);
    }

    public function show($id)
    {
        return response()->json(Permiso::findOrFail($id), 200);
    }

    public function update(Request $request, $id)
    {
        $permission = Permiso::findOrFail($id);
        $permission->update($request->only('name'));
        return response()->json($permission, 200);
    }

    public function destroy($id)
    {
        Permiso::findOrFail($id)->delete();
        return response()->json(['message' => 'Permission deleted'], 200);
    }
}
