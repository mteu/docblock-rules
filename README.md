<div align="center">

[![PHP Version Require](http://poser.pugx.org/mteu/docblock-rules/require/php)](https://packagist.org/packages/mteu/docblock-rules)
[![CGL](https://github.com/mteu/docblock-rules/actions/workflows/cgl.yaml/badge.svg)](https://github.com/mteu/docblock-rules/actions/workflows/cgl.yaml)
[![Latest Stable Version](http://poser.pugx.org/mteu/docblock-rules/v)](https://packagist.org/packages/mteu/docblock-rules)
[![License](http://poser.pugx.org/mteu/docblock-rules/license)](https://packagist.org/packages/mteu/docblock-rules)

# DocBlock Rules
</div>

**DocBlock Rules** is simple [PHPStan](https://github.com/phpstan/phpstan) rules extension to verify whether the PHP files
contain certain pre-defined strings.

## ⚡ Usage

Require this package and make sure to configure PHPStan according to your needs by putting a configuration file in your project
(e.g. as `phpstan.neon` file in your package root.)

```bash
composer require --dev mteu/docblock-rules 
```

If you're using the [`phpstan/extension-installer`](https://github.com/phpstan/extension-installer) you're good to go.

## Configuration

This package ships custom rules that need additional configuration:
* [`RequireCopyrightInformationInFirstCommentRule`](#RequireCopyrightInformationInFirstCommentRule)
* [`RequireLicenseInformationInFirstCommentRule`](#RequireLicenseInformationInFirstCommentRule)

### [`RequireCopyrightInformationInFirstCommentRule`](src/Rules/RequireCopyrightInformationInFirstCommentRule.php)
This rule checks whether there is a PHPDoc comment block present that contains copyright information
identified by a needle string in the PHPStan configuration.

#### Sample configuration:
```neon
# phpstan.neon

docblock:
  copyrightIdentifier: 'Copyright (C) 2023'
```

### [`RequireLicenseInformationInFirstCommentRule`](src/Rules/RequireLicenseInformationInFirstCommentRule.php)
This rule checks whether there is a PHPDoc comment block present that contains license information. You
can use pre-defined license checks values or define a custom string that is being looked for.

#### Sample configuration:
```neon
# phpstan.neon

docblock:
    # Pre-configured checks when applying 'GPL-2.0' or 'GPL-3.0' as value.
    # Alternatively, use a custom string to look for in the file.
    requiredLicenseIdentifier: 'GPL-3.0'
```

## 💛 Acknowledgement
I'm very grateful for the good people that created, maintain and sponsor [PHPStan](https://github.com/phpstan/phpstan). Děkuji, [Ondřej](https://github.com/ondrejmirtes)
and everyone who has contributed!

## ⭐ License
This project is licensed under [GNU General Public License 3.0 (or later)](LICENSE).
