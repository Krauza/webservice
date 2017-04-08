<?php

namespace Krauza\UseCase;

use Krauza\Entity\Box;
use Krauza\Entity\Card;
use Krauza\Repository\BoxRepository;
use Krauza\Repository\CardRepository;

class FindNextCard
{
    const LIMIT_THRESHOLDS = [50, 100, 200, 300, 400, 500];

    private $boxRepository;
    private $cardRepository;

    public function __construct(BoxRepository $boxRepository, CardRepository $cardRepository)
    {
        $this->boxRepository = $boxRepository;
        $this->cardRepository = $cardRepository;
    }

    public function find(Box $box): Card
    {
        $currentSection = $box->getCurrentSection();
        $numberOfCardsInNextSection = $this->boxRepository->getNumberOfCardsInSection($currentSection + 1);
        if ($numberOfCardsInNextSection >= self::LIMIT_THRESHOLDS[$currentSection] && $numberOfCardsInNextSection < self::LIMIT_THRESHOLDS[$currentSection + 1]) {
            $box->incrementCurrentSection();
            $currentSection++;
            echo 'aaa';
        }

        $this->boxRepository->getCardIdFromBoxAtSection($box, $currentSection);
        return $this->cardRepository->get('');
    }
}
