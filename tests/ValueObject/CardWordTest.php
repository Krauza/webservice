<?php

use Krauza\ValueObject\CardWord;

class CardWordTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldCreateUserName()
    {
        $word = 'Card Word';
        $userName = new CardWord($word);
        $this->assertEquals($word, (string) $userName);
    }

    /**
     * @test
     * @expectedException Krauza\Exception\ValueIsTooShort
     */
    public function shouldThrowExceptionWhenWordCardIsEmpty()
    {
        new CardWord('');
    }

    /**
     * @test
     * @expectedException Krauza\Exception\ValueIsTooShort
     */
    public function shouldThrowExceptionWhenWordCardIsTooShort()
    {
        new CardWord('a');
    }

    /**
     * @test
     * @expectedException Krauza\Exception\ValueIsTooLong
     */
    public function shouldThrowExceptionWhenWordIsTooLong()
    {
        new CardWord('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas aliquet feugiat metus in laoreet.
            Duis fringilla mauris sagittis dui ullamcorper, ut mollis quam bibendum. Quisque posuere eros ante, in bibendum
            mauris lacinia a. Morbi eleifend, urna id cursus tempus, dolor ligula tempor diam, id varius odio libero vel leo.
            Fusce eu eros ipsum. Cras et maximus nisi. In purus orci, elementum vel rhoncus sit amet, ornare nec dui. Proin
            posuere finibus risus, a semper nisi mattis sit amet. Cras blandit libero ac nisl euismod, nec condimentum tellus
            bibendum. Nunc egestas sem sit amet pellentesque bibendum. Nam gravida, magna eu ultrices.');
    }
}
