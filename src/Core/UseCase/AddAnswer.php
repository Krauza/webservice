<?php

namespace Krauza\Core\UseCase;

use Krauza\Core\Entity\Box;
use Krauza\Core\Entity\Card;
use Krauza\Core\Repository\BoxRepository;

class AddAnswer
{
    public function __construct(BoxRepository $boxRepository)
    {
        $this->boxRepository = $boxRepository;
    }

    public function answer(bool $isCorrectAnswer, Box $box, Card $card)
    {
        $fromSection = $this->boxRepository->getBoxSectionByCard($box, $card);

        if ($fromSection < 4) {
            $toSection = $isCorrectAnswer ? $fromSection + 1 : 0;
            $this->boxRepository->moveCardBetweenBoxSections($fromSection, $toSection, $box, $card);
        } else {
            $this->boxRepository->setCardAsArchived($box, $card);
        }
    }
}
