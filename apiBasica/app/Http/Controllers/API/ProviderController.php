<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProviderController extends Controller
{
    public function index()
    {
        $providers = Provider::with('products')->get();
        return response()->json([
            'success' => true,
            'data' => $providers
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:providers',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $provider = Provider::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $provider
        ], 201);
    }

    public function show($id)
    {
        $provider = Provider::with('products')->find($id);
        
        if (!$provider) {
            return response()->json([
                'success' => false,
                'message' => 'Proveedor no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $provider
        ]);
    }

    public function update(Request $request, $id)
    {
        $provider = Provider::find($id);

        if (!$provider) {
            return response()->json([
                'success' => false,
                'message' => 'Proveedor no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:providers,email,' . $id,
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $provider->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $provider
        ]);
    }

    public function destroy($id)
    {
        $provider = Provider::find($id);

        if (!$provider) {
            return response()->json([
                'success' => false,
                'message' => 'Proveedor no encontrado'
            ], 404);
        }

        $provider->delete();

        return response()->json([
            'success' => true,
            'message' => 'Proveedor eliminado correctamente'
        ]);
    }
}