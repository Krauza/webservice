<?php

namespace Krauza\Infrastructure\Api\Action;

use Krauza\Core\UseCase\FindNextCard as FindNextCardUseCase;
use Krauza\Infrastructure\Api\Type\CardType;
use Krauza\Infrastructure\Api\Type\ErrorType;
use Krauza\Infrastructure\DataAccess\BoxRepository;

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

    public function __construct(FindNextCardUseCase $findNextCard, BoxRepository $boxRepository)
    {
        $this->findNextCardUseCase = $findNextCard;
        $this->boxRepository = $boxRepository;
    }

    public function action(array $data): array
    {
        try {
            $box = $this->boxRepository->getById($data['box_id']);
            $card = $this->findNextCardUseCase->find($box);
            file_put_contents('php://stdout', "www " . $card->getObverse());
            return CardType::objectToArray($card);
        } catch (\Exception $exception) {
            return ErrorType::buildArray('infrastructureException', '', 'Something went wrong, try again.');
        }
    }
}
