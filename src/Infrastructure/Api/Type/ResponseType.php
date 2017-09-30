<?php

namespace Krauza\Infrastructure\Api\Type;

interface ResponseType
{
    public static function toResponseFormat(array $result): array;
}