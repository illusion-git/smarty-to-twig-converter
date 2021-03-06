<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace toTwig\Tests\Unit;

use PHPUnit\Framework\TestCase;
use toTwig\Converter\AssignAdvConverter;

/**
 * Class AssignAdvConverterTest
 */
class AssignAdvConverterTest extends TestCase
{

    /** @var AssignAdvConverter */
    protected $converter;

    public function setUp()
    {
        $this->converter = new AssignAdvConverter();
    }

    /**
     * @covers       \toTwig\Converter\AssignAdvConverter::convert
     *
     * @dataProvider provider
     *
     * @param $smarty
     * @param $twig
     */
    public function testThatAssignIsConverted($smarty, $twig)
    {
        // Test the above cases
        $this->assertSame(
            $twig,
            $this->converter->convert($smarty)
        );
    }

    /**
     * @return array
     */
    public function provider()
    {
        return [
            // Few examples from assign (compatibility)
            [
                "[{assign_adv var=\"name\" value=\"Bob\"}]",
                "{% set name = assign_advanced(\"Bob\") %}"
            ],
            [
                "[{assign_adv var=\"name\" value=\$bob}]",
                "{% set name = assign_advanced(bob) %}"
            ],
            [
                "[{assign_adv var=\"where\" value=\$oView->getListFilter()}]",
                "{% set where = assign_advanced(oView.getListFilter()) %}"
            ],
            [
                "[{assign_adv var=\"template_title\" value=\"MY_WISH_LIST\"|oxmultilangassign}]",
                "{% set template_title = assign_advanced(\"MY_WISH_LIST\"|translate) %}"
            ],
            // Example for assign_dev function
            [
                "[{assign_adv var=\"invite_array\" value=\"array('0' => '\$sender_name', '1' => '\$shop_name')\"}]",
                "{% set invite_array = assign_advanced(\"array('0' => '\$sender_name', '1' => '\$shop_name')\") %}"
            ],
            // With spaces
            [
                "[{ assign_adv var=\"name\" value=\"Bob\" }]",
                "{% set name = assign_advanced(\"Bob\") %}"
            ],
        ];
    }

    /**
     * @covers \toTwig\Converter\AssignAdvConverter::getName
     */
    public function testThatHaveExpectedName()
    {
        $this->assertEquals('assign_adv', $this->converter->getName());
    }

    /**
     * @covers \toTwig\Converter\AssignAdvConverter::getDescription
     */
    public function testThatHaveDescription()
    {
        $this->assertNotEmpty($this->converter->getDescription());
    }
}
