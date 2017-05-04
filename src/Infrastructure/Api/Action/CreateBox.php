<?php

namespace Krauza\Infrastructure\Api\Action;

use Krauza\Core\Entity\User;
use Krauza\Core\UseCase\CreateBox as CreateBoxUseCase;
use Krauza\Infrastructure\Api\Type\BoxType;

class CreateBox extends Action
{
    /**
     * @var CreateBoxUseCase
     */
    private $boxUseCase;

    /**
     * @var User
     */
    private $currentUser;

    public function __construct(CreateBoxUseCase $boxUseCase, User $currentUser)
    {
        $this->boxUseCase = $boxUseCase;
        $this->currentUser = $currentUser;
    }

    public function action(array $data): array
    {
        $this->tryDoAction(function () use ($data) {
            $newBox = $this->boxUseCase->add($data, $this->currentUser);
            return BoxType::objectToArray($newBox);
        });

        return ['box' => $this->result, 'errors' => $this->error];
    }
}
