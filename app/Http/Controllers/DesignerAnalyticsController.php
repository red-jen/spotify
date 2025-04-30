<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Design;
use App\Models\Order;
use App\Models\View;
use App\Models\Favorite;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DesignerAnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $period = $request->get('period', 'month');
        $designIds = Design::where('user_id', $user->id)->pluck('id');
        
        // Set time period
        switch ($period) {
            case 'week':
                $startDate = Carbon::now()->subWeek();
                break;
            case 'month':
                $startDate = Carbon::now()->subMonth();
                break;
            case 'quarter':
                $startDate = Carbon::now()->subQuarter();
                break;
            case 'year':
                $startDate = Carbon::now()->subYear();
                break;
            default:
                $startDate = Carbon::now()->subMonth();
        }
        
        // Get popular designs (based on orders)
        $popularDesigns = Order::whereIn('design_id', $designIds)
            ->where('created_at', '>=', $startDate)
            ->select('design_id', DB::raw('COUNT(*) as sales_count'))
            ->groupBy('design_id')
            ->orderByDesc('sales_count')
            ->take(10)
            ->with('design')
            ->get();
            
        // Get most viewed designs
        $mostViewedDesigns = View::whereIn('design_id', $designIds)
            ->where('created_at', '>=', $startDate)
            ->select('design_id', DB::raw('COUNT(*) as view_count'))
            ->groupBy('design_id')
            ->orderByDesc('view_count')
            ->take(10)
            ->with('design')
            ->get();
            
        // Get most favorited designs
        $mostFavoritedDesigns = Favorite::whereIn('design_id', $designIds)
            ->where('created_at', '>=', $startDate)
            ->select('design_id', DB::raw('COUNT(*) as favorite_count'))
            ->groupBy('design_id')
            ->orderByDesc('favorite_count')
            ->take(10)
            ->with('design')
            ->get();
            
        // Get customer demographics (age, location, etc.)
        $customerDemographics = Order::whereIn('design_id', $designIds)
            ->where('created_at', '>=', $startDate)
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select(
                'users.country',
                DB::raw('COUNT(DISTINCT users.id) as customer_count')
            )
            ->groupBy('users.country')
            ->orderByDesc('customer_count')
            ->take(5)
            ->get();
            
        // Get traffic sources
        $trafficSources = View::whereIn('design_id', $designIds)
            ->where('created_at', '>=', $startDate)
            ->select('referrer', DB::raw('COUNT(*) as view_count'))
            ->groupBy('referrer')
            ->orderByDesc('view_count')
            ->take(5)
            ->get();
            
        // Get design performance over time
        $performanceData = Order::whereIn('design_id', $designIds)
            ->where('created_at', '>=', $startDate)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as orders'),
                DB::raw('SUM(total) as revenue')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        $performanceChart = [
            'labels' => $performanceData->pluck('date')->toArray(),
            'orders' => $performanceData->pluck('orders')->toArray(),
            'revenue' => $performanceData->pluck('revenue')->toArray(),
        ];
        
        return view('designer.analytics.index', compact(
            'popularDesigns',
            'mostViewedDesigns',
            'mostFavoritedDesigns',
            'customerDemographics',
            'trafficSources',
            'performanceChart',
            'period'
        ));
    }
    
    public function designDetails(Request $request, Design $design)
    {
        // Authorization check
        $this->authorize('view', $design);
        
        $period = $request->get('period', 'month');
        
        // Set time period
        switch ($period) {
            case 'week':
                $startDate = Carbon::now()->subWeek();
                break;
            case 'month':
                $startDate = Carbon::now()->subMonth();
                break;
            case 'quarter':
                $startDate = Carbon::now()->subQuarter();
                break;
            case 'year':
                $startDate = Carbon::now()->subYear();
                break;
            default:
                $startDate = Carbon::now()->subMonth();
        }
        
        // Get detailed analytics for this specific design
        // ...
        
        return view('designer.analytics.design-details', compact(
            'design',
            'period'
            // Additional data...
        ));
    }
}
