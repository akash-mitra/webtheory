<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use Illuminate\Http\Request;
use App\Parameter;
use Illuminate\Support\Facades\Auth;
use App\Jobs\UpdateSite;
use App\Mail\TestMail;

class SettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['check.permission']);
    }

    public function getsocial()
    {
        $keys = [
            'FACEBOOK_CLIENT_ID', 'FACEBOOK_CLIENT_SECRET',
            'TWITTER_CLIENT_ID', 'TWITTER_CLIENT_SECRET',
            'LINKEDIN_CLIENT_ID', 'LINKEDIN_CLIENT_SECRET',
            'GOOGLE_CLIENT_ID', 'GOOGLE_CLIENT_SECRET'
        ];

        $social = [];
        foreach($keys as $key) {
            $value = Parameter::getKey($key);
            $social[$key] = $value;
        }

        return response()->json($social);
    }

    public function getmail()
    {
        $keys = [
            'MAIL_DRIVER', 'MAIL_FROM_ADDRESS', 'MAIL_FROM_NAME',
            'MAIL_HOST', 'MAIL_PORT', 'MAIL_ENCRYPTION', 'MAIL_USERNAME', 'MAIL_PASSWORD',
            'MAILGUN_DOMAIN', 'MAILGUN_SECRET', 'MAILGUN_ENDPOINT',
            'POSTMARK_TOKEN',
            'AWS_ACCESS_KEY_ID', 'AWS_SECRET_ACCESS_KEY', 'AWS_DEFAULT_REGION'
        ];

        $mail = [];
        foreach($keys as $key) {
            $value = Parameter::getKey($key);
            $mail[$key] = $value;
        }

        return response()->json($mail);
    }

    public function loginprovider(Request $request)
    {
        $data = $request->data;
        foreach($data as $lov) {
            $key = $lov['key'];
            $value = is_null($lov['value']) ? '' : $lov['value'];
            Parameter::setKey($key, $value);
        }

        return response()->json("Saved", 200);
    }

    public function mailprovider(Request $request)
    {
        $data = $request->data;
        foreach($data as $lov) {
            $key = $lov['key'];
            $value = is_null($lov['value']) ? '' : $lov['value'];
            Parameter::setKey($key, $value);
        }

        return response()->json("Saved", 200);
    }

    public function testmail()
    {
        $mailDriver = Parameter::getKey('MAIL_DRIVER');

        if ($mailDriver != '') {
            $siteinfo = json_decode(Parameter::getKey('siteinfo'), true);

            try {
                // Mail::raw('Test Mail from ' . $siteinfo['title'], function ($message){
                //     $message->to(Auth::user()->email);
                // });


                SendEmail::dispatch(
                    Auth::user()->email,
                    new TestMail($siteinfo['title'])
                );

                return response()->json("Mail Sent. Please check your email inbox", 200);

            } catch (\Exception $e) {
                return abort(400, $e);
            }
        }

        return response()->json("Mail Driver not set", 400);
    }


    public function update(Request $request)
    {
        $commitId = $request->commit_id;

        UpdateSite::dispatchAfterResponse($commitId);

        return response()->json("Site update is in progress", 200);
    }

}