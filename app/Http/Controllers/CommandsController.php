<?php

namespace App\Http\Controllers;

use App\Models\CommandHistory;
use App\Models\Site;
use App\Services\SuperUserAPIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommandsController extends Controller
{
    public function index(Site $site)
    {
        $commands_history = CommandHistory::query()->where('site_id',$site->id)->get();
        return view('site.commands',compact('site','commands_history'));
    }

    public function execCommand(Request $request, Site $site) {
        $result = SuperUserAPIService::exec($site->name, $request->command);
        CommandHistory::query()->create([
            'user_id' => Auth::id(),
            'site_id' => $site->id,
            'command' => $request->command,
            'output' => $result['data'],
            'success' => $result['success'],
        ]);
        return redirect()->back();
    }
}
