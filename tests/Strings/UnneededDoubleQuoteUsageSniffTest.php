<?php

namespace CquentialCodingStandard\Tests\Strings;

use CquentialCodingStandard\Sniffs\Strings\UnneededDoubleQuoteUsageSniff;
use CquentialCodingStandard\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(UnneededDoubleQuoteUsageSniff::class)]
class UnneededDoubleQuoteUsageSniffTest extends TestCase
{
    public function testSniffBasic(): void {
        $sniff = new UnneededDoubleQuoteUsageSniff();

        $file = $this->runSniff('stringQuotes', $sniff);
        $this->assertErrorCount($file, 2);
        $this->assertSniffed($file, 6, 11, $sniff, 'NotRequired', true);
        $this->assertSniffed($file, 10, 12, $sniff, 'NotRequired', true);

        $this->assertFixedCorrectly($file);
    }
}