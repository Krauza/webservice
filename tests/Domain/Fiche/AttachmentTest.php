<?php

declare(strict_types=1);
require_once(__DIR__ . '/../../base/BaseValueObjectTestCase.php');

use Fiche\Domain\ValueObject\Attachment;

/**
 * Class AttachmentTest
 *
 * @property Attachment $attachment
 */
class AttachmentTest extends PHPUnit_Framework_TestCase
{
    private $filePath;
    private $fileName;
    private $attachment;

    public function setUp()
    {
        $this->fileName = 'file.img';
        $this->filePath = '/';
        $this->attachment = new Attachment($this->fileName, $this->filePath);
    }

    /**
     * @test
     */
    public function attachmentShouldHasCorrectFileName()
    {
        $this->assertEquals($this->fileName, $this->attachment->getFilename());
    }

    /**
     * @test
     */
    public function attachmentShouldHasCorrectFilePath()
    {
        $this->assertEquals($this->filePath, $this->attachment->getPath());
    }

    /**
     * @test
     */
    public function attachmentShouldHasCorrectFullPath()
    {
        $this->assertEquals($this->filePath . $this->fileName, $this->attachment);
    }
}
