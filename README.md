# C-quential Coding Standard
_Custom rules for [PHP_CodeSniffer](https://github.com/PHPCSStandards/PHP_CodeSniffer)_

## Installation

Install using Composer.

```bash
composer require c-quential/coding-standard
```

## Sniffs
Below is an alphabetical list of sniffs, with short explanations.

### Strings

`CquentialCodingStandard.Strings.UnneededDoubleQuoteUsage`: If a string can be rewritten to use single quotes, without adding string concatenation, you must do so.

### TypeHints

`CquentialCodingStandard.TypeHints.ArrowFunctionTypeHint`: This sniff checks if arrow functions are fully type-hinted. All parameters need to be type-hinted and a return type is also required. If there is no return value, you can use `null`, as `void` is not allowed on arrow functions.