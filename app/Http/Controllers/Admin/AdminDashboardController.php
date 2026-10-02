<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Critique;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::role('user')->count();
        $totalAdmins = User::role('admin')->count();
        $totalSuperAdmins = User::role('superadmin')->count();

        $totalCritiques = Critique::count();

        $pendingCritiques = Critique::where('status', 'dikirim')->count();
        $reviewingCritiques = Critique::where('status', 'ditinjau')->count();
        $processingCritiques = Critique::where('status', 'diproses')->count();
        $completedCritiques = Critique::where('status', 'selesai')->count();
        $rejectedCritiques = Critique::where('status', 'ditolak')->count();

        $statusCounts = [
            'dikirim' => $pendingCritiques,
            'ditinjau' => $reviewingCritiques,
            'diproses' => $processingCritiques,
            'selesai' => $completedCritiques,
            'ditolak' => $rejectedCritiques,
        ];

        $categoryStats = Critique::with('category')
            ->get()
            ->groupBy(function ($critique) {
                return $critique->category?->name ?? 'Tanpa Kategori';
            })
            ->map(function ($critiques) {
                return $critiques->count();
            });

        $monthlyCritiques = Critique::where(
            'created_at',
            '>=',
            now()->subMonths(5)->startOfMonth()
        )
        ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as total')
        ->groupByRaw('YEAR(created_at), MONTH(created_at)')
        ->orderByRaw('YEAR(created_at), MONTH(created_at)')
        ->get();

        $recentCritiques = Critique::with(['user', 'category'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAdmins',
            'totalSuperAdmins',
            'totalCritiques',
            'pendingCritiques',
            'reviewingCritiques',
            'processingCritiques',
            'completedCritiques',
            'rejectedCritiques',
            'statusCounts',
            'categoryStats',
            'monthlyCritiques',
            'recentCritiques'
        ));
    }
}
