<?php

namespace Krauza\Service;

use Krauza\Factory\CardFactory;
use Krauza\Policy\IdPolicy;
use Krauza\Repository\CardRepository;

class AddNewCardService
{
    private $cardRepository;
    private $idPolicy;

    public function __construct(CardRepository $cardRepository, IdPolicy $idPolicy)
    {
        $this->cardRepository = $cardRepository;
        $this->idPolicy = $idPolicy;
    }

    public function addNewCard(array $data)
    {
        $card = CardFactory::createCard($data, $this->idPolicy);
        $this->cardRepository->add($card);

        return $card;
    }
}
