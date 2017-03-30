<?php

namespace Krauza\Factory;

use Krauza\Entity\Box;
use Krauza\Policy\IdPolicy;
use Krauza\ValueObject\BoxName;

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
