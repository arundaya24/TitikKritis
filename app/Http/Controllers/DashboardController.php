<?php

namespace App\Http\Controllers;

use App\Models\Critique;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalCritiques = Critique::where('user_id', $user->id)->count();
        $pendingCritiques = Critique::where('user_id', $user->id)->where('status', 'dikirim')->count();
        $processedCritiques = Critique::where('user_id', $user->id)->whereIn('status', ['ditinjau', 'diproses'])->count();
        $completedCritiques = Critique::where('user_id', $user->id)->where('status', 'selesai')->count();

        return view('dashboard', compact(
            'totalCritiques',
            'pendingCritiques',
            'processedCritiques',
            'completedCritiques'
        ));
    }
}
