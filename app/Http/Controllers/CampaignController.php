<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.campaign-create', [
            'tags' => $request->user()->tags,
        ]);
    }

    public function lists (Request $request)
    {

        $campaigns = $request->user()->campaigns()->withCount(['blasts','blasts as blasts_pending' => function($q){
            return $q->where('status', 'pending');
        }])->withCount(['blasts as blasts_success' => function($q){
            return $q->where('status', 'success');
        }])->withCount(['blasts as blasts_failed' => function($q){
            return $q->where('status', 'failed');
        }])->get();        
        return view('pages.campaign-lists', [
           'campaigns' => $campaigns,
        ]);
    }

    public function show (Request $request, $id)
    {
        $campaign = $request->user()->campaigns()->find($id);
        if ($request->ajax()) {
           

            switch ($campaign->type) {
                case 'text':
                    return view('ajax.autoreply.textshow', [
                        'keyword' => 'PREVIEW MESSAGE',
                        'text' => json_decode($campaign->message)->text
                    ])->render();
                    break;
                case 'image':
                    return  view('ajax.autoreply.imageshow', [
                        'keyword' => 'PREVIEW MESSAGE',
                        'caption' => json_decode($campaign->message)->caption,
                        'image' => json_decode($campaign->message)->image->url,
                    ])->render();
                    break;
                case 'button':
                    // if exists property image in $campaign->message

                    return  view('ajax.autoreply.buttonshow', [
                        'keyword' => 'PREVIEW MESSAGE',
                        'message' => json_decode($campaign->message)->text ?? json_decode($campaign->message)->caption,
                        'footer' => json_decode($campaign->message)->footer,
                        'buttons' => json_decode($campaign->message)->buttons,
                        'image' => json_decode($campaign->message)->image->url ?? null,
                    ])->render();
                    break;
                case 'template':

                    $templates = [];
                    // if exists template 1

                    return  view('ajax.autoreply.templateshow', [
                        'keyword' => 'PREVIEW MESSAGE',
                        'message' => json_decode($campaign->message)->text ?? json_decode($campaign->message)->caption,
                        'footer' => json_decode($campaign->message)->footer,
                        'templates' => json_decode($campaign->message)->templateButtons,
                        'image' => json_decode($campaign->message)->image->url ?? null,
                    ])->render();
                    break;
                default:
                    # code...
                    break;
            }
        }

        
    }
    public function destroyAll (Request $request)
    {
        $campaign = $request->user()->campaigns()->delete();
       session()->flash('alert' , [
        'type' => 'success',
        'msg' => 'All campaigns deleted',
       ]);

        
      

        return redirect()->back();
    }
}
