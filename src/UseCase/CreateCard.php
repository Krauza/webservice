<?php

namespace Krauza\UseCase;

use Krauza\Entity\Box;
use Krauza\Entity\Card;
use Krauza\Factory\CardFactory;
use Krauza\Policy\IdPolicy;
use Krauza\Repository\BoxRepository;
use Krauza\Repository\CardRepository;

class CreateCard
{
    private $cardRepository;
    private $boxRepository;
    private $idPolicy;

    public function __construct(CardRepository $cardRepository, BoxRepository $boxRepository, IdPolicy $idPolicy)
    {
        $this->cardRepository = $cardRepository;
        $this->boxRepository = $boxRepository;
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
        $this->boxRepository->addCardToInbox($box, $card);
    }
}
