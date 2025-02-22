<?php

declare(strict_types=1);

/*
 * This file is part of the Symfony project "mteu/docblock-rules".
 *
 * Copyright (C) 2023 Martin Adler <mteu@mailbox.org>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Mteu\DocBlockRules\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\Namespace_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use Mteu\DocBlockRules\Enum\License;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\ShouldNotHappenException;

/**
 * @implements Rule<Node\Stmt>
 */
final readonly class RequireLicenseInformationInFirstCommentRule implements Rule
{
    // Update to Enum field reference in constant expression with PHP 8.2 support
    private const SUPPORTED_LICENSES = [
        'GPL-2.0' => License::GPL20,
        'GPL-3.0' => License::GPL30,
    ];

    public function __construct(
        private string $requiredLicenseIdentifier = '',
    ) {
    }

    /**
     * @return class-string<Node\Stmt>
     */
    public function getNodeType(): string
    {
        return Namespace_::class;
    }

    /**
     * @return (string|RuleError)[]
     * @throws ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $comments = $node->getComments();
        $firstComment = false !== reset($comments) ? reset($comments) : null;

        $licenseKey = self::SUPPORTED_LICENSES[$this->requiredLicenseIdentifier];
        $licenseText = $licenseKey->value ?? $this->requiredLicenseIdentifier;

        if (null === $firstComment) {
            return [
                RuleErrorBuilder::message(
                    'File is missing a PHPDoc comment block that could contain license information.',
                )->build(),
            ];
        }

        if (!str_contains($firstComment->getText(), $licenseText)) {
            return [
                RuleErrorBuilder::message(
                    sprintf(
                    'File does not include a \'%s\' license.',
                        $this->requiredLicenseIdentifier,
                    ),
                )->build(),
            ];
        }

        return [];
    }
}
