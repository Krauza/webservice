<?php
namespace Fiche;

class Fiche
{
    private $id;
    private $word;
    private $explain;
    private $attachment;

    public function __construct(string $word, string $explain, Attachment $attachment = null)
    {
        $this->word = $word;
        $this->explain = $explain;
        $this->attachment = $attachment;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getWord(): string
    {
        return $this->word;
    }

    public function getExplain(): string
    {
        return $this->explain;
    }

    public function getAttachment(): Attachment
    {
        return $this->attachment;
    }
}
