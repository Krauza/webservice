<?php

namespace Krauza\Core\UseCase;

use Krauza\Core\Entity\Box;
use Krauza\Core\Repository\BoxRepository;

class AdjustFirstSection
{
    /**
     * @var BoxRepository
     */
    private $boxRepository;

    public function __construct(BoxRepository $boxRepository)
    {
        $this->boxRepository = $boxRepository;
    }

    public function adjust(Box $box): void
    {
        $currentSection = $box->getCurrentSection();
        if ($this->shouldFillFirstSection($currentSection, $box)) {
            $this->boxRepository->moveCardsFromInboxToFirstSection(Box::MAX_COUNT_OF_NEW_CARDS_FROM_INBOX);
        }
    }

    private function shouldFillFirstSection(int $currentSection, Box $box): bool
    {
        return $currentSection === Box::FIRST_SECTION && $this->firstSectionIsEmpty($box);
    }

    private function firstSectionIsEmpty(Box $box): bool
    {
        return $this->boxRepository->getNumberOfCardsInSection(Box::FIRST_SECTION) < Box::getSectionLimit(Box::FIRST_SECTION) - Box::REWIND_LIMIT;
    }
}