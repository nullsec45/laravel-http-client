<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class HttpTest extends TestCase
{
    public function testGet(){
        $response=Http::get("https://eokih5piy7jx0o1.m.pipedream.net/");
        self::assertTrue($response->ok());
    }

    public function testPost(){
        $response=Http::post("https://eokih5piy7jx0o1.m.pipedream.net/");
        self::assertTrue($response->ok());
    }

    public function testDelete(){
        $response=Http::delete("https://eokih5piy7jx0o1.m.pipedream.net/");
        self::assertTrue($response->ok());
    }

    public function testResponse(){
        $response=Http::get("https://eokih5piy7jx0o1.m.pipedream.net/");
        self::assertEquals(200, $response->status());
        self::assertNotNull($response->headers());
        self::assertNotNull($response->body());

        $json=$response->json();
        self::assertNotNull($json["about"]);
    }
}
