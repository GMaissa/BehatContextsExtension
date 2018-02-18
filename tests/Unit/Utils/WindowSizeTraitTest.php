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

use GMaissa\BehatContextsExtension\Utils\WindowSizeTrait;
use PHPUnit\Framework\TestCase;

/**
 * Browser Window Size definition Trait
 */
class WindowSizeTraitTest extends TestCase
{
    private $traitMock;

    protected function setUp()
    {
        parent::setUp();
        $this->traitMock = $this->getMockForTrait(WindowSizeTrait::class);
    }

    /**
     * @dataProvider provideGetSetWindowSize
     */
    public function testGetSetWindowSize($width, $height)
    {
        $this->traitMock->setWindowSize($width, $height);

        $this->assertEquals(
            ['width' => $width, 'height' => $height],
            $this->traitMock->getWindowSize()
        );
    }

    public function provideGetSetWindowSize()
    {
        return [
            [1280, 800],
            [1280, null],
            [null, 800],
        ];
    }
}
