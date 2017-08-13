<?php

namespace Krauza\Core\UseCase;

use Krauza\Core\Entity\Box;
use Krauza\Core\Entity\Card;
use Krauza\Core\Factory\CardFactory;
use Krauza\Core\Policy\IdPolicy;
use Krauza\Core\Repository\BoxSectionsRepository;
use Krauza\Core\Repository\CardRepository;

class CreateCard
{
    private $cardRepository;
    private $boxSectionsRepository;
    private $idPolicy;

    public function __construct(CardRepository $cardRepository, BoxSectionsRepository $boxSectionsRepository, IdPolicy $idPolicy)
    {
        $this->cardRepository = $cardRepository;
        $this->boxSectionsRepository = $boxSectionsRepository;
        $this->idPolicy = $idPolicy;
    }

    public function add(array $data)
    {
        $card = CardFactory::createCard($data, $this->idPolicy);
        $this->cardRepository->add($card);

        return $card;
    }

    public function addToBox(Card $card, Box $box)
    {
        $this->boxSectionsRepository->addCardToInbox($box, $card);
    }
}
