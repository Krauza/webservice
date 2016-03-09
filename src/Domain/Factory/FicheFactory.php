<?php

namespace Fiche\Domain\Factory;

use Fiche\Domain\Entity\Fiche;
use Fiche\Domain\Entity\Group;
use Fiche\Domain\Policy\UniqueIdInterface;
use Fiche\Domain\ValueObject\FicheExplain;
use Fiche\Domain\ValueObject\FicheWord;

class FicheFactory
{
	public static function create(UniqueIdInterface $id, Group $group, $word, $explain, $attachment = null): Fiche
	{
		$word = new FicheWord($word);
		$explain = new FicheExplain($explain);

		return new Fiche($id, $group, $word, $explain, $attachment);
	}
}
