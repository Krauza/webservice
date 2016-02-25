<?php

namespace Fiche\Domain\Policy;

interface UniqueIdInterface
{
    public function __construct($id = null);
    public function generate();
    public function getId();
}
