<?php

namespace Krauza\UseCase;

use Krauza\Entity\Box;
use Krauza\Entity\Card;
use Krauza\Repository\BoxRepository;
use Krauza\Repository\CardRepository;

class FindNextCard
{
    private $boxRepository;
    private $cardRepository;

    public function __construct(BoxRepository $boxRepository, CardRepository $cardRepository)
    {
        $this->boxRepository = $boxRepository;
        $this->cardRepository = $cardRepository;
    }

    public function find(Box $box): Card
    {
        $this->boxRepository->getCardFromBoxAtSection($box, 1);
        return $this->cardRepository->get('');
    }
}
