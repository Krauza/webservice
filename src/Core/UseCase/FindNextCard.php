<?php

namespace Krauza\Core\UseCase;

use Krauza\Core\Entity\Box;
use Krauza\Core\Entity\Card;
use Krauza\Core\Exception\BoxIsEmpty;
use Krauza\Core\Repository\BoxRepository;
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

    /**
     * @var BoxRepository
     */
    private $boxRepository;

    public function __construct(BoxSectionsRepository $boxSectionsRepository, BoxRepository $boxRepository, CardRepository $cardRepository)
    {
        $this->boxSectionsRepository = $boxSectionsRepository;
        $this->boxRepository = $boxRepository;
        $this->cardRepository = $cardRepository;
    }

    public function find(Box $box): ?Card
    {
        $this->setCurrentSection($box);
        $this->adjustFirstSection($box);
        $cardId = $this->boxSectionsRepository->getFirstCardFromBoxAtCurrentSection($box);

        if (!$cardId) {
            throw new BoxIsEmpty;
        }

        return $this->cardRepository->get($cardId);
    }

    private function setCurrentSection(Box $box): void
    {
        $setCurrentSection = new SetCurrentSection($this->boxRepository, $this->boxSectionsRepository);
        $setCurrentSection->adjust($box);
    }

    private function adjustFirstSection(Box $box): void
    {
        $adjustFirstSection = new AdjustFirstSection($this->boxSectionsRepository);
        $adjustFirstSection->adjust($box);
    }
}
