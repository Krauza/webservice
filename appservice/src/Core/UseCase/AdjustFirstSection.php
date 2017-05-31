<?php

namespace Krauza\Core\UseCase;

use Krauza\Core\Entity\Box;
use Krauza\Core\Repository\BoxSectionsRepository;

class AdjustFirstSection
{
    /**
     * @var BoxSectionsRepository
     */
    private $boxSectionsRepository;

    public function __construct(BoxSectionsRepository $boxSectionsRepository)
    {
        $this->boxSectionsRepository = $boxSectionsRepository;
    }

    public function adjust(Box $box): void
    {
        $currentSection = $box->getCurrentSection();
        if ($this->shouldFillFirstSection($currentSection, $box)) {
            $this->boxSectionsRepository->moveCardsFromInboxToFirstSection($box, Box::MAX_COUNT_OF_NEW_CARDS_FROM_INBOX);
        }
    }

    private function shouldFillFirstSection(int $currentSection, Box $box): bool
    {
        return $currentSection === Box::FIRST_SECTION && $this->firstSectionIsEmpty($box);
    }

    private function firstSectionIsEmpty(Box $box): bool
    {
        return $this->boxSectionsRepository->getNumberOfCardsInSection($box, Box::FIRST_SECTION) < Box::getSectionLimit(Box::FIRST_SECTION) - Box::REWIND_LIMIT;
    }
}