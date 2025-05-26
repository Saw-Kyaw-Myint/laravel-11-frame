<?php

namespace App\Http\Controllers;

use Tymon\JWTAuth\JWT;

class AuthController extends Controller
{
    public function __construct(protected JWT $jwt) {}

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL2FkbWluL2xvZ2luIiwiaWF0IjoxNzQ4MjUyMjc3LCJleHAiOjE3NDgyODgyNzcsIm5iZiI6MTc0ODI1MjI3NywianRpIjoiRXpvaTNWT0Z6V0pLRnVEVyIsInN1YiI6IjMiLCJwcnYiOiJhMjJkZTMwNjYwYWM4MjQyN2VjMjVkZTRkMjk1ZThiZjJkOTIxOGU1IiwiZGF0YSI6eyJ1c2VyX2lkIjozLCJ1c2VybmFtZSI6ImdhZGdlbG9nIiwiZ3JvdXAiOjEsImlzQWRtaW4iOnRydWV9LCJleHBpcmVfZGF0ZV90aW1lIjoiMjAyNS0wNS0yNiAxOTozNzo1NyJ9.9nmTfdXhKJV-7Yopua4fX6Y95VGREqu4afM5ZIb2p8M';
        $payload = $this->jwt->setToken($token)->getPayload();

        return response()->json([
            'status' => 200,
            'messsage' => 'saw',
        ]);
    }
}
