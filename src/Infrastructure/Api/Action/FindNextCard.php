<?php

namespace Krauza\Infrastructure\Api\Action;

use Krauza\Core\Entity\Card;
use Krauza\Core\UseCase\FindNextCard as FindNextCardUseCase;
use Krauza\Infrastructure\DataAccess\BoxRepository;

/**
 * Class FindNextCard
 * @package Krauza\Infrastructure\Api\Action
 */
final class FindNextCard
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
     * @return Card
     */
    public function action(array $data): Card
    {
        $box = $this->boxRepository->getById($data['box_id']);
        return $this->findNextCardUseCase->find($box);
    }
}
