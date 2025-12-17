# C-quential Coding Standard
_Custom rules for [PHP_CodeSniffer](https://github.com/PHPCSStandards/PHP_CodeSniffer)_

## Installation

Install using Composer.

```bash
composer require c-quential/coding-standard
```

## Sniffs
Below is an alphabetical list of sniffs, with short explanations.

`CquentialCodingStandard.Strings.UnneededDoubleQuoteUsage`: If a string can be rewritten to use single quotes, without adding string concatenation, you must do so.