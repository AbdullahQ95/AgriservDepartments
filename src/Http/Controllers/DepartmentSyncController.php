<?php

namespace Agriserv\Departments\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DepartmentSyncController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'key' => ['required', 'string', 'max:255'],
            'manager_id' => ['required', 'string'],
        ]);

        $updated = $this->sync($validated['key'], $validated['manager_id']);

        if (! $updated) {
            return response()->json(['message' => 'Department not found.'], 404);
        }

        return response()->json(['message' => 'Department synced successfully.']);
    }

    protected function sync(string $key, string $managerId): bool
    {
        return false;
    }
}
