<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortenUrlRequest;
use App\Mail\EmailSend;
use App\Models\UrlShortener;
use DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;


class ShortenUrlController extends Controller
{
    public function shortenLink(ShortenUrlRequest $request)
    {
        $url = DB::transaction(function () use ($request) {
            $shortenUrl = url('api/' . Str::random(6));

            if (UrlShortener::whereShorten($shortenUrl)->exists()) {
                $shortenUrl = url('api/' . Str::random(6));
            }

            $url =  UrlShortener::create([
                'email' => $request->email,
                'original_url' => $request->url,
                'shortened_url' => $shortenUrl
            ]);

            //send mail with queue
            if ($request->email) {
                Mail::to($request->email)
                    ->queue(new EmailSend($url->shortened_url));
            }
            return $url;
        });

        return Response::json([
            'message' => 'Success',
            'data' => $url,
        ], 200);
    }

    public function redirectLink(string $code)
    {
        $urlEntry = UrlShortener::whereShorten(url("api/" . $code))
            ->firstOrFail();
        return redirect($urlEntry->original_url);
    }
}
