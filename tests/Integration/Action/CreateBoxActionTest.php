<?php

use Krauza\Core\Policy\IdPolicy;
use Krauza\Core\ValueObject\EntityId;
use Krauza\Core\Entity\User;
use Krauza\Infrastructure\DataAccess\BoxRepository;
use Krauza\Core\UseCase\CreateBox as CreateBoxUseCase;
use Krauza\Infrastructure\Api\Action\CreateBox;
use Doctrine\DBAL\Connection;

class CreateBoxActionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CreateBox
     */
    private $createBoxAction;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $idPolicyMock;

    public function setUp()
    {
        $this->idPolicyMock = $this->getMock(IdPolicy::class);
        $this->idPolicyMock->method('generate')->willReturn(new EntityId('1'));
        $userMock = $this->getMockBuilder(User::class)->disableOriginalConstructor()->getMock();
        $connectionMock = $this->getMockBuilder(Connection::class)->disableOriginalConstructor()->getMock();
        $boxRepositoryMock = new BoxRepository($connectionMock);
        $boxUseCase = new CreateBoxUseCase($boxRepositoryMock, $this->idPolicyMock);
        $this->createBoxAction = new CreateBox($boxUseCase, $userMock);
    }

    /**
     * @test
     */
    public function shouldCreateBox()
    {
        // when
        $result = $this->createBoxAction->action(['name' => 'Box name']);

        // then
        $this->assertEquals(['box' => ['name' => 'Box name', 'id' => '1'], 'errors' => null], $result);
    }

    /**
     * @test
     */
    public function shouldReturnInformationWhenBoxNameIsTooShort()
    {
        // when
        $result = $this->createBoxAction->action(['name' => 'a']);

        // then
        $error = ['errorType' => 'fieldException', 'key' => 'BoxName', 'message' => 'Value is too short'];
        $this->assertEquals(['box' => null, 'errors' => $error], $result);
    }

    /**
     * @test
     */
    public function shouldReturnInformationWhenBoxNameIsTooLong()
    {
        // when
        $longName = '11111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111';
        $result = $this->createBoxAction->action(['name' => $longName]);

        // then
        $error = ['errorType' => 'fieldException', 'key' => 'BoxName', 'message' => 'Value is too long'];
        $this->assertEquals(['box' => null, 'errors' => $error], $result);
    }

    /**
     * @test
     */
    public function shouldReturnInformationWhenErrorWasThrown()
    {
        // when
        $this->idPolicyMock->method('generate')->will($this->throwException(new Exception('Internal error')));
        $result = $this->createBoxAction->action(['name' => 'Box name']);

        // then
        $error = ['errorType' => 'infrastructureException', 'key' => '', 'message' => 'Something went wrong, try again.'];
        $this->assertEquals(['box' => null, 'errors' => $error], $result);
    }
}
