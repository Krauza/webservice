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
        return $this->getCard($box);
    }

    private function getCard(Box $box)
    {
        $cardId = $this->boxRepository->getFirstCardFromBoxAtSection($box);

        if ($cardId) {
            return $this->cardRepository->get($cardId);
        }

        $newSection = $this->boxRepository->getNotEmptySection();
        if ($newSection === null) {
            return null;
        }

        $box->setCurrentSection($newSection);
        $this->boxRepository->updateBoxSection($box);
        $cardId = $this->boxRepository->getFirstCardFromBoxAtSection($box);
        return $this->cardRepository->get($cardId);
    }
}
