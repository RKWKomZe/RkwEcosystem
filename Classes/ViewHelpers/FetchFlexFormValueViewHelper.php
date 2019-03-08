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
 * FetchFlexFormValue
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEcosystem
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class FetchFlexFormValueViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * A helper to return flexForm values
     *
     * @param string $part1
     * @param string $part2
     * @param string $part3
     * @param array $settings
     * @return string|integer
     */
    public function render($part1, $part2, $part3 = null, $settings = null)
    {
        if (!$settings) {
            $settings = $this->getSettings();
        }

        if ($part3) {
            $part2 = ucfirst($part2);

            return $settings[$part1 . $part2 . $part3];
            //===
        }

        return $settings[$part1 . $part2];
        //===
    }


    /**
     * Returns TYPO3 settings
     *
     * @param string $which Which type of settings will be loaded
     * @return array
     */
    public function getSettings($which = ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS)
    {

        return Common::getTyposcriptConfiguration('Rkwecosystem', $which);
        //===
    }

}