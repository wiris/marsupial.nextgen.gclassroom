<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ToolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role != "admin") {
            return Inertia::render(
                'Forbidden'
            );
        }

        return Inertia::render('Tools', [
            'tools' => Tool::with('deployments')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role != "admin") {
            return Inertia::render(
                'Forbidden'
            );
        }

        return Inertia::render('EditTool');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->role != "admin") {
            return Inertia::render(
                'Forbidden'
            );
        }

        $tool = Tool::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'oidc_initiation_url' => $request->input('oidc_initiation_url'),
            'jwks_url' => $request->input('jwks_url'),
            'target_link_uri' => $request->input('target_link_uri'),
            'redirect_uris' => json_encode(explode(',', $request->input('redirect_uris'))),
            'deep_link_url' => $request->input('deep_link_url')
        ]);

        $tool->deployments()->create([]);

        return to_route('tools.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tool $tool)
    {
        if (auth()->user()->role != "admin") {
            return Inertia::render(
                'Forbidden'
            );
        }

        return Inertia::render('EditTool', [
            'tool' => $tool,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tool $tool)
    {
        if (auth()->user()->role != "admin") {
            return Inertia::render(
                'Forbidden'
            );
        }

        $tool->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'oidc_initiation_url' => $request->input('oidc_initiation_url'),
            'jwks_url' => $request->input('jwks_url'),
            'target_link_uri' => $request->input('target_link_uri'),
            'redirect_uris' => json_encode(explode(',', $request->input('redirect_uris'))),
            'deep_link_url' => $request->input('deep_link_url')
        ]);

        return to_route('tools.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tool $tool)
    {
        if (auth()->user()->role != "admin") {
            return Inertia::render(
                'Forbidden'
            );
        }

        $tool->delete();
        return to_route('tools.index');
    }
}
