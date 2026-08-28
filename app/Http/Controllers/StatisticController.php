<?php

namespace App\Http\Controllers;

use App\Models\Critique;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $filter = $request->get('filter', 'saya'); // default: 'saya'

        // Base query
        $query = Critique::query();

        // Filter berdasarkan pilihan
        if ($filter === 'saya') {
            $query->where('user_id', $user->id);
        }
        // 'semua' -> tidak ada filter user_id

        // Ambil data
        $totalCritiques = $query->count();

        $statusCounts = (clone $query)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $categoryStats = (clone $query)
            ->select('categories.name', DB::raw('count(critiques.id) as total'))
            ->join('categories', 'critiques.category_id', '=', 'categories.id')
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        $levelStats = (clone $query)
            ->select('government_level', DB::raw('count(*) as total'))
            ->groupBy('government_level')
            ->pluck('total', 'government_level')
            ->toArray();

        $monthlyStats = (clone $query)
            ->select(DB::raw('MONTH(submitted_at) as month'), DB::raw('YEAR(submitted_at) as year'), DB::raw('count(*) as total'))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Response Rate (kritik yang punya tanggapan)
        $responseRate = (clone $query)
            ->whereHas('response')
            ->count();

        // Average Response Time
        $avgResponseTime = (clone $query)
            ->whereHas('response')
            ->join('responses', 'critiques.id', '=', 'responses.critique_id')
            ->select(DB::raw('AVG(TIMESTAMPDIFF(HOUR, critiques.submitted_at, responses.created_at)) as avg_hours'))
            ->value('avg_hours');

        // Total user yang pernah kirim kritik (untuk info tambahan)
        $totalUsersWithCritiques = Critique::distinct('user_id')->count('user_id');

        return view('statistic.index', compact(
            'totalCritiques',
            'statusCounts',
            'categoryStats',
            'levelStats',
            'monthlyStats',
            'responseRate',
            'avgResponseTime',
            'filter',
            'totalUsersWithCritiques'
        ));
    }
}
