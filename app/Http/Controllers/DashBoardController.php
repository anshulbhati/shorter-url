<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\ShorterLink;
use App\Models\User;
use Carbon\Carbon;

class DashBoardController extends Controller
{
    public function DashBoard(){

        $Companies = Company::paginate(10);
        $role = auth()->user()->roles()->pluck('name')->toArray();
        $members = in_array('admin', $role)
            ? User::where('company_id', auth()->user()->company_id)->paginate(10)
            : User::where('id', auth()->id())->paginate(10);
        $query = ShorterLink::query();
        if(in_array('member', $role)){
            $query->where('user_id', auth()->id())->paginate(10);
        }elseif(in_array('admin', $role)){
            $query->where('company_id', auth()->user()->company_id)->paginate(10);
        }else{
            $query->paginate(10);
        }

        $filter = request('filter');
        if ($filter == 'today') {
            $ShorterUrls = $query->whereDate('created_at', Carbon::today());
        } elseif ($filter == 'last_week') {
            $ShorterUrls = $query->whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()]);
        } elseif ($filter == 'last_month') {
            $ShorterUrls = $query->whereBetween('created_at', [Carbon::now()->subMonth(), Carbon::now()]);
        }
        $ShorterUrls = $query->paginate(10)->withQueryString();

        return view('dashboard.dashboard', compact('Companies', 'ShorterUrls', 'members'));
    }
}
