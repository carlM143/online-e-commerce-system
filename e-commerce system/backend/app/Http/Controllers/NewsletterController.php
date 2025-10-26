<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CampaignMonitorService;

class NewsletterController extends Controller
{
    protected $cm;

    public function __construct(CampaignMonitorService $cm)
    {
        $this->cm = $cm;
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string'
        ]);

        $result = $this->cm->addSubscriber($request->email, $request->name);

        return response()->json($result);
    }
}
