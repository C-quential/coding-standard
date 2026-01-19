<?php

namespace CquentialCodingStandard\Sniffs\TypeHints;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Checks that arrow functions have type hints for all parameters and a return type.
 *
 * Note: For arrow functions used for side-effects (void operations), developers
 * should use `: null` as the return type, since void is not allowed on arrow
 * functions but the expression evaluates to null.
 */
class ArrowFunctionTypeHintSniff implements Sniff
{
    /**
     * Returns an array of tokens this sniff wants to listen for.
     *
     * @return array<int|string>
     */
    public function register(): array
    {
        return [T_FN];
    }

    /**
     * Processes this sniff when one of its tokens is encountered.
     *
     * @param File $phpcsFile The file being scanned.
     * @param int $stackPtr The position of the current token in the stack.
     */
    public function process(File $phpcsFile, int $stackPtr): void
    {
        $this->checkParameterTypeHints($phpcsFile, $stackPtr);
        $this->checkReturnTypeHint($phpcsFile, $stackPtr);
    }

    /**
     * Check that all parameters have type hints.
     *
     * @param File $phpcsFile The file being scanned.
     * @param int $stackPtr The position of the T_FN token.
     */
    private function checkParameterTypeHints(File $phpcsFile, int $stackPtr): void
    {
        $parameters = $phpcsFile->getMethodParameters($stackPtr);

        foreach ($parameters as $param) {
            if (empty($param['type_hint'])) {
                $phpcsFile->addError(
                    'Arrow function parameter \'%s\' missing type hint',
                    $param['token'],
                    'MissingParameterTypeHint',
                    [$param['name']]
                );
            }
        }
    }

    /**
     * Check that a return type hint is present.
     *
     * @param File $phpcsFile The file being scanned.
     * @param int $stackPtr The position of the T_FN token.
     */
    private function checkReturnTypeHint(File $phpcsFile, int $stackPtr): void
    {
        $tokens = $phpcsFile->getTokens();

        if (!isset($tokens[$stackPtr]['parenthesis_closer'])) {
            return;
        }

        $closeParen = $tokens[$stackPtr]['parenthesis_closer'] + 1;
        $fnArrow = $phpcsFile->findNext(T_FN_ARROW, $closeParen);
        if ($fnArrow === false) {
            return;
        }

        if ($phpcsFile->findNext(T_COLON, $closeParen, $fnArrow) === false) {
            $phpcsFile->addError(
                'Arrow function missing return type hint',
                $stackPtr,
                'MissingReturnTypeHint'
            );
        }
    }
}