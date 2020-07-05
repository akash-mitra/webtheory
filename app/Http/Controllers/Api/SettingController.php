<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Exception;
use App\Parameter;
use App\Mail\TestMail;
// use App\Jobs\SendEmail;
use App\Traits\SetMailConfig;
use App\Jobs\UpdateSite;

class SettingController extends Controller
{
    use SetMailConfig;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['check.permission']);
    }

    public function getSocial()
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

    public function getMail()
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

    public function loginProvider(Request $request)
    {
        $data = $request->data;
        foreach($data as $lov) {
            $key = $lov['key'];
            $value = is_null($lov['value']) ? '' : $lov['value'];
            Parameter::setKey($key, $value);
        }

        return response()->json("Saved", 200);
    }

    public function mailProvider(Request $request)
    {
        $data = $request->data;
        foreach($data as $lov) {
            $key = $lov['key'];
            $value = is_null($lov['value']) ? '' : $lov['value'];
            Parameter::setKey($key, $value);
        }

        return response()->json("Saved", 200);
    }

    public function testMail()
    {
        $siteinfo = json_decode(Parameter::getKey('siteinfo'), true);

        return $this->sendEmail(Auth::user()->email, new TestMail($siteinfo['title']));
        
        /*
        $mailDriver = Parameter::getKey('MAIL_DRIVER');

        if ($mailDriver != '') {
            $siteinfo = json_decode(Parameter::getKey('siteinfo'), true);

            try {
                if ($mailDriver == 'smtp') {
                    SendEmail::dispatch(Auth::user()->email, new TestMail($siteinfo['title']));
                } else {
                    config(['mail.default' => Parameter::getKey('MAIL_DRIVER')]);
                    config(['mail.from.address' => Parameter::getKey('MAIL_FROM_ADDRESS')]);
                    config(['mail.from.name' => Parameter::getKey('MAIL_FROM_NAME')]);

                    if ($mailDriver == 'ses') {
                        config(['mail.mailers.ses.key' => Parameter::getKey('AWS_ACCESS_KEY_ID')]);
                        config(['mail.mailers.ses.secret' => Parameter::getKey('AWS_SECRET_ACCESS_KEY')]);
                        config(['mail.mailers.ses.region' => Parameter::getKey('AWS_DEFAULT_REGION')]);
                    } else if ($mailDriver == 'mailgun') {
                        config(['mail.mailers.mailgun.domain' => Parameter::getKey('MAILGUN_DOMAIN')]);
                        config(['mail.mailers.mailgun.secret' => Parameter::getKey('MAILGUN_SECRET')]);
                    } else if ($mailDriver == 'postmark') {
                        config(['mail.mailers.postmark.token' => Parameter::getKey('POSTMARK_TOKEN')]);
                    }

                    Mail::to(Auth::user()->email)->send(new TestMail($siteinfo['title']));
                }

                return response()->json("Mail Sent. Please check your email inbox", 200);

            } catch (Exception $e) {
                return abort(400, $e);
            }
        }

        return response()->json("Mail Driver not set", 400);
        */
    }


    public function update(Request $request)
    {
        $commitId = $request->commit_id;

        UpdateSite::dispatchAfterResponse($commitId);

        return response()->json("Site update is in progress", 200);
    }


    public function getSearch()
    {
        $keys = [
            'SEARCHABLE', 'ALGOLIA_COMMUNITY_PLAN',
            'ALGOLIA_APP_ID', 'ALGOLIA_SECRET',
        ];

        $search = [];
        foreach($keys as $key) {
            $value = Parameter::getKey($key);
            $search[$key] = $value;
        }

        return response()->json($search);
    }


    public function searchProvider(Request $request)
    {
        $data = $request->data;
        foreach($data as $key => $value) {
            // $key = $lov['key'];
            // $value = is_null($lov['value']) ? '' : $lov['value'];
            Parameter::setKey($key, $value);
        }

        return response()->json("Saved", 200);
    }
}