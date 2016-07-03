<?php

namespace Fiche\Application;

class SessionStorage
{
    private $sessionStorage;

    public function __construct($sessionStorage)
    {
        $this->sessionStorage = $sessionStorage;
    }

    public function get($key)
    {
        if (method_exists($this->sessionStorage, 'get')) {
            return $this->sessionStorage->get($key);
        }

        return null;
    }

    public function set($key, $value)
    {
        if (method_exists($this->sessionStorage, 'set')) {
            return $this->sessionStorage->set($key, $value);
        }

        return false;
    }
}