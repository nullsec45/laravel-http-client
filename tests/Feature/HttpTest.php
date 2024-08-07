<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

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

    public function testQueryParameter(){
        $response=Http::withQueryParameters([
            "page" => 1,
            "limit" => 10
        ])->get("https://eokih5piy7jx0o1.m.pipedream.net/");
        self::assertTrue($response->ok());
    }

    public function testHeader(){
        $response=Http::withQueryParameters([
            "page" => 1,
            "limit" => 10
        ])->withHeaders([
            "Accept" => "application/json",
            "X-Request-Id" => "123456789"
        ])->get("https://eokih5piy7jx0o1.m.pipedream.net/");

        self::assertTrue($response->ok());
    }

    public function testCookie(){
        $response=Http::withQueryParameters([
            "page" => 1,
            "limit" => 10
        ])->withHeaders([
            "Accept" => "application/json",
            "X-Request-Id" => "123456789"
        ])->withCookies([
            "sessionId" => "1234567890",
            "userId" => "1  "
        ],"https://eokih5piy7jx0o1.m.pipedream.net/")->get("https://eokih5piy7jx0o1.m.pipedream.net/");

        self::assertTrue($response->ok());
    }

    public function testFormPost(){
        $reponse=Http::asForm()->post("https://eokih5piy7jx0o1.m.pipedream.net/",[
            "username" => "admin",
            "password" => "123456"
        ]);

        self::assertTrue($reponse->ok());    
    }

    public function testMultiPart(){
        $reponse=Http::asMultiPart()->attach("typescript", file_get_contents("https://upload.wikimedia.org/wikipedia/commons/thumb/4/4c/Typescript_logo_2020.svg/2048px-Typescript_logo_2020.svg.png"), "typescript.png")
                                    ->post("https://eokih5piy7jx0o1.m.pipedream.net",[
                                        "username" => "admin",
                                        "password" => "123456"
                                    ]);
        
        self::assertTrue($reponse->ok());
    }

    public function testJSON(){
        $response=Http::asJson()->post("https://eokih5piy7jx0o1.m.pipedream.net",[
            "username" => "admin",
            "password" => "12345"
        ]);

        self::assertTrue($response->ok());

    }

    public function testTimeout(){
        $response=Http::timeout(5)->asJson()
                                  ->post("https://eokih5piy7jx0o1.m.pipedream.net",[
                                    "username" => "admin",
                                    "password" => "123456"
                                  ]);

        self::assertTrue($response->ok());
    }

    public function testRetry(){
        $response=Http::timeout(1)->retry(5, 1000)->asJson()
                                  ->post("https://eokih5piy7jx0o1.m.pipedream.net",[
                                    "username" => "admin",
                                    "password" => "admin"
                                  ]);

        self::assertTrue($reponse->ok());
    }

    public function testException(){
        $this->assertThrows(function(){
            $response=Http::get("https://www.programmerzamannow.com/aaaaaaaaaaaaaaaaaaaaaaaaaaaa");
            self::assertEquals(404,$response->status());
            $response->throw();
        }, RequestException::class);
    }
}
