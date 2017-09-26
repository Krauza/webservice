<?php

namespace Krauza\Core\Exception;

class BoxIsEmpty extends LogicException
{
    public function __construct()
    {
        parent::__construct('Current box has not any cards');
    }
}
