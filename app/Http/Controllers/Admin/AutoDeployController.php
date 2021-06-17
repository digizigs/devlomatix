<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AutoDeployController extends Controller
{
    public function deploy(Request $request)
    {
        activity()->log('Webhook from github ,will fire this event if new pus to github');
        //activity()->log('Github webhook request:- ' . $request);
        $githubPayload = $request->getContent();
        activity()->log('Github payload:- ' . $githubPayload );
        $postdata = json_decode($request->getContent(), TRUE);
        activity()->log('Post data:- ' . $postdata );
        $githubHash = $request->header('X-Hub-Signature');
        activity()->log('Github Hash:- ' . $githubHash );


        $localToken = 'vishwa1981';//config('gitdeploy.secret_key');
        $localHash = 'sha1=' . hash_hmac('sha1', $githubPayload, $localToken, false);

        if (hash_equals($githubHash, $localHash)) {
            activity()->log('local hash mached with github hash');
        }
    }
}
