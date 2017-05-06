<?php

namespace Krauza\Core\UseCase;

use Krauza\Core\Entity\Box;
use Krauza\Core\Entity\Card;
use Krauza\Core\Repository\BoxSectionsRepository;
use Krauza\Core\Repository\CardRepository;

class FindNextCard
{
    /**
     * @var BoxSectionsRepository
     */
    private $boxSectionsRepository;

    /**
     * @var CardRepository
     */
    private $cardRepository;

    public function __construct(BoxSectionsRepository $boxSectionsRepository, CardRepository $cardRepository)
    {
        $this->boxSectionsRepository = $boxSectionsRepository;
        $this->cardRepository = $cardRepository;
    }

    public function find(Box $box): ?Card
    {
        $cardId = $this->boxSectionsRepository->getFirstCardFromBoxAtCurrentSection($box);
        if (!$cardId) {
            return null;
        }

        return $this->cardRepository->get($cardId);
    }
}
