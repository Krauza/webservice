<?php

namespace Krauza\Infrastructure\Api\Action;

use Krauza\Core\UseCase\AddAnswer as AddAnswerUseCase;
use Krauza\Core\Repository\BoxRepository;
use Krauza\Core\Repository\CardRepository;

/**
 * Class AddAnswer
 * @package Krauza\Infrastructure\Api\Action
 */
final class AddAnswer
{
    /**
     * @var AddAnswerUseCase
     */
    private $addAnswerUseCase;

    /**
     * @var BoxRepository
     */
    private $boxRepository;

    /**
     * @var CardRepository
     */
    private $cardRepository;

    /**
     * AddAnswer constructor.
     * @param AddAnswerUseCase $addAnswerUseCase
     * @param CardRepository $cardRepository
     * @param BoxRepository $boxRepository
     */
    public function __construct(AddAnswerUseCase $addAnswerUseCase, CardRepository $cardRepository, BoxRepository $boxRepository)
    {
        $this->addAnswerUseCase = $addAnswerUseCase;
        $this->boxRepository = $boxRepository;
        $this->cardRepository = $cardRepository;
    }

    /**
     * @param array $data
     * @return array
     */
    public function action(array $data): array
    {
        $card = $this->cardRepository->get($data['card_id']);
        $box = $this->boxRepository->getById($data['box_id']);
        $this->addAnswerUseCase->answer($data['answer'], $box, $card);

        return [
            'box' => $box,
            'card' => $card
        ];
    }
}
