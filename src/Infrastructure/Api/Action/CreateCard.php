<?php

namespace Krauza\Infrastructure\Api\Action;

use Krauza\Core\UseCase\CreateCard as CreateCardUseCase;
use Krauza\Core\Repository\BoxRepository;

/**
 * Class CreateCard
 * @package Krauza\Infrastructure\Api\Action
 */
final class CreateCard implements Action
{
    /**
     * @var CreateCardUseCase
     */
    private $cardUseCase;

    /**
     * @var BoxRepository
     */
    private $boxRepository;

    /**
     * CreateCard constructor.
     * @param CreateCardUseCase $cardUseCase
     * @param BoxRepository $boxRepository
     */
    public function __construct(CreateCardUseCase $cardUseCase, BoxRepository $boxRepository)
    {
        $this->cardUseCase = $cardUseCase;
        $this->boxRepository = $boxRepository;
    }

    /**
     * @param array $data
     * @return array
     */
    public function action(array $data): array
    {
        $box = $this->boxRepository->getById($data['box_id']);
        $card = $this->cardUseCase->add($data);
        $this->cardUseCase->addToBox($card, $box);

        return [
            'card' => $card,
            'box' => $box
        ];
    }
}
