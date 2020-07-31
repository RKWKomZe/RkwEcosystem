<?php

namespace RKW\RkwEcosystem\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
use RKW\RkwBasics\Helper\Common;
use RKW\RkwBasics\Service\CookieService;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

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
 * EcosystemController
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwConsultant
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class EcosystemController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * ecosystemRepository
     *
     * @var \RKW\RkwEcosystem\Domain\Repository\EcosystemRepository
     * @inject
     */
    protected $ecosystemRepository = null;

    /**
     * frontendUserRepository
     *
     * @var \RKW\RkwRegistration\Domain\Repository\FrontendUserRepository
     * @inject
     */
    protected $frontendUserRepository = null;

    /**
     * backendUserRepository
     *
     * @var \RKW\RkwRegistration\Domain\Repository\BackendUserRepository
     * @inject
     */
    protected $backendUserRepository = null;

    /**
     * logged in FrontendUser
     *
     * @var \RKW\RkwRegistration\Domain\Model\FrontendUser
     */
    protected $frontendUser = null;

    /**
     * mailService
     *
     * @var \RKW\RkwEcosystem\Service\RkwMailService
     * @inject
     */
    protected $mailService = null;

    /**
     * contentRepository
     *
     * @var \RKW\RkwBasics\Domain\Repository\ContentRepository
     * @inject
     */
    protected $contentRepository = null;


    /**
     * Persistence Manager
     *
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager;


    /**
     * @var \TYPO3\CMS\Core\Log\Logger
     */
    protected $logger;


    /**
     * action edit
     *
     * @param int $ecosystemId
     * @return void
     */
    public function editAction($ecosystemId = -1)
    {
        $ecosystem = 0;

        // load from database
        if (
            ($ecosystemId > 0)
            && ($this->getFrontendUser())
        ) {

            /** @var  \RKW\RkwEcosystem\Domain\Model\Ecosystem $ecosystemTemp */
            $ecosystemTemp = $this->ecosystemRepository->findByIdentifier(intval($ecosystemId));

            // check FE-User-ID!
            if (
                ($this->getFrontendUser()->getUid())
                && ($ecosystemTemp->getFrontendUser()->getUid() == $this->getFrontendUser()->getUid())
            ) {
                $ecosystem = $ecosystemTemp;
            }
        }

        // try to load from session
        if (
            (!$ecosystem)
            && ($ecosystemId != -1)
        ) {
            /** @var  \RKW\RkwEcosystem\Domain\Model\Ecosystem $ecosystem */
            $ecosystem = $this->getEcosystemFromSession();
        }

        // set blank object if nothing is there to load
        if (!$ecosystem) {

            /** @var  \RKW\RkwEcosystem\Domain\Model\Ecosystem $ecosystem */
            $ecosystem = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwEcosystem\\Domain\\Model\\Ecosystem');
        }

        // set data to session
        $this->setEcosystemToSession($ecosystem);

        // set list if all canvases of user
        if ($this->getFrontendUser()) {
            $this->view->assign('frontendUserEcosystemList', $this->ecosystemRepository->findByFrontendUser($this->getFrontendUser()));
        }

        $this->view->assign('ecosystem', $ecosystem);

        // needed to get flexform-settings in print view
        // -> we cant grab it in the print action itself, because this function would return the PID!
        $this->view->assign('ttContentUid', $ttContentUid = intval($this->configurationManager->getContentObject()->data['uid']));
    }


    /**
     * action update
     *
     * @param \RKW\RkwEcosystem\Domain\Model\Ecosystem $ecosystem
     * @return boolean
     */
    public function updateAction(\RKW\RkwEcosystem\Domain\Model\Ecosystem $ecosystem)
    {
        $this->setEcosystemToSession($ecosystem);

        // get JSON helper
        /** @var \RKW\RkwBasics\Helper\Json $jsonHelper */
        $jsonHelper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwBasics\\Helper\\Json');
        print (string)$jsonHelper;
        exit();
        //===

    }


    /**
     * action reset
     * Clear users cache to simply start a new ecosystem or reset the data to the one that was previously stored
     *
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    public function resetAction()
    {
        /** @var  \RKW\RkwEcosystem\Domain\Model\Ecosystem $ecosystem */
        $ecosystem = $this->getEcosystemFromSession();

        if ($ecosystem->getUid()) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('ecosystemController.message.resetDatabase', 'rkw_ecosystem'),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::OK
            );
        } else {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('ecosystemController.message.resetAll', 'rkw_ecosystem'),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::OK
            );
        }

        $this->redirect('edit', null, null, array('ecosystemId' => $ecosystem->getUid()));
        //===
    }


    /**
     * action save
     *
     * @param bool $recalled
     * @return void
     */
    public function saveAction($recalled = false)
    {
        /** @var  \RKW\RkwEcosystem\Domain\Model\Ecosystem $ecosystem */
        $ecosystem = $this->getEcosystemFromSession();

        // go forward, if title is already set (and user is already logged in)
        if ($this->getFrontendUser()) {
            if ($ecosystem->getTitle()) {
                $this->redirect('persist');
                //===
            }
        }

        // else: just give the form
        $this->addFlashMessage(
            \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('ecosystemController.message.enterName', 'rkw_ecosystem'),
            '',
            ($recalled ? \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR : \TYPO3\CMS\Core\Messaging\AbstractMessage::OK)
        );

        $this->view->assign('ecosystem', $ecosystem);
    }


    /**
     * action persist
     *
     * @param \RKW\RkwEcosystem\Domain\Model\Ecosystem $ecosystem
     * @return void
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    public function persistAction(\RKW\RkwEcosystem\Domain\Model\Ecosystem $ecosystem = null)
    {
        if (!$this->getFrontendUser()) {

            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('ecosystemController.message.error.loggedIn', 'rkw_ecosystem'),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('edit', null, null, array('ecosystemId' => $ecosystem->getUid()));
            //===
        }

        // Because users in "saveAction" simple forwarded, if title is set (but the data not persisted yet)
        // -> we have to get it from session now
        if (! $ecosystem) {
            /** @var  \RKW\RkwEcosystem\Domain\Model\Ecosystem $ecosystem */
            $ecosystem = $this->getEcosystemFromSession();
        }

        if ($ecosystem) {
            if (!$ecosystem->getTitle()) {
                $this->redirect('save', null, null, array('recalled' => true));
                //===
            }

        } else {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('ecosystemController.message.error.somethingWentWrong', 'rkw_ecosystem'),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('save', null, null, array('recalled' => true));
            //===
        }

        // update or add it to database
        if ($ecosystem->_isNew()) {

            $ecosystem->setFrontendUser($this->getFrontendUser());
            $this->ecosystemRepository->add($ecosystem);
            $this->persistenceManager->persistAll();

        } else {

            // now we got a isNew() issue, if we already have saved once, but loaded an older one via session above
            // -> Solution: Get the real one from DB and set the data from the session ecosystem!
            /** @var  \RKW\RkwEcosystem\Domain\Model\Ecosystem $ecosystemFromDb */
            $ecosystemFromDb = $this->ecosystemRepository->findByIdentifier($ecosystem->getUid());
            $ecosystemFromDb->setTitle($ecosystem->getTitle());
            // other properties
            $ecosystemPropertyList = array('education', 'politics', 'endCustomer', 'potentialFounder', 'inspiration', 'startUps', 'trend', 'demandForSolution', 'company', 'assistance', 'businessCustomer');
            foreach ($ecosystemPropertyList as $ecosystemProperty) {
                $setter = 'set' . ucfirst($ecosystemProperty);
                $setterValue = 'set' . ucfirst($ecosystemProperty) . 'Value';
                $getter = 'get' . ucfirst($ecosystemProperty);
                $getterValue = 'get' . ucfirst($ecosystemProperty) . 'Value';
                $ecosystemFromDb->$setter($ecosystem->$getter());
                $ecosystemFromDb->$setterValue($ecosystem->$getterValue());
            }
            $ecosystem = $ecosystemFromDb;

            // check FE-User-ID!
            if (
                ($this->getFrontendUser()->getUid())
                && ($ecosystem->getFrontendUser()->getUid() == $this->getFrontendUser()->getUid())
            ) {
                $this->ecosystemRepository->update($ecosystem);

            } else {
                $this->addFlashMessage(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('ecosystemController.message.error.somethingWentWrong', 'rkw_ecosystem'),
                    '',
                    \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
                );
                $this->redirect('save', null, null, array('recalled' => true));
                //===
            }
        }

        $this->addFlashMessage(
            \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('ecosystemController.message.ecosystemSaved', 'rkw_ecosystem'),
            '',
            \TYPO3\CMS\Core\Messaging\AbstractMessage::OK
        );
        $this->redirect('edit', null, null, array('ecosystemId' => $ecosystem->getUid()));
        //===
    }



    /**
     * action open
     *
     * @param \RKW\RkwEcosystem\Domain\Model\Ecosystem $ecosystem
     * @return void
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    public function openAction(\RKW\RkwEcosystem\Domain\Model\Ecosystem $ecosystem = null)
    {
        if (!$this->getFrontendUser()) {

            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('ecosystemController.message.error.loggedIn', 'rkw_ecosystem'),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('edit', null, null, array('ecosystemId' => $ecosystem->getUid()));
            //===
        }

        if ($ecosystem) {
            $this->redirect('edit', null, null, array('ecosystemId' => $ecosystem->getUid()));
            //===
        }

        $this->addFlashMessage(
            \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('ecosystemController.message.choose', 'rkw_ecosystem')
        );

        $this->view->assign('frontendUserEcosystemList', $this->ecosystemRepository->findByFrontendUser($this->getFrontendUser()));
    }



    /**
     * action show
     *
     * @param \RKW\RkwEcosystem\Domain\Model\Ecosystem $ecosystem
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     */
    public function showAction(\RKW\RkwEcosystem\Domain\Model\Ecosystem $ecosystem = null)
    {

        if (!$ecosystem) {
            $ecosystem = $this->getEcosystemFromSession();
        }

        if (!$ecosystem) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('ecosystemController.message.error.somethingWentWrong', 'rkw_ecosystem'),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('edit');
            //===
        }

        $this->view->assign('settingsArray', $this->settings);
        $this->view->assign('ecosystem', $ecosystem);
    }


    /**
     * action print
     * returns print as PDF
     *
     * @param \RKW\RkwEcosystem\Domain\Model\Ecosystem $ecosystem
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3Fluid\Fluid\View\Exception\InvalidTemplateResourceException
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    public function printAction(\RKW\RkwEcosystem\Domain\Model\Ecosystem $ecosystem = null)
    {
        if (!$ecosystem) {
            $ecosystem = $this->getEcosystemFromSession();
        }

        if (!$ecosystem) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('ecosystemController.message.error.somethingWentWrong', 'rkw_ecosystem'),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('edit');
            //===
        }

        try {
            if ($settingsFramework = Common::getTyposcriptConfiguration($this->extensionName, ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK)) {

                /** @var \TYPO3\CMS\Fluid\View\StandaloneView $standaloneView */
                $standaloneView = GeneralUtility::makeInstance(\TYPO3\CMS\Fluid\View\StandaloneView::class);
                $standaloneView->setLayoutRootPaths(array(GeneralUtility::getFileAbsFileName($settingsFramework['view']['layoutRootPaths'][0])));
                $standaloneView->setPartialRootPaths(array(GeneralUtility::getFileAbsFileName($settingsFramework['view']['partialRootPaths'][0])));
                $standaloneView->setTemplateRootPaths(array(GeneralUtility::getFileAbsFileName($settingsFramework['view']['templateRootPaths'][0])));
                $standaloneView->setTemplate('Ecosystem/Show.html');
                $standaloneView->assign('settingsArray', $this->settings);
                $standaloneView->assign('ecosystem', $ecosystem);

                $content = $standaloneView->render();

                ob_start();

                // "L" for "landscape" -> horizontal. Use "P" for "portrait" -> vertical
                $html2pdf = new Html2Pdf('L', 'A3', 'de', true, 'UTF-8', 0);
                $html2pdf->parsingCss;
                $html2pdf->writeHTML($content);

                $fileName = time() . '-ecosystem.pdf';
                // Show for Ending "D", "F" or "S": https://github.com/spipu/html2pdf/blob/master/doc/output.md
                // -> "D" - Forcing the download of PDF via web browser, with a specific name
                $html2pdf->output($fileName, 'D');
                // do not use "exit" here. Is making trouble (provides a unnamed "binary"-file instead a names pdf)
                readfile($fileName);
            //    exit;
                //===
            }

        } catch (Html2PdfException $e) {

            $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::ERROR, sprintf('An error occurred while trying to generate a PDF. Message: %s', str_replace(array("\n", "\r"), '', $e->getMessage())));
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('ecosystemController.message.error.somethingWentWrong', 'rkw_ecosystem'),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('edit', null, null, array('ecosystemId' => $ecosystem->getUid()));
            //===
        }
    }

    /**
     * action expertFeedback
     *
     * @param \RKW\RkwEcosystem\Domain\Model\Ecosystem $ecosystem
     * @param bool $recalled
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    public function expertFeedbackAction(\RKW\RkwEcosystem\Domain\Model\Ecosystem $ecosystem = null, $recalled = false)
    {
        if (!$this->getFrontendUser()) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('ecosystemController.message.error.loggedIn', 'rkw_ecosystem'),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('edit', null, null, array('ecosystemId' => $ecosystem->getUid()));
            //===
        }

        /** @var \RKW\RkwEcosystem\Domain\Model\Ecosystem $ecosystem */
        if (!$ecosystem) {
            $ecosystem = $this->getEcosystemFromSession();
        }

        if (!$ecosystem) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('ecosystemController.message.error.somethingWentWrong', 'rkw_ecosystem'),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect("edit");
            //===
        }

        $this->addFlashMessage(
            \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('ecosystemController.message.enterQuestion', 'rkw_ecosystem'),
            '',
            ($recalled ? \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR : \TYPO3\CMS\Core\Messaging\AbstractMessage::OK)
        );

        $this->view->assign('ecosystem', $ecosystem);

    }

    /**
     * action expertFeedback
     *
     * @param \RKW\RkwEcosystem\Domain\Model\Ecosystem $ecosystem
     * @param string $remark
     * @return void
     * @throws \RKW\RkwMailer\Service\MailException
     * @throws \TYPO3\CMS\Extbase\Persistence\Generic\Exception
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3Fluid\Fluid\View\Exception\InvalidTemplateResourceException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    public function expertFeedbackSendAction(\RKW\RkwEcosystem\Domain\Model\Ecosystem $ecosystem = null, $remark = null)
    {
        if (!$this->getFrontendUser()) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('ecosystemController.message.error.loggedIn', 'rkw_ecosystem'),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('edit', null, null, array('ecosystemId' => $ecosystem->getUid()));
            //===
        }

        if (!$ecosystem) {
            $ecosystem = $this->getEcosystemFromSession();
        }

        if (!$ecosystem) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('ecosystemController.message.error.somethingWentWrong', 'rkw_ecosystem'),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect("edit");
            //===
        }

        if (!$remark) {
            $this->redirect('expertFeedback', null, null, array('ecosystem' => $ecosystem, 'recalled' => true));
            //===
        }

        // generate PDF
        $finalPdf = '';
        try {
            if ($settingsFramework = Common::getTyposcriptConfiguration($this->extensionName, ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK)) {

                /** @var \TYPO3\CMS\Fluid\View\StandaloneView $standaloneView */
                $standaloneView = GeneralUtility::makeInstance(\TYPO3\CMS\Fluid\View\StandaloneView::class);
                $standaloneView->setLayoutRootPaths(array(GeneralUtility::getFileAbsFileName($settingsFramework['view']['layoutRootPaths'][0])));
                $standaloneView->setPartialRootPaths(array(GeneralUtility::getFileAbsFileName($settingsFramework['view']['partialRootPaths'][0])));
                $standaloneView->setTemplateRootPaths(array(GeneralUtility::getFileAbsFileName($settingsFramework['view']['templateRootPaths'][0])));
                $standaloneView->setTemplate('Ecosystem/Show.html');
                $standaloneView->assign('settingsArray', $this->settings);
                $standaloneView->assign('ecosystem', $ecosystem);
                $content = $standaloneView->render();

                // "L" for "landscape" -> horizontal. Use "P" for "portrait" -> vertical
                $html2pdf = new Html2Pdf('L', 'A3', 'de', true, 'UTF-8', 0);
                $html2pdf->parsingCss;
                $html2pdf->writeHTML($content);
                $finalPdf = $html2pdf->output('ecosystem.pdf', 'S');

            }
        } catch (\Exception $e) {

            $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::ERROR, sprintf('An error occurred while trying to generate a PDF. Message: %s', str_replace(array("\n", "\r"), '', $e->getMessage())));
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('ecosystemController.message.error.somethingWentWrong', 'rkw_ecosystem'),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('edit', null, null, array('ecosystemId' => $ecosystem->getUid()));
            //===
        }

        $adminUidList = explode(',', $this->settings['backendUser']);
        $backendUserList = array();
        foreach ($adminUidList as $adminUid) {
            if ($adminUid) {
                $admin = $this->backendUserRepository->findByUid($adminUid);
                if ($admin) {
                    $backendUserList[] = $admin;
                }
            }
        }
        $this->mailService->expertFeedbackAdmin($backendUserList, $this->getFrontendUser(), $ecosystem, $remark, $finalPdf);


        $this->addFlashMessage(
            \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('ecosystemController.message.feedbackSent', 'rkw_ecosystem'),
            '',
            \TYPO3\CMS\Core\Messaging\AbstractMessage::OK
        );

        $this->redirect('edit', null, null, array('ecosystemId' => $ecosystem->getUid()));
        //====
    }


    /**
     * action myList
     *
     * @return void
     */
    public function myListAction()
    {
        $this->view->assign('ecosystemList', $this->ecosystemRepository->findByFrontendUser($this->getFrontendUser()));
    }


    /**
     * action delete
     *
     * @param \RKW\RkwEcosystem\Domain\Model\Ecosystem $ecosystem
     * @param bool $redirectToMyList
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @return void
     */
    public function deleteAction(\RKW\RkwEcosystem\Domain\Model\Ecosystem $ecosystem, $redirectToMyList = true)
    {
        $this->addFlashMessage(
            \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('ecosystemController.message.deleted', 'rkw_ecosystem'),
            '',
            \TYPO3\CMS\Core\Messaging\AbstractMessage::OK
        );
        $this->ecosystemRepository->remove($ecosystem);

        if ($redirectToMyList) {
            $this->redirect('myList', null, null, null, intval($this->settings['myListPid']));
        } else {
            $this->redirect('edit', null, null, array('ecosystemId' => -1), intval($this->settings['ecosystemPid']));
        }
        //===
    }


    /**
     * Id of logged User
     *
     * @return integer
     */
    protected function getFrontendUserId()
    {
        // is $GLOBALS set?
        if (
            ($GLOBALS['TSFE'])
            && ($GLOBALS['TSFE']->loginUser)
            && ($GLOBALS['TSFE']->fe_user->user['uid'])
        ) {
            return intval($GLOBALS['TSFE']->fe_user->user['uid']);
            //===
        }

        return false;
        //===
    }


    /**
     * Returns current logged in user object
     *
     * @return \RKW\RkwRegistration\Domain\Model\FrontendUser|NULL
     */
    protected function getFrontendUser()
    {
        /** @var \RKW\RkwRegistration\Domain\Repository\FrontendUserRepository $frontendUserRepository */
        $this->frontendUser = $this->frontendUserRepository->findByIdentifier($this->getFrontendUserId());

        if ($this->frontendUser instanceof \TYPO3\CMS\Extbase\Domain\Model\FrontendUser) {
            return $this->frontendUser;
            //===
        }

        return null;
        //===
    }


    /**
     * Id of logged User
     *
     * @return \RKW\RkwEcosystem\Domain\Model\Ecosystem $ecosystem
     */
    protected function getEcosystemFromSession()
    {
        return unserialize($GLOBALS['TSFE']->fe_user->getKey('ses', 'rkw_ecosystem'));
        //===
    }

    /**
     * Id of logged User
     *
     * @param \RKW\RkwEcosystem\Domain\Model\Ecosystem $ecosystem
     * @return void
     */
    protected function setEcosystemToSession($ecosystem)
    {
        $GLOBALS['TSFE']->fe_user->setKey('ses', 'rkw_ecosystem', serialize($ecosystem));
        CookieService::setKey('rkw_ecosystem', serialize($ecosystem));
        $GLOBALS['TSFE']->storeSessionData();
    }

    /**
     * Returns logger instance
     *
     * @return \TYPO3\CMS\Core\Log\Logger
     */
    protected function getLogger()
    {
        if (! $this->logger) {
            $this->logger = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Log\\LogManager')->getLogger(__CLASS__);
        }
        
        return $this->logger;
        //===
    }    

}
