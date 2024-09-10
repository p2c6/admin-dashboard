<?php
namespace App\Services\Authentication;

use App\Services\AuthenticationManager\AuthenticationManager;

class LoginService {

    protected $authManager;

    public function __construct(AuthenticationManager $authManager)
    {
        $this->authManager = $authManager;
    }

    public function login($request)
    {
        $method = $this->authManager->getMethod($request->method);

        return $method->login($request);
    }
}