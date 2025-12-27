<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShorterLink;
use Carbon\Carbon;
use App\Observers\ShorterLinkObserver;

class ShorterUrlController extends Controller
{
    public function shorterUrlPage()
    {
        return view('shorter_url.create');
    }
    public function shorterUrlStore(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url',
        ]);
        ShorterLink::create([
            'original_url' => $request->original_url,
            'short_url' => uniqid(),
            'user_id' => auth()->id(),
            'company_id' => auth()->user()->company_id,
        ]);
        return redirect()->route('dashboard')->with('success', 'Shorter URL created successfully!');
    }
    public function redirectShortUrl($short_code)
    {
        $shorterLink = ShorterLink::where('short_url', $short_code)->first();
        if ($shorterLink) {
            app(ShorterLinkObserver::class)->clicked($shorterLink);
            return redirect($shorterLink->original_url);
        } else {
            return redirect()->route('login')->with('error', 'Invalid Short URL');
        }
    }




    public function shorterUrlList()
    {

        
        $filter = request('filter');
        $roles = auth()->user()->roles()->pluck('name')->toArray();
        $query = ShorterLink::query();
        if (in_array('member', $roles)) {
            $query->where('user_id', auth()->id());
        } elseif (in_array('admin', $roles)) {
            $query->where('company_id', auth()->user()->company_id);
        }
        if ($filter === 'today') {
            $query->whereDate('created_at', Carbon::today());
        }
        if ($filter === 'last_week') {
            $query->whereBetween('created_at', [Carbon::now()->subWeek(),Carbon::now(),]);
        }
        if ($filter === 'last_month') {
            $query->whereBetween('created_at', [ Carbon::now()->subMonth(),Carbon::now()]);
        }
        $ShorterUrls = $query->paginate(10)->withQueryString();

        return view('shorter_url.shorter_url_list', compact('ShorterUrls'));
    }

    public function shorterUrlListDownload($param = null)
    {
        $filter = $param;
        $roles = auth()->user()->roles()->pluck('name')->toArray();
        $query = ShorterLink::query();
        if (in_array('member', $roles)) {
            $query->where('user_id', auth()->id());
        } elseif (in_array('admin', $roles)) {
            $query->where('company_id', auth()->user()->company_id);
        }
        if ($filter === 'today') {
            $query->whereDate('created_at', Carbon::today());
        }

        if ($filter === 'last_week') {
            $query->whereBetween('created_at', [Carbon::now()->subWeek(),Carbon::now(),]);
        }

        if ($filter === 'last_month') {
            $query->whereBetween('created_at', [Carbon::now()->subMonth(),Carbon::now(),]);
        }

        $ShorterUrls = $query->get();
            $csv = "ID,Original URL,Short Code,Click Count,created by Name,Created At\n";
            foreach ($ShorterUrls as $url) {
                $csv .= "{$url->id},{$url->original_url},{$url->short_url},{$url->click_count},";
                if (auth()->user()->roles()->pluck('name')->contains('super_admin')) {
                    $csv .= "{$url->company->name},";
                } else {
                    $csv .= "{$url->user->name},";
                }
                $csv .= "{$url->created_at}\n";
            }
            $filename = "shorter_urls_". $filter .".csv";

        return response($csv)->header('Content-Type', 'text/csv')->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }
}