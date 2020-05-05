<?php

namespace RKW\RkwEcosystem\Service;

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
 * Ecosystem
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwConsultant
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class RkwMailService implements \TYPO3\CMS\Core\SingletonInterface
{
    /**
     * Sends an E-Mail to an Admin
     *
     * @param \RKW\RkwRegistration\Domain\Model\BackendUser|array $backendUser
     * @param \RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUser
     * @param \RKW\RkwEcosystem\Domain\Model\Ecosystem $ecosystem
     * @param string remark
     * @param string $pdfString
     * @throws \RKW\RkwMailer\Service\MailException
     * @throws \TYPO3\CMS\Extbase\Persistence\Generic\Exception
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3Fluid\Fluid\View\Exception\InvalidTemplateResourceException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    public function expertFeedbackAdmin($backendUser, \RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUser, \RKW\RkwEcosystem\Domain\Model\Ecosystem $ecosystem, $remark = null, $pdfString = null)
    {

        // get settings
        $settings = $this->getSettings(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        $settingsDefault = $this->getSettings();

        $recipients = array();
        if (is_array($backendUser)) {
            $recipients = $backendUser;
        } else {
            $recipients[] = $backendUser;
        }

        if ($settings['view']['templateRootPaths'][0]) {

            /** @var \RKW\RkwMailer\Service\MailService $mailService */
            $mailService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwMailer\\Service\\MailService');

            foreach ($recipients as $recipient) {

                if (
                    ($recipient instanceof \RKW\RkwRegistration\Domain\Model\BackendUser)
                    && ($recipient->getEmail())
                ) {
                    // send new user an email with token
                    $mailService->setTo($recipient, array(
                        'marker'  => array(
                            'ecosystem'    => $ecosystem,
                            'backendUser'  => $recipient,
                            'frontendUser' => $frontendUser,
                            'pageUid'      => intval($GLOBALS['TSFE']->id),
                            'loginPid'     => intval($settingsDefault['loginPid']),
                            'remark'       => $remark,
                        ),
                        'subject' => \RKW\RkwMailer\Helper\FrontendLocalization::translate(
                            'rkwMailService.expertFeedbackAdmin.subject',
                            'rkw_ecosystem',
                            null,
                            $recipient->getLang()
                        ),
                    ));
                }
            }

            if (
                ($ecosystem->getFrontendUser())
                && ($ecosystem->getFrontendUser()->getEmail())
            ) {
                $mailService->getQueueMail()->setReplyAddress($ecosystem->getFrontendUser()->getEmail());
            }

            // attach PDF
            if ($pdfString) {
                $mailService->getQueueMail()->setAttachment($pdfString);
                $mailService->getQueueMail()->setAttachmentType('application/pdf');
                $mailService->getQueueMail()->setAttachmentName('ecosystem.pdf');
            }

            $mailService->getQueueMail()->setSubject(
                \RKW\RkwMailer\Helper\FrontendLocalization::translate(
                    'rkwMailService.expertFeedbackAdmin.subject',
                    'rkw_ecosystem',
                    null,
                    'de'
                )
            );

            $mailService->getQueueMail()->addTemplatePaths($settings['view']['templateRootPaths']);
            $mailService->getQueueMail()->addPartialPaths($settings['view']['partialRootPaths']);
            $mailService->getQueueMail()->setPlaintextTemplate('Email/ExpertFeedbackAdmin');
            $mailService->getQueueMail()->setHtmlTemplate('Email/ExpertFeedbackAdmin');

            if (count($mailService->getTo())) {
                $mailService->send();
            }
        }
    }


    /**
     * Returns TYPO3 settings
     *
     * @param string $which Which type of settings will be loaded
     * @return array
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    protected function getSettings($which = ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS)
    {

        return Common::getTyposcriptConfiguration('Rkwecosystem', $which);
        //===
    }
}
