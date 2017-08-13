<?php

namespace Krauza\Core\UseCase;

use Krauza\Core\Entity\Box;
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

    public function add(array $data, User $user): Box
    {
        $box = BoxFactory::createBox($data, $this->idPolicy);
        $this->boxRepository->add($box, $user);

        return $box;
    }
}
