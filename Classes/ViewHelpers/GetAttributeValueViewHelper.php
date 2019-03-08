<?php

namespace RKW\RkwEcosystem\ViewHelpers;

use \RKW\RkwBasics\Helper\Common;
use \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * GetAttributeValueViewHelper
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEcosystem
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class GetAttributeValueViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * A helper to return flexForm values
     *
     * @param object $object
     * @param string $attribute
     * @return mixed
     */
    public function render($object, $attribute)
    {

        $getter = 'get' . ucfirst($attribute);
        if (
            (is_object($object))
            && (method_exists($object, $getter))
        ) {
            return $object->$getter();
            //===
        }

        return null;
        //===
    }


}