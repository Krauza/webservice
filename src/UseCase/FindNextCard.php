<?php

namespace Krauza\UseCase;

use Krauza\Entity\Box;
use Krauza\Entity\Card;
use Krauza\Repository\BoxRepository;
use Krauza\Repository\CardRepository;

class FindNextCard
{
    const SECTION_THRESHOLDS = [50, 100, 200, 320, 500];
    const LAST_SECTION = 4;
    const REWIND_LIMIT = 40;
    const MAX_COUNT_OF_NEW_CARDS_FROM_INBOX = 20;

    private $boxRepository;
    private $cardRepository;

    public function __construct(BoxRepository $boxRepository, CardRepository $cardRepository)
    {
        $this->boxRepository = $boxRepository;
        $this->cardRepository = $cardRepository;
    }

    public function find(Box $box): ?Card
    {
        $this->adjustCurrentSection($box);
        $this->adjustFirstSection($box);
        return $this->getCard($box);
    }

    public static function getSectionLimit(int $section): int
    {
        return self::SECTION_THRESHOLDS[$section];
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

    private function shouldSkipToNextSection(int $currentSection): bool
    {
        return $this->isNotLastSection($currentSection) && $this->isLimitExceededInNextSection($currentSection);
    }

    private function isNotLastSection($section): bool
    {
        return $section < self::LAST_SECTION;
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

    private function shouldRewindToFirstSection(int $currentSection): bool
    {
        return $this->boxRepository->getNumberOfCardsInSection($currentSection) < self::getSectionLimit($currentSection) - self::REWIND_LIMIT;
    }

    private function adjustFirstSection(Box $box): void
    {
        $currentSection = $box->getCurrentSection();
        if ($this->shouldFillFirstSection($currentSection)) {
            $this->boxRepository->moveCardsFromInboxToFirstSection(self::MAX_COUNT_OF_NEW_CARDS_FROM_INBOX);
        }
    }

    private function shouldFillFirstSection(int $currentSection): bool
    {
        return $currentSection === 0 && $this->shouldRewindToFirstSection($currentSection);
    }
}
