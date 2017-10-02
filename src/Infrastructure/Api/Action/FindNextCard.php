<?php

namespace Krauza\Infrastructure\Api\Action;

use Krauza\Core\UseCase\FindNextCard as FindNextCardUseCase;
use Krauza\Infrastructure\DataAccess\BoxRepository;

/**
 * Class FindNextCard
 * @package Krauza\Infrastructure\Api\Action
 */
final class FindNextCard implements Action
{
    /**
     * @var FindNextCardUseCase
     */
    private $findNextCardUseCase;

    /**
     * @var BoxRepository
     */
    private $boxRepository;

    /**
     * FindNextCard constructor.
     * @param FindNextCardUseCase $findNextCard
     * @param BoxRepository $boxRepository
     */
    public function __construct(FindNextCardUseCase $findNextCard, BoxRepository $boxRepository)
    {
        $this->findNextCardUseCase = $findNextCard;
        $this->boxRepository = $boxRepository;
    }

    /**
     * @param array $data
     * @return array
     */
    public function action(array $data): array
    {
        $box = $this->boxRepository->getById($data['box_id']);

        return [
            'card' => $this->findNextCardUseCase->find($box),
            'box' => $box
        ];
    }
}
