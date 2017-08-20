<?php

namespace Krauza\Infrastructure\Api\Action;

use Krauza\Core\Entity\Box;

use Krauza\Core\Entity\Card;
use Krauza\Core\UseCase\AddAnswer as AddAnswerUseCase;
use Krauza\Core\UseCase\CreateCard as CreateCardUseCase;
use Krauza\Infrastructure\Api\Type\AddAnswerType;
use Krauza\Infrastructure\Api\Type\CardType;

final class AddAnswer extends Action
{
    /**
     * @var CreateCardUseCase
     */
    private $addAnswerUseCase;

    /**
     * @var Box
     */
    private $box;

    /**
     * @var Card
     */
    private $card;

    public function __construct(AddAnswerUseCase $addAnswerUseCase, Card $card, Box $box)
    {
        $this->addAnswerUseCase = $addAnswerUseCase;
        $this->box = $box;
        $this->card = $card;
    }

    public function action(array $data): array
    {
        $this->tryDoAction(function () use ($data) {
            $this->addAnswerUseCase->answer($data['answer'], $this->box, $this->card);
            return AddAnswerType::objectToArray($this->box);
        });

        return ['box' => $this->result, 'error' => $this->error];
    }
}
