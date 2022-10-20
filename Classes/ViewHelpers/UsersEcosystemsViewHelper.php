<?php
namespace RKW\RkwEcosystem\ViewHelpers;
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

use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * GetAttributeValueViewHelper
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEcosystem
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class UsersEcosystemsViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
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
        $this->registerArgument('ecosystemList', QueryResult::class, 'The QueryResult to check', true);
    }


    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return mixed
     */
    static public function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ): string {

        $ecosystemList = $arguments['ecosystemList'];

        /** @var \RKW\RkwEcosystem\Domain\Model\Ecosystem $ecosystemFromSession */
        $ecosystemFromSession = unserialize($GLOBALS['TSFE']->fe_user->getKey('ses', 'rkw_ecosystem'));

        // 1. if there are no items
        if (count($ecosystemList) == 0) {
            return false;
        }

        // 2. if there is no opened ecosystem yet and the users ecosystemList greater than 0
        if (
            !$ecosystemFromSession
            && count($ecosystemList) > 0
        ) {
            return true;
        }

        // 3. count if there are additional ecosystems to show
        $i = 0;
        /** @var \RKW\RkwEcosystem\Domain\Model\Ecosystem $ecosystem */
        foreach ($ecosystemList as $ecosystem) {
            if ($ecosystem->getUid() != $ecosystemFromSession->getUid()) {
                $i++;
            }
        }

        return ($i > 0) ? true : false;
    }
}
