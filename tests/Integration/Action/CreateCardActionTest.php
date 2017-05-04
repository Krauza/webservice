<?php

require __DIR__ . '/../../Utils/StringBuilder.php';

use Krauza\Core\Policy\IdPolicy;
use Krauza\Core\ValueObject\EntityId;
use Krauza\Infrastructure\DataAccess\CardRepository;
use Krauza\Infrastructure\DataAccess\BoxRepository;
use Krauza\Core\UseCase\CreateCard as CreateCardUseCase;
use Krauza\Infrastructure\Api\Action\CreateCard;
use Krauza\Core\Factory\BoxFactory;
use Doctrine\DBAL\Connection;

class CreateCardActionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CreateCard
     */
    private $createCardAction;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $idPolicyMock;

    public function setUp()
    {
        $this->idPolicyMock = $this->getMock(IdPolicy::class);
        $this->idPolicyMock->method('generate')->willReturn(new EntityId('1'));

        $connectionMock = $this->getMockBuilder(Connection::class)->disableOriginalConstructor()->getMock();
        $cardRepository = new CardRepository($connectionMock);
        $boxRepository = new BoxRepository($connectionMock);
        $cardUseCase = new CreateCardUseCase($cardRepository, $boxRepository, $this->idPolicyMock);

        $box = BoxFactory::createBox(['name' => 'Box name', 'id' => '1'], $this->idPolicyMock);
        $this->createCardAction = new CreateCard($cardUseCase, $box);
    }

    /**
     * @test
     */
    public function shouldCreateCardAndReturnBox()
    {
        // when
        $result = $this->createCardAction->action(['obverse' => 'First', 'reverse' => 'Second']);

        // then
        $this->assertEquals(['box' => ['name' => 'Box name', 'id' => '1'], 'errors' => null], $result);
    }

    /**
     * @test
     */
    public function shouldReturnErrorsWhenObverseIsTooShort()
    {
        // when
        $result = $this->createCardAction->action(['obverse' => 'F', 'reverse' => 'Second']);

        // then
        $this->assertEquals(['box' => null, 'errors' =>
            ['errorType' => 'fieldException', 'key' => 'CardWord', 'message' => 'Value is too short']
        ], $result);
    }

    /**
     * @test
     */
    public function shouldReturnErrorsWhenReverseIsTooShort()
    {
        // when
        $result = $this->createCardAction->action(['obverse' => 'First', 'reverse' => 'S']);

        // then
        $this->assertEquals(['box' => null, 'errors' =>
            ['errorType' => 'fieldException', 'key' => 'CardWord', 'message' => 'Value is too short']
        ], $result);
    }

    /**
     * @test
     */
    public function shouldReturnErrorsWhenObverseIsTooLong()
    {
        // when
        $result = $this->createCardAction->action(['obverse' => StringBuilder::createStringWithNumberOfSymbols(513), 'reverse' => 'Second']);

        // then
        $this->assertEquals(['box' => null, 'errors' =>
            ['errorType' => 'fieldException', 'key' => 'CardWord', 'message' => 'Value is too long']
        ], $result);
    }

    /**
     * @test
     */
    public function shouldReturnErrorsWhenReverseIsTooLong()
    {
        // when
        $result = $this->createCardAction->action(['obverse' => 'First', 'reverse' => StringBuilder::createStringWithNumberOfSymbols(513)]);

        // then
        $this->assertEquals(['box' => null, 'errors' =>
            ['errorType' => 'fieldException', 'key' => 'CardWord', 'message' => 'Value is too long']
        ], $result);
    }

    /**
     * @test
     */
    public function shouldReturnInformationWhenErrorWasThrown()
    {
        // when
        $this->idPolicyMock->method('generate')->will($this->throwException(new Exception('Internal error')));
        $result = $this->createCardAction->action(['name' => 'Box name']);

        // then
        $error = ['errorType' => 'infrastructureException', 'key' => '', 'message' => 'Something went wrong, try again.'];
        $this->assertEquals(['box' => null, 'errors' => $error], $result);
    }
}
