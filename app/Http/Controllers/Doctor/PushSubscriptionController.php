<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PushSubscriptionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Check Device Status
    |--------------------------------------------------------------------------
    */

    public function status(Request $request)
    {
        $data = $request->validate([
            'endpoint' => [
                'required',
                'string',
            ],
        ]);

        $subscription = $request->user()
            ->pushSubscriptions()
            ->where('endpoint', $data['endpoint'])
            ->first();

        /*
        |--------------------------------------------------------------------------
        | الجهاز موجود
        |--------------------------------------------------------------------------
        */

        if ($subscription) {

            return response()->json([
                'exists' => true,
                'active' => (bool) $subscription->is_active,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | الجهاز غير موجود
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'exists' => false,
            'active' => false,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Enable Device
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $data = $request->validate([
            'endpoint' => [
                'required',
                'string',
            ],

            'keys.p256dh' => [
                'required',
                'string',
            ],

            'keys.auth' => [
                'required',
                'string',
            ],

            'contentEncoding' => [
                'nullable',
                'string',
            ],
        ]);

        $user = $request->user();


        /*
        |--------------------------------------------------------------------------
        | البحث عن الجهاز
        |--------------------------------------------------------------------------
        */

        $subscription = $user
            ->pushSubscriptions()
            ->where('endpoint', $data['endpoint'])
            ->first();


        /*
        |--------------------------------------------------------------------------
        | الجهاز موجود
        |--------------------------------------------------------------------------
        */

        if ($subscription) {

            $subscription->public_key =
                $data['keys']['p256dh'];

            $subscription->auth_token =
                $data['keys']['auth'];

            $subscription->content_encoding =
                $data['contentEncoding'] ?? null;

            $subscription->is_active = true;

            $subscription->save();

        }

        /*
        |--------------------------------------------------------------------------
        | الجهاز غير موجود
        |--------------------------------------------------------------------------
        */

        else {

            $subscription =
                $user->pushSubscriptions()->create([

                    'endpoint' =>
                        $data['endpoint'],

                    'public_key' =>
                        $data['keys']['p256dh'],

                    'auth_token' =>
                        $data['keys']['auth'],

                    'content_encoding' =>
                        $data['contentEncoding'] ?? null,

                    'is_active' =>
                        true,

                ]);
        }


        return response()->json([
            'success' => true,
            'active' => true,
            'subscription_id' =>
                $subscription->id,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Disable Device
    |--------------------------------------------------------------------------
    */

    public function disable(Request $request)
    {
        $data = $request->validate([
            'endpoint' => [
                'required',
                'string',
            ],
        ]);


        $subscription = $request->user()
            ->pushSubscriptions()
            ->where('endpoint', $data['endpoint'])
            ->first();


        /*
        |--------------------------------------------------------------------------
        | لو الجهاز موجود
        |--------------------------------------------------------------------------
        */

        if ($subscription) {

            $subscription->is_active = false;

            $subscription->save();

        }


        return response()->json([
            'success' => true,
            'active' => false,
        ]);
    }
}
