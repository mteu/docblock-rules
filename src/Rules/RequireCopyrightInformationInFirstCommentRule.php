<?php

declare(strict_types=1);

/*
 * This file is part of the PHPStan extension "mteu/docblock-rules".
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
use PHPStan\Analyser\Scope;
use PHPStan\Rules\IdentifierRuleError;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\ShouldNotHappenException;

/**
 * @implements Rule<Node\Stmt>
 */
final readonly class RequireCopyrightInformationInFirstCommentRule implements Rule
{
    public function __construct(
        private string $copyrightIdentifier = '',
    ) {
    }

    /**
     * @return class-string<Node\Stmt>
     */
    public function getNodeType(): string
    {
        return Node\Stmt\Namespace_::class;
    }

    /**
     * @return (string|RuleError)[]
     * @throws ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $comments = $node->getComments();
        $firstComment = false !== reset($comments) ? reset($comments) : null;

        if (null === $firstComment) {
            return [
                RuleErrorBuilder::message(
                    'File is missing a PHPDoc comment block that could contain a copyright notice.',
                )->build(),
            ];
        }

        if (!str_contains($firstComment->getText(), $this->copyrightIdentifier)) {
            return [
                RuleErrorBuilder::message(
                    'File is missing the configured copyright notice in the PHPDoc comment block.',
                )->build(),
            ];
        }

        return [];
    }
}
