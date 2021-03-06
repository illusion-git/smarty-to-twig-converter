<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace toTwig\Converter;

/**
 * Class OxidIncludeWidgetConverter
 */
class OxidIncludeWidgetConverter extends AbstractSingleTagConverter
{

    protected $name = 'oxid_include_widget';
    protected $description = 'Convert smarty {oxid_include_widget} to twig {{ include_widget() }}';
    protected $priority = 100;
    protected $convertedName = 'include_widget';
}
