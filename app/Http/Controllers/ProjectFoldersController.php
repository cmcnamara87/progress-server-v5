<?php

namespace App\Http\Controllers;

use App\Folder;
use Illuminate\Http\Request;

use App\Http\Requests;

class ProjectFoldersController extends Controller
{
    public function index(Request $request, $projectId) {
        $folders = Folder::where('project_id', $projectId)->get();
        return response()->json($folders);
    }
    public function store(Request $request, $projectId) {

        $data = $request->only('path');
        $data['project_id'] = $projectId;
        $folder = Folder::create($data);
        return response()->json($folder);
    }
}
