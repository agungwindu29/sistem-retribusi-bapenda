<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditController extends Controller
{
    public function index()
    {
        $user = Auth::user() ?? User::first();
        $logs = AuditLog::orderBy('created_at', 'desc')->paginate(15);

        return view('audit.index', compact('logs', 'user'));
    }
}
