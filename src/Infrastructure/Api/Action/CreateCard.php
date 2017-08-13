<?php

namespace Krauza\Infrastructure\Api\Action;

use Krauza\Core\Entity\Box;

use Krauza\Core\UseCase\CreateCard as CreateCardUseCase;
use Krauza\Infrastructure\Api\Type\CardType;

final class CreateCard extends Action
{
    /**
     * @var CreateCardUseCase
     */
    private $cardUseCase;

    /**
     * @var Box
     */
    private $box;

    public function __construct(CreateCardUseCase $cardUseCase, Box $box)
    {
        $this->cardUseCase = $cardUseCase;
        $this->box = $box;
    }

    public function action(array $data): array
    {
        $this->tryDoAction(function () use ($data) {
            $card = $this->cardUseCase->add($data);
            $this->cardUseCase->addToBox($card, $this->box);
            return CardType::objectToArray($card);
        });

        return ['card' => $this->result, 'errors' => $this->error];
    }
}
