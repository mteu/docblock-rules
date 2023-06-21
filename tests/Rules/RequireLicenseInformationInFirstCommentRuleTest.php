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

use Mteu\DocBlockRules\Rules\RequireLicenseInformationInFirstCommentRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<RequireLicenseInformationInFirstCommentRule>
 */
final class RequireLicenseInformationInFirstCommentRuleTest extends RuleTestCase
{

    private const REQUIRED_LICENSE_IDENTIFIER = 'GPL-3.0';

    protected function getRule(): Rule
    {
        return new RequireLicenseInformationInFirstCommentRule(self::REQUIRED_LICENSE_IDENTIFIER);
    }

    /** @return string[] */
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/../../extension.neon'];
    }

    public function testRule(): void
    {
        $this->analyse(
            [__DIR__ . '/../data/CommentWithCopyright.php'],
            [
                [
                    sprintf(
                        'File does not include a \'%s\' license.',
                        self::REQUIRED_LICENSE_IDENTIFIER,
                    ), 9
                ],
            ]
        );

        $this->analyse(
            [
                __DIR__ . '/../data/ClassWithoutDocBlock.php'
            ],
            [
                [
                    'File is missing a PHPDoc comment block that could contain license information.', 5
                ],
            ]
        );
    }
}
