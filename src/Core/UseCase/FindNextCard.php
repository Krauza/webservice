<?php

namespace Krauza\Core\UseCase;

use Krauza\Core\Entity\Box;
use Krauza\Core\Entity\Card;
use Krauza\Core\Repository\BoxRepository;
use Krauza\Core\Repository\CardRepository;

class FindNextCard
{
    /**
     * @var BoxRepository
     */
    private $boxRepository;

    /**
     * @var CardRepository
     */
    private $cardRepository;

    public function __construct(BoxRepository $boxRepository, CardRepository $cardRepository)
    {
        $this->boxRepository = $boxRepository;
        $this->cardRepository = $cardRepository;
    }

    public function find(Box $box): ?Card
    {
        $cardId = $this->boxRepository->getFirstCardFromBoxAtCurrentSection($box);
        if (!$cardId) {
            return null;
        }

        return $this->cardRepository->get($cardId);
    }
}
