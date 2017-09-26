<?php

namespace Krauza\Infrastructure\Api\Action;

use Krauza\Core\Entity\Box;
use Krauza\Core\Entity\User;
use Krauza\Core\UseCase\CreateBox as CreateBoxUseCase;

/**
 * Class CreateBox
 * @package Krauza\Infrastructure\Api\Action
 */
final class CreateBox
{
    /**
     * @var CreateBoxUseCase
     */
    private $boxUseCase;

    /**
     * @var User
     */
    private $currentUser;

    /**
     * CreateBox constructor.
     * @param CreateBoxUseCase $boxUseCase
     * @param User $currentUser
     */
    public function __construct(CreateBoxUseCase $boxUseCase, User $currentUser)
    {
        $this->boxUseCase = $boxUseCase;
        $this->currentUser = $currentUser;
    }

    /**
     * @param array $data
     * @return Box
     */
    public function action(array $data): Box
    {
        return $this->boxUseCase->add($data, $this->currentUser);
    }
}
