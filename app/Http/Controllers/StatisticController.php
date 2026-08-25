<?php

namespace App\Http\Controllers;

use App\Models\Critique;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalCritiques = Critique::where('user_id', $user->id)->count();

        $statusCounts = Critique::where('user_id', $user->id)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $categoryStats = Critique::where('user_id', $user->id)
            ->select('categories.name', DB::raw('count(critiques.id) as total'))
            ->join('categories', 'critiques.category_id', '=', 'categories.id')
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        $levelStats = Critique::where('user_id', $user->id)
            ->select('government_level', DB::raw('count(*) as total'))
            ->groupBy('government_level')
            ->pluck('total', 'government_level')
            ->toArray();

        $monthlyStats = Critique::where('user_id', $user->id)
            ->select(DB::raw('MONTH(submitted_at) as month'), DB::raw('YEAR(submitted_at) as year'), DB::raw('count(*) as total'))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $responseRate = Critique::where('user_id', $user->id)
            ->whereHas('response')
            ->count();

        $avgResponseTime = Critique::where('user_id', $user->id)
            ->whereHas('response')
            ->join('responses', 'critiques.id', '=', 'responses.critique_id')
            ->select(DB::raw('AVG(TIMESTAMPDIFF(HOUR, critiques.submitted_at, responses.created_at)) as avg_hours'))
            ->value('avg_hours');

        return view('statistic.index', compact(
            'totalCritiques',
            'statusCounts',
            'categoryStats',
            'levelStats',
            'monthlyStats',
            'responseRate',
            'avgResponseTime'
        ));
    }
}
