<?php

namespace Fiche\Domain\Service;

interface UniqueIdInterface
{
    public function __construct($id = null);
    public function generate();
    public function getId();
}
