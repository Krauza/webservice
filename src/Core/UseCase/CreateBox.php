<?php

namespace Krauza\Core\UseCase;

use Krauza\Core\Entity\User;
use Krauza\Core\Factory\BoxFactory;
use Krauza\Core\Policy\IdPolicy;
use Krauza\Core\Repository\BoxRepository;

class CreateBox
{
    private $boxRepository;
    private $idPolicy;

    public function __construct(BoxRepository $boxRepository, IdPolicy $idPolicy)
    {
        $this->boxRepository = $boxRepository;
        $this->idPolicy = $idPolicy;
    }

    public function add(array $data, User $user)
    {
        $card = BoxFactory::createBox($data, $this->idPolicy);
        $this->boxRepository->add($card, $user);
    }
}
