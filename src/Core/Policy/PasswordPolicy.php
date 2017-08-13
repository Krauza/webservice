<?php

namespace Krauza\Core\Policy;

interface PasswordPolicy
{
    public function __construct(string $password);
    public function getPassword() : string;
}
