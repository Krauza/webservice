<?php

namespace Fiche\Domain\ValueObject;

class Attachment
{
    private $filename;
    private $path;

    public function __construct($filename, $path)
    {
        $this->filename = $filename;
        $this->path = $path;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function __toString()
    {
        return $this->getPath() . $this->getFilename();
    }
}
