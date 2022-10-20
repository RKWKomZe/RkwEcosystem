<?php

namespace RKW\RkwEcosystem\ViewHelpers;

use RKW\RkwBasics\Utility\GeneralUtility as Common;
use RKW\RkwBasics\Utility\GeneralUtility;
use RKW\RkwCheckup\Domain\Model\Question;
use \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

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
class FetchFlexFormValueViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{

    use CompileWithRenderStatic;


    /**
     * Initialize arguments.
     *
     * @throws \TYPO3Fluid\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('part1', 'string', 'Really, I don\'t know what\'s that for', true);
        $this->registerArgument('part2', 'string', 'Really, I don\'t know what\'s that for', true);
        $this->registerArgument('part3', 'string', 'Really, I don\'t know what\'s that for', false, '');
        $this->registerArgument('settings', 'array', 'The FlexForm-array or TypoScript-array for - what ever', false, []);
    }


    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface $renderingContext
     * @return string
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    static public function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ): string {

        $part1 = $arguments['part1'];
        $part2 = $arguments['part2'];
        $part3 = $arguments['part3'];
        $settings = $arguments['settings'];

        if (!$settings) {
            $settings = GeneralUtility::getTyposcriptConfiguration('Rkwecosystem');
        }

        if ($part3) {
            $part2 = ucfirst($part2);
            return $settings[$part1 . $part2 . $part3];
        }

        return $settings[$part1 . $part2];
    }
}
