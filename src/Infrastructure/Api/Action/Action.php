<?php

namespace Krauza\Infrastructure\Api\Action;

interface Action
{
    public function action(array $data): array;
}
