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
        $this->adjustCurrentSection($box);
        $this->boxRepository->getFirstCardFromBoxAtSection($box);
        return $this->cardRepository->get('');
    }

    private function adjustCurrentSection(Box $box): void
    {
        $currentSection = $box->getCurrentSection();
        if ($this->shouldSkipToNextSection($currentSection)) {
            $box->incrementCurrentSection();
            $this->boxRepository->updateBoxSection($box);
        } else if ($this->shouldRewindToFirstSection($currentSection)) {
            $box->rewindToFirstSection();
            $this->boxRepository->updateBoxSection($box);
        }
    }

    private function shouldSkipToNextSection(int $currentSection): bool
    {
        return $this->isNotLastSection($currentSection) && $this->isLimitExceededInNextSection($currentSection);
    }

    private function isNotLastSection($section): bool
    {
        return $section < count(self::SECTION_THRESHOLDS) - 1;
    }

    private function isLimitExceededInNextSection($currentSection): bool
    {
        $nextSection = $currentSection + 1;
        $numberOfCardsInNextSection = $this->boxRepository->getNumberOfCardsInSection($nextSection);
        return $this->isAboveLimit($numberOfCardsInNextSection, $nextSection);
    }

    private function isAboveLimit($numberOfCardsInNextSection, $nextSection)
    {
        return $numberOfCardsInNextSection >= self::getSectionLimit($nextSection);
    }

    static function getSectionLimit(int $section): int
    {
        return self::SECTION_THRESHOLDS[$section];
    }

    private function shouldRewindToFirstSection(int $currentSection): bool
    {
        return $this->boxRepository->getNumberOfCardsInSection($currentSection) < self::getSectionLimit($currentSection) - self::REWIND_LIMIT;
    }
}
