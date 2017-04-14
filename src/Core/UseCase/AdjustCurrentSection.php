<?php

namespace Krauza\Core\UseCase;

use Krauza\Core\Entity\Box;
use Krauza\Core\Repository\BoxRepository;

class AdjustCurrentSection
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
        return $section < Box::LAST_SECTION;
    }

    private function isLimitExceededInNextSection($currentSection): bool
    {
        $nextSection = $currentSection + 1;
        $numberOfCardsInNextSection = $this->boxRepository->getNumberOfCardsInSection($nextSection);
        return $this->isAboveLimit($numberOfCardsInNextSection, $nextSection);
    }

    private function isAboveLimit($numberOfCardsInNextSection, $nextSection)
    {
        return $numberOfCardsInNextSection >= Box::getSectionLimit($nextSection);
    }

    private function shouldRewindToFirstSection(int $currentSection): bool
    {
        return $this->boxRepository->getNumberOfCardsInSection($currentSection) < Box::getSectionLimit($currentSection) - Box::REWIND_LIMIT;
    }
}