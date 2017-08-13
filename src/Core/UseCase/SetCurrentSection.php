<?php

namespace Krauza\Core\UseCase;

use Krauza\Core\Entity\Box;
use Krauza\Core\Repository\BoxRepository;
use Krauza\Core\Repository\BoxSectionsRepository;

class SetCurrentSection
{
    /**
     * @var BoxRepository
     */
    private $boxRepository;

    /**
     * @var BoxSectionsRepository
     */
    private $boxSectionsRepository;

    public function __construct(BoxRepository $boxRepository, BoxSectionsRepository $boxSectionsRepository)
    {
        $this->boxRepository = $boxRepository;
        $this->boxSectionsRepository = $boxSectionsRepository;
    }

    public function adjust(Box $box): void
    {
        $currentSection = $box->getCurrentSection();
        if ($this->shouldSkipToNextSection($box, $currentSection)) {
            $box->incrementCurrentSection();
            $this->boxRepository->updateBoxSection($box);
        } else if ($this->shouldRewindToFirstSection($box, $currentSection)) {
            $box->rewindToFirstSection();
            $this->boxRepository->updateBoxSection($box);
        }

        if ($this->isCurrentSectionEmpty($box)) {
            $newSection = $this->boxSectionsRepository->getNotEmptySection($box);
            if ($newSection === null) {
                return;
            }

            $box->setCurrentSection($newSection);
            $this->boxRepository->updateBoxSection($box);
        }
    }

    private function shouldSkipToNextSection(Box $box, int $currentSection): bool
    {
        return $this->isNotLastSection($currentSection) && $this->isLimitExceededInNextSection($box, $currentSection);
    }

    private function isNotLastSection($section): bool
    {
        return $section < Box::LAST_SECTION;
    }

    private function isLimitExceededInNextSection(Box $box, $currentSection): bool
    {
        $nextSection = $currentSection + 1;
        $numberOfCardsInNextSection = $this->boxSectionsRepository->getNumberOfCardsInSection($box, $nextSection);
        return $this->isAboveLimit($numberOfCardsInNextSection, $nextSection);
    }

    private function isAboveLimit($numberOfCardsInNextSection, $nextSection)
    {
        return $numberOfCardsInNextSection >= Box::getSectionLimit($nextSection);
    }

    private function shouldRewindToFirstSection(Box $box, int $currentSection): bool
    {
        return $this->boxSectionsRepository->getNumberOfCardsInSection($box, $currentSection) < Box::getSectionLimit($currentSection) - Box::REWIND_LIMIT;
    }

    private function isCurrentSectionEmpty(Box $box)
    {
        return $this->boxSectionsRepository->getNumberOfCardsInSection($box, $box->getCurrentSection()) === 0;
    }
}
