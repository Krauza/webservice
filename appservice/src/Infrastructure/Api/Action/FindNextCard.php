<?php

namespace Krauza\Infrastructure\Api\Action;

use Krauza\Core\UseCase\AdjustFirstSection;
use Krauza\Core\UseCase\FindNextCard as FindNextCardUseCase;
use Krauza\Core\UseCase\SetCurrentSection;
use Krauza\Infrastructure\Api\Type\CardType;
use Krauza\Infrastructure\DataAccess\BoxRepository;

final class FindNextCard extends Action
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
     * @var AdjustFirstSection
     */
    private $adjustFirstSectionUseCase;

    /**
     * @var SetCurrentSection
     */
    private $adjustCurrentSection;

    public function __construct(FindNextCardUseCase $findNextCard, AdjustFirstSection $adjustFirstSection,
        SetCurrentSection $currentSection, BoxRepository $boxRepository)
    {
        $this->findNextCardUseCase = $findNextCard;
        $this->boxRepository = $boxRepository;
        $this->adjustFirstSectionUseCase = $adjustFirstSection;
        $this->adjustCurrentSection = $currentSection;
    }

    public function action(array $data): array
    {
        $this->tryDoAction(function () use ($data) {
            $box = $this->boxRepository->getById($data['box_id']);
            $this->adjustCurrentSection->adjust($box);
            $this->adjustFirstSectionUseCase->adjust($box);

            $card = $this->findNextCardUseCase->find($box);
            return $card ? CardType::objectToArray($card) : null;
        });

        return $this->result;
    }
}
