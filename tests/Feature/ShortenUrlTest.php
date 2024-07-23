<?php

namespace Tests\Feature;

use App\Http\Requests\ShortenUrlRequest;
use App\Mail\EmailSend;
use App\Models\UrlShortener;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Str;
use Tests\TestCase;

class ShortenUrlTest extends TestCase
{
    use DatabaseTransactions;

    public function test_shorten_link()
    {
        Mail::fake();

        $data = [
            'email' => 'test@example.com',
            'url' => 'https://example.com',
        ];

        $response = $this->postJson(route('url.shorten'), $data);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Success',
            ]);

        $this->assertDatabaseHas('url_shorteners', [
            'email' => 'test@example.com',
            'original_url' => 'https://example.com',
        ]);

        // Assert that the email was queued with the correct data
        Mail::assertQueued(EmailSend::class);
    }
    public function test_redirect_link()
    {
        $shortenUrl = url('api/' . Str::random(6));
        $urlEntry = UrlShortener::create([
            'shortened_url' => $shortenUrl, // Replace with the actual shortened code
            'original_url' => 'https://example.com',
        ]);

        $response = $this->get($urlEntry->shortened_url);

        // Assert that the response is a redirect to the original URL
        $response->assertStatus(302) // Redirect status code
            ->assertRedirect('https://example.com');
    }

    public function test_valid_shorten_url_request()
    {
        $data = [
            'email' => 'test@example.com',
            'url' => 'https://example.com',
        ];

        $validator = Validator::make($data, (new ShortenUrlRequest())->rules());

        $this->assertFalse($validator->fails());
    }

    public function test_invalid_shorten_url_request_missing_url()
    {
        $data = [
            'email' => 'test@example.com',
        ];

        $validator = Validator::make($data, (new ShortenUrlRequest())->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('url', $validator->errors()->toArray());
    }

    public function test_invalid_shorten_url_request_invalid_email()
    {
        $data = [
            'email' => 'invalid_email',
            'url' => 'https://example.com',
        ];

        $validator = Validator::make($data, (new ShortenUrlRequest())->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('email', $validator->errors()->toArray());
    }
}
