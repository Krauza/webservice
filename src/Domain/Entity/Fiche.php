<?php

namespace Fiche\Domain\Entity;

use Fiche\Domain\Service\Entity;
use Fiche\Domain\Service\Exceptions\FieldIsRequired;
use Fiche\Domain\Service\Exceptions\ValueIsTooLong;

class Fiche extends Entity
{
    const MAX_WORD_LENGTH = 255;
    const MAX_EXPLAIN_LENGTH = 1000;

    private $id;
    private $word;
    private $explain_word;
    private $attachment;
    private $group;

    public function __construct(\int $id = null, Group $group, \string $word, \string $explain, Attachment $attachment = null)
    {
        $this->setId($id);
        $this->group = $group;
        $this->word = $word;
        $this->explain_word = $explain;
        $this->attachment = $attachment;
    }

    public function setId(\int $id = null)
    {
        $this->id = $id;
    }

    public static function getFieldsNames(): array
    {
        return [
            'id' => 'int',
            'group_id' => 'int',
            'word' => 'string',
            'explain_word' => 'string',
        ];
    }

    public function getValues(): array
    {
        return [
            'id' => $this->getId(),
            'group_id' => $this->getGroupId(),
            'word' => $this->getWord(),
            'explain_word' => $this->getExplainWord()
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getWord(): string
    {
        return $this->word;
    }

    public function getExplainWord(): string
    {
        return $this->explain_word;
    }

    public function getAttachment(): Attachment
    {
        return $this->attachment;
    }

    public function setWord(\string $word)
    {
        $word = trim($word);
        if(empty($word)) {
            throw new FieldIsRequired('word');
        }

        if(strlen($word) > self::MAX_WORD_LENGTH) {
            throw new ValueIsTooLong('word');
        }

        $this->word = $word;
    }

    public function setExplainWord(\string $explain_word)
    {
        $explain_word = trim($explain_word);
        if(empty($explain_word)) {
            throw new FieldIsRequired('word');
        }

        if(strlen($explain_word) > self::MAX_EXPLAIN_LENGTH) {
            throw new ValueIsTooLong('word');
        }

        $this->explain_word = $explain_word;
    }

    public function getGroup(): Group
    {
        return $this->group;
    }

    public function getGroupId(): int
    {
        return $this->getGroup()->getId();
    }
}
