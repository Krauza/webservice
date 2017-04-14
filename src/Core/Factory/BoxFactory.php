<?php

namespace Krauza\Core\Factory;

use Krauza\Core\Entity\Box;
use Krauza\Core\Policy\IdPolicy;
use Krauza\Core\ValueObject\BoxName;

class BoxFactory
{
    public static function createBox(array $data, IdPolicy $idPolicy): Box
    {
        $name = new BoxName($data['name']);

        $box = new Box($name);
        $box->setId($idPolicy->generate());

        return $box;
    }
}
