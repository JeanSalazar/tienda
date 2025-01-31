<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolControlador extends Controller
{
    
    public function index()
    {
        return response()->json(Rol::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles']);
        $role = Rol::create(['name' => $request->name]);
        return response()->json($role, 201);
    }

    public function show($id)
    {
        return response()->json(Rol::findOrFail($id), 200);
    }

    public function update(Request $request, $id)
    {
        $role = Rol::findOrFail($id);
        $role->update($request->only('name'));
        return response()->json($role, 200);
    }

    public function destroy($id)
    {
        Rol::findOrFail($id)->delete();
        return response()->json(['message' => 'Rol eliminado'], 200);
    }
}
