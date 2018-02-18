<?php
/**
 * This file is part of the GMaissa Behat Context Extension
 *
 * @package   GMaissa\BehatContextsExtension
 * @author    Guillaume Maïssa <guillaume@maissa.fr>
 * @copyright 2017 Guillaume Maïssa
 * @license   https://opensource.org/licenses/MIT MIT
 */

namespace GMaissa\BehatContextsExtension\Test\Unit\Utils;

use GMaissa\BehatContextsExtension\Exception\Timeout;
use GMaissa\BehatContextsExtension\Utils\SpinTrait;
use PHPUnit\Framework\TestCase;

/**
 * Spin Trait Test Class
 */
class SpinTraitTest extends TestCase
{
    private $traitMock;

    protected function setUp()
    {
        parent::setUp();
        $this->traitMock = $this->getMockForTrait(SpinTrait::class);
        $this->traitMock->setTimeout(5);
    }

    /**
     * @dataProvider provideSpin
     */
    public function testSpin($callable)
    {
        $this->assertTrue($this->traitMock->spin($callable));
    }

    public function provideSpin()
    {
        return [
            [function () { sleep(2); return true;}]
        ];
    }

    /**
     * @dataProvider provideSpinException
     */
    public function testSpinException($callable, $message, $expectedExceptionMsg)
    {
        $this->expectException('\GMaissa\BehatContextsExtension\Exception\Timeout');
        $this->expectExceptionMessage($expectedExceptionMsg);
        $this->traitMock->spin($callable, $message);
    }

    public function provideSpinException()
    {
        $callableTooLong = function () {
            sleep(7);
        };
        $callableUnvalid = function () {
            sleep(1);
            return null;
        };
        $callableWithGenericException = function () {
            sleep(1);
            throw new \Exception('Test trait exception');
        };
        $callableWithTimeoutException = function () {
            sleep(1);
            throw new Timeout('Test trait exception');
        };

        return [
            [
                $callableTooLong,
                null,
                'Spin : timeout of 5 exceeded, with message : no message'
            ],
            [
                $callableTooLong,
                'Custom message',
                'Spin : timeout of 5 exceeded, with message : Custom message'
            ],
            [
                $callableUnvalid,
                null,
                'Spin : timeout of 5 exceeded, with message : no message'
            ],
            [
                $callableUnvalid,
                'Custom message',
                'Spin : timeout of 5 exceeded, with message : Custom message'
            ],
            [
                $callableWithGenericException,
                null,
                'Spin : timeout of 5 exceeded, with message : Test trait exception'
            ],
            [
                $callableWithGenericException,
                'Custom message',
                'Spin : timeout of 5 exceeded, with message : Custom message'
            ],
            [
                $callableWithTimeoutException,
                null,
                'Spin : timeout of 5 exceeded, with message : Test trait exception'
            ],
            [
                $callableWithTimeoutException,
                'Custom message',
                'Spin : timeout of 5 exceeded, with message : Custom message'
            ]
        ];
    }
}
