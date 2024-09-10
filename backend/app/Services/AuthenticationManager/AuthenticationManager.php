<?php
namespace App\Services\AuthenticationManager;

use App\Services\AuthenticationMethod\EmailAuthService;
use App\Services\AuthenticationMethod\UsernameAuthService;

class AuthenticationManager
{
    protected $method = [];
    
    public function __construct(EmailAuthService $emailAuth, UsernameAuthService $usernameAuth)
    {
        $this->method['email'] = $emailAuth;
        $this->method['username'] = $usernameAuth;
    }

    public function getMethod($name)
    {
        if (!isset($this->method[$name])) {
            throw new \Exception("Authentication Method not found.");
        }

        return $this->method[$name];
    }
}