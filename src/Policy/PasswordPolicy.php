<?php

namespace Krauza\Policy;

interface PasswordPolicy
{
    public function __construct(string $password);
    public function getPassword() : string;
}
