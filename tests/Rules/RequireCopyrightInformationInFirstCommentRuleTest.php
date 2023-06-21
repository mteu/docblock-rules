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

namespace Mteu\DocBlockRules\Tests\Rules;

use Mteu\DocBlockRules\Rules\RequireCopyrightInformationInFirstCommentRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<RequireCopyrightInformationInFirstCommentRule>
 */
class RequireCopyrightInformationInFirstCommentRuleTest extends RuleTestCase
{

    /**
     */
    protected function getRule(): Rule
    {
        return new RequireCopyrightInformationInFirstCommentRule('Copyright (C)');
    }

    /** @return string[] */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/../../extension.neon'];
    }

    public function testRule(): void
    {
        $this->analyse(
            [
                __DIR__ . '/../data/CommentWithoutCopyrightOrLicense.php'
            ],
            [
                [
                    'File is missing the configured copyright notice in the PHPDoc comment block.',
                    7
                ],
            ]
        );

        $this->analyse(
            [__DIR__ . '/../data/CommentWithLicense.php'],
            [
                [
                    'File is missing the configured copyright notice in the PHPDoc comment block.', 22
                ],
            ]
        );

        $this->analyse(
            [
                __DIR__ . '/../data/CommentWithCopyright.php'
            ],
            [
                [
                    'File is missing the configured copyright notice in the PHPDoc comment block.', 9
                ],
            ]
        );

        $this->analyse(
            [
                __DIR__ . '/../data/ClassWithoutDocBlock.php'
            ],
            [
                [
                    'File is missing a PHPDoc comment block that could contain a copyright notice.', 5
                ],
            ]
        );
    }
}
