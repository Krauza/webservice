<?php

namespace Krauza\Core\UseCase;

use Krauza\Core\Entity\Box;
use Krauza\Core\Entity\Card;
use Krauza\Core\Repository\BoxSectionsRepository;

class AddAnswer
{
    /**
     * @var BoxSectionsRepository
     */
    private $boxSectionsRepository;

    public function __construct(BoxSectionsRepository $boxSectionsRepository)
    {
        $this->boxSectionsRepository = $boxSectionsRepository;
    }

    public function answer(bool $isCorrectAnswer, Box $box, Card $card)
    {
        $fromSection = $this->boxSectionsRepository->getBoxSectionByCard($box, $card);

        if ($fromSection < Box::LAST_SECTION) {
            $toSection = $isCorrectAnswer ? $fromSection + 1 : Box::FIRST_SECTION;
            $this->boxSectionsRepository->moveCardBetweenBoxSections($box, $card, $fromSection, $toSection);
        } else {
            $this->boxSectionsRepository->setCardAsArchived($box, $card);
        }
    }
}
