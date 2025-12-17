<?php

namespace CquentialCodingStandard\Tests;

use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Files\LocalFile;
use PHP_CodeSniffer\Runner;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHPUnit\Framework\TestCase as BaseTestCase;
use ReflectionClass;

class TestCase extends BaseTestCase
{
    protected function runSniff(string $file, Sniff $sniff): LocalFile {
        $phpCS = new Runner();
        $phpCS->config = new Config(['']);
        $phpCS->init();

        $phpCS->ruleset->sniffs = [$sniff::class => $sniff];
        $phpCS->ruleset->populateTokenListeners();

        $shortSniffName = (new ReflectionClass($sniff))->getShortName();
        $file = new LocalFile(__DIR__ . DIRECTORY_SEPARATOR . 'testFiles' . DIRECTORY_SEPARATOR . $shortSniffName . DIRECTORY_SEPARATOR . $file . '.php', $phpCS->ruleset, $phpCS->config);
        $file->process();

        return $file;
    }

    protected function assertFixedCorrectly(File $file): void {
        $this->assertTrue($file->fixer->fixFile(), 'The file was not successfully fixed.');

        $fixedFilename = $file->getFilename();
        $fixedFilename = substr($fixedFilename, 0, -4) . '_fixed.php';

        $this->assertEquals(file_get_contents($fixedFilename), $file->fixer->getContents());
    }

    protected function assertErrorCount(File $file, int $count): void {
        $this->assertCount($count, $file->getErrors());
    }

    protected function assertNotSniffed(File $file, int $line): void {
        $errors = $file->getErrors();
        $this->assertFalse(isset($errors[$line]), "There was an error on line $line in file {$file->getFilename()}, but none was expected.");
    }

    protected function assertSniffed(File $file, int $line, ?int $column = null, ?Sniff $sniff = null, ?string $name = null, ?bool $fixable = null): void {
        $errors = $file->getErrors();
        $this->assertArrayHasKey($line, $errors, "There was no error on line $line in file {$file->getFilename()}, but one was expected.");

        $errors = $errors[$line];

        if ($column === null) {
            $column = array_key_first($errors);
            $this->assertArrayHasKey($column, $errors, "There was no error at column $column on line $line in file {$file->getFilename()}, but one was expected.");
        }

        $errors = $errors[$column];

        if ($sniff) {
            $this->assertEquals($sniff::class, $errors[0]['listener']);
        }

        if ($name !== null) {
            $this->assertEquals($name, substr($errors[0]['source'], strrpos($errors[0]['source'], '.') + 1), "The error name has to be $name, but a different error was found instead.");
        }

        if ($fixable !== null) {
            $this->assertEquals($fixable, $errors[0]['fixable']);
        }
    }
}