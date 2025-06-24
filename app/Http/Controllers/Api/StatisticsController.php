<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\District;
use App\Models\Member;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    /**
     * Get the distribution of members across districts
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function districtStatistics()
    {
        // Get count of members per district
        $districtStats = District::select('districts.name', DB::raw('COUNT(members.id) as count'))
            ->leftJoin('members', 'districts.id', '=', 'members.district_id')
            ->where(function($query) {
                $query->whereNull('members.approval_status')
                    ->orWhere('members.approval_status', 'approved');
            })
            ->groupBy('districts.id', 'districts.name')
            ->orderBy('count', 'desc')
            ->get();
        
        return response()->json($districtStats);
    }
}
