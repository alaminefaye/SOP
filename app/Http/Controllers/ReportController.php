<?php

namespace App\Http\Controllers;

use App\Models\Procedure;
use App\Models\Category;
use App\Models\ComplianceRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Show reports dashboard.
     */
    public function index()
    {
        return view('reports.index');
    }

    /**
     * Procedures report.
     */
    public function procedures()
    {
        $stats = [
            'total' => Procedure::count(),
            'by_status' => Procedure::select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get()
                ->pluck('count', 'status'),
            'by_category' => Category::withCount('procedures')->get(),
            'most_viewed' => Procedure::orderBy('views_count', 'desc')->take(10)->get(),
            'recent' => Procedure::latest()->take(10)->get(),
        ];

        return view('reports.procedures', compact('stats'));
    }

    /**
     * Compliance report.
     */
    public function compliance()
    {
        $stats = [
            'total_records' => ComplianceRecord::count(),
            'compliant' => ComplianceRecord::where('is_compliant', true)->count(),
            'non_compliant' => ComplianceRecord::where('is_compliant', false)->count(),
            'by_procedure' => Procedure::withCount(['complianceRecords as compliant_count' => function($query) {
                $query->where('is_compliant', true);
            }, 'complianceRecords as non_compliant_count' => function($query) {
                $query->where('is_compliant', false);
            }])->get(),
            'by_user' => User::withCount(['complianceRecords as compliant_count' => function($query) {
                $query->where('is_compliant', true);
            }, 'complianceRecords as non_compliant_count' => function($query) {
                $query->where('is_compliant', false);
            }])->get(),
        ];

        return view('reports.compliance', compact('stats'));
    }

    /**
     * Activity report.
     */
    public function activity()
    {
        $stats = [
            'procedures_created' => Procedure::whereMonth('created_at', now()->month)->count(),
            'procedures_approved' => Procedure::whereMonth('approved_at', now()->month)->count(),
            'compliance_checks' => ComplianceRecord::whereMonth('checked_at', now()->month)->count(),
            'most_active_users' => User::withCount('procedures')
                ->orderBy('procedures_count', 'desc')
                ->take(10)
                ->get(),
        ];

        return view('reports.activity', compact('stats'));
    }
}
