<?php

namespace Krauza\UseCase;

use Krauza\Entity\Box;
use Krauza\Entity\Card;
use Krauza\Repository\BoxRepository;
use Krauza\Repository\CardRepository;

class FindNextCard
{
    const SECTION_THRESHOLDS = [50, 100, 200, 320, 500];
    const REWIND_LIMIT = 40;

    private $boxRepository;
    private $cardRepository;

    public function __construct(BoxRepository $boxRepository, CardRepository $cardRepository)
    {
        $this->boxRepository = $boxRepository;
        $this->cardRepository = $cardRepository;
    }

    public function find(Box $box): Card
    {
        if ($this->shouldSkipToNextSection($box)) {
            $box->incrementCurrentSection();
            $this->boxRepository->updateBoxSection($box);
        }

        $this->boxRepository->getCardIdFromBoxAtSection($box);
        return $this->cardRepository->get('');
    }

    private function shouldSkipToNextSection(Box $box): bool
    {
        $currentSection = $box->getCurrentSection();
        return $this->isNotLastSection($currentSection) && $this->isLimitExceededInNextSection($currentSection);
    }

    private function isNotLastSection($section): bool
    {
        return $section < count(self::SECTION_THRESHOLDS) - 1;
    }

    private function isLimitExceededInNextSection($section): bool
    {
        $numberOfCardsInNextSection = $this->boxRepository->getNumberOfCardsInSection($section + 1);
        return $numberOfCardsInNextSection >= self::getSectionLimit($section) && $numberOfCardsInNextSection < self::getSectionLimit($section + 1);
    }

    static function getSectionLimit(int $section): int
    {
        return self::SECTION_THRESHOLDS[$section];
    }
}
