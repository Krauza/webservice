<?php

namespace Krauza\Service;

use Krauza\Repository\BoxRepository;
use Krauza\Entity\Box;

class AddNewCardService
{
    private $boxRepository;

    public function __construct(BoxRepository $boxRepository)
    {
        $this->boxRepository = $boxRepository;
    }

    public function addNewCardToBox(Box $box, array $card)
    {

    }
}
