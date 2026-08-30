<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Critique;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalCritiques = Critique::count();
        $pendingCritiques = Critique::where('status', 'dikirim')->count();
        $reviewingCritiques = Critique::where('status', 'ditinjau')->count();
        $processingCritiques = Critique::where('status', 'diproses')->count();
        $completedCritiques = Critique::where('status', 'selesai')->count();
        $rejectedCritiques = Critique::where('status', 'ditolak')->count();

        $totalUsers = User::where('role', 'user')->count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalSuperAdmins = User::where('role', 'super_admin')->count();

        $statusCounts = Critique::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $categoryStats = Critique::select('categories.name', DB::raw('count(critiques.id) as total'))
            ->join('categories', 'critiques.category_id', '=', 'categories.id')
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        $recentCritiques = Critique::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // ===== TREND 6 BULAN TERAKHIR (MULAI DARI BULAN INI) =====
        $monthlyCritiques = Critique::select(
                DB::raw('MONTH(submitted_at) as month'),
                DB::raw('YEAR(submitted_at) as year'),
                DB::raw('count(*) as total')
            )
            ->where('submitted_at', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        return view('admin.dashboard', compact(
            'totalCritiques',
            'pendingCritiques',
            'reviewingCritiques',
            'processingCritiques',
            'completedCritiques',
            'rejectedCritiques',
            'totalUsers',
            'totalAdmins',
            'totalSuperAdmins',
            'statusCounts',
            'categoryStats',
            'recentCritiques',
            'monthlyCritiques'
        ));
    }
}
