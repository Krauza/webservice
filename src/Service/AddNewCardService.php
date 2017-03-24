<?php

namespace Krauza\Service;

use Krauza\Factory\CardFactory;
use Krauza\Repository\CardRepository;

class AddNewCardService
{
    private $cardRepository;

    public function __construct(CardRepository $cardRepository)
    {
        $this->cardRepository = $cardRepository;
    }

    public function addNewCard(array $data)
    {
        $card = CardFactory::createCard($data);
        $this->cardRepository->add($card);

        return $card;
    }
}
