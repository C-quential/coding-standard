<?php

namespace CquentialCodingStandard\Tests\TypeHints;

use CquentialCodingStandard\Sniffs\TypeHints\ArrowFunctionTypeHintSniff;
use CquentialCodingStandard\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ArrowFunctionTypeHintSniff::class)]
class ArrowFunctionTypeHintSniffTest extends TestCase
{
    public function testArrowFunctionTypeHints(): void
    {
        $sniff = new ArrowFunctionTypeHintSniff();
        $file = $this->runSniff('arrowFunctions', $sniff);

        $this->assertErrorCount($file, 5);

        $this->assertSniffed($file, 9, 22, $sniff, 'MissingReturnTypeHint');
        $this->assertSniffed($file, 9, 25, $sniff, 'MissingParameterTypeHint');
        $this->assertSniffed($file, 11, 22, $sniff, 'MissingReturnTypeHint');
        $this->assertSniffed($file, 13, 19, $sniff, 'MissingReturnTypeHint');
        $this->assertSniffed($file, 13, 22, $sniff, 'MissingParameterTypeHint');
        $this->assertSniffed($file, 13, 26, $sniff, 'MissingParameterTypeHint');
        $this->assertSniffed($file, 17, 18, $sniff, 'MissingReturnTypeHint');
        $this->assertSniffed($file, 27, 31, $sniff, 'MissingReturnTypeHint');
        $this->assertSniffed($file, 27, 37, $sniff, 'MissingParameterTypeHint');

        $this->assertNotSniffed($file, 15);
        $this->assertNotSniffed($file, 19);
        $this->assertNotSniffed($file, 21);
        $this->assertNotSniffed($file, 23);
        $this->assertNotSniffed($file, 25);
    }
}