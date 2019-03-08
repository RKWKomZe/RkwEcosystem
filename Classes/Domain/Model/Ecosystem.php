<?php

namespace RKW\RkwEcosystem\Domain\Model;

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
class Ecosystem extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * uid
     *
     * @var integer
     */
    protected $uid;

    /**
     * title
     *
     * @var string
     */
    protected $title;

    /**
     * titleAlt
     *
     * @var string
     */
    protected $titleAlt;

    /**
     * education
     *
     * @var string
     */
    protected $education = '';

    /**
     * politics
     *
     * @var string
     */
    protected $politics = '';

    /**
     * endCustomer
     *
     * @var string
     */
    protected $endCustomer = '';

    /**
     * potentialFounder
     *
     * @var string
     */
    protected $potentialFounder = '';

    /**
     * inspiration
     *
     * @var string
     */
    protected $inspiration = '';

    /**
     * startUps
     *
     * @var string
     */
    protected $startUps = '';

    /**
     * trend
     *
     * @var string
     */
    protected $trend = '';

    /**
     * demandForSolution
     *
     * @var string
     */
    protected $demandForSolution = '';

    /**
     * company
     *
     * @var string
     */
    protected $company = '';

    /**
     * assistance
     *
     * @var string
     */
    protected $assistance = '';

    /**
     * businessCustomer
     *
     * @var string
     */
    protected $businessCustomer = '';

    /**
     * remark
     *
     * @var string
     */
    protected $remark = '';

    /**
     * frontendUser
     *
     * @var \RKW\RkwRegistration\Domain\Model\FrontendUser
     */
    protected $frontendUser = null;

    /**
     * educationValue
     *
     * @var integer
     */
    protected $educationValue = 0;

    /**
     * politicsValue
     *
     * @var integer
     */
    protected $politicsValue = 0;

    /**
     * endCustomerValue
     *
     * @var integer
     */
    protected $endCustomerValue = 0;

    /**
     * potentialFounderValue
     *
     * @var integer
     */
    protected $potentialFounderValue = 0;

    /**
     * inspirationValue
     *
     * @var integer
     */
    protected $inspirationValue = 0;

    /**
     * startUpsValue
     *
     * @var integer
     */
    protected $startUpsValue = 0;

    /**
     * trendValue
     *
     * @var integer
     */
    protected $trendValue = 0;

    /**
     * demandForSolutionValue
     *
     * @var integer
     */
    protected $demandForSolutionValue = 0;

    /**
     * companyValue
     *
     * @var integer
     */
    protected $companyValue = 0;

    /**
     * assistanceValue
     *
     * @var integer
     */
    protected $assistanceValue = 0;

    /**
     * businessCustomerValue
     *
     * @var integer
     */
    protected $businessCustomerValue = 0;

    /**
     * Returns the uid
     *
     * @return string $uid
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Sets the uid
     *
     * @param string $uid
     * @return void
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the titleAlt
     *
     * @return string $titleAlt
     */
    public function getTitleAlt()
    {
        return $this->titleAlt;
    }

    /**
     * Sets the titleAlt
     *
     * @param string $titleAlt
     * @return void
     */
    public function setTitleAlt($titleAlt)
    {
        $this->titleAlt = $titleAlt;
    }

    /**
     * Returns the education
     *
     * @return string $education
     */
    public function getEducation()
    {
        return $this->education;
    }

    /**
     * Sets the education
     *
     * @param string $education
     * @return void
     */
    public function setEducation($education)
    {
        $this->education = $education;
    }

    /**
     * Returns the politics
     *
     * @return string $politics
     */
    public function getPolitics()
    {
        return $this->politics;
    }

    /**
     * Sets the politics
     *
     * @param string $politics
     * @return void
     */
    public function setPolitics($politics)
    {
        $this->politics = $politics;
    }

    /**
     * Returns the endCustomer
     *
     * @return string $endCustomer
     */
    public function getEndCustomer()
    {
        return $this->endCustomer;
    }

    /**
     * Sets the endCustomer
     *
     * @param string $endCustomer
     * @return void
     */
    public function setEndCustomer($endCustomer)
    {
        $this->endCustomer = $endCustomer;
    }

    /**
     * Returns the potentialFounder
     *
     * @return string $potentialFounder
     */
    public function getPotentialFounder()
    {
        return $this->potentialFounder;
    }

    /**
     * Sets the potentialFounder
     *
     * @param string $potentialFounder
     * @return void
     */
    public function setPotentialFounder($potentialFounder)
    {
        $this->potentialFounder = $potentialFounder;
    }

    /**
     * Returns the inspiration
     *
     * @return string $inspiration
     */
    public function getInspiration()
    {
        return $this->inspiration;
    }

    /**
     * Sets the inspiration
     *
     * @param string $inspiration
     * @return void
     */
    public function setInspiration($inspiration)
    {
        $this->inspiration = $inspiration;
    }

    /**
     * Returns the startUps
     *
     * @return string $startUps
     */
    public function getStartUps()
    {
        return $this->startUps;
    }

    /**
     * Sets the startUps
     *
     * @param string $startUps
     * @return void
     */
    public function setStartUps($startUps)
    {
        $this->startUps = $startUps;
    }

    /**
     * Returns the trend
     *
     * @return string $trend
     */
    public function getTrend()
    {
        return $this->trend;
    }

    /**
     * Sets the trend
     *
     * @param string $trend
     * @return void
     */
    public function setTrend($trend)
    {
        $this->trend = $trend;
    }

    /**
     * Returns the demandForSolution
     *
     * @return string $demandForSolution
     */
    public function getDemandForSolution()
    {
        return $this->demandForSolution;
    }

    /**
     * Sets the demandForSolution
     *
     * @param string $demandForSolution
     * @return void
     */
    public function setDemandForSolution($demandForSolution)
    {
        $this->demandForSolution = $demandForSolution;
    }

    /**
     * Returns the company
     *
     * @return string $company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Sets the company
     *
     * @param string $company
     * @return void
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * Returns the assistance
     *
     * @return string $assistance
     */
    public function getAssistance()
    {
        return $this->assistance;
    }

    /**
     * Sets the assistance
     *
     * @param string $assistance
     * @return void
     */
    public function setAssistance($assistance)
    {
        $this->assistance = $assistance;
    }

    /**
     * Returns the businessCustomer
     *
     * @return string $businessCustomer
     */
    public function getBusinessCustomer()
    {
        return $this->businessCustomer;
    }

    /**
     * Sets the businessCustomer
     *
     * @param string $businessCustomer
     * @return void
     */
    public function setBusinessCustomer($businessCustomer)
    {
        $this->businessCustomer = $businessCustomer;
    }

    /**
     * Returns the remark
     *
     * @return string $remark
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * Sets the remark
     *
     * @param string $remark
     * @return void
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;
    }

    /**
     * Returns the frontendUser
     *
     * @return \RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUser
     */
    public function getFrontendUser()
    {
        return $this->frontendUser;
    }

    /**
     * Sets the frontendUser
     *
     * @param \RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUser
     * @return void
     */
    public function setFrontendUser(\RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUser)
    {
        $this->frontendUser = $frontendUser;
    }

    /**
     * Returns the educationValue
     *
     * @return integer $educationValue
     */
    public function getEducationValue()
    {
        return $this->educationValue;
    }

    /**
     * Sets the educationValue
     *
     * @param integer $educationValue
     * @return void
     */
    public function setEducationValue($educationValue)
    {
        $this->educationValue = $educationValue;
    }

    /**
     * Returns the politicsValue
     *
     * @return integer $politicsValue
     */
    public function getPoliticsValue()
    {
        return $this->politicsValue;
    }

    /**
     * Sets the politicsValue
     *
     * @param integer $politicsValue
     * @return void
     */
    public function setPoliticsValue($politicsValue)
    {
        $this->politicsValue = $politicsValue;
    }

    /**
     * Returns the endCustomerValue
     *
     * @return integer $endCustomerValue
     */
    public function getEndCustomerValue()
    {
        return $this->endCustomerValue;
    }

    /**
     * Sets the endCustomerValue
     *
     * @param integer $endCustomerValue
     * @return void
     */
    public function setEndCustomerValue($endCustomerValue)
    {
        $this->endCustomerValue = $endCustomerValue;
    }

    /**
     * Returns the potentialFounderValue
     *
     * @return integer $potentialFounderValue
     */
    public function getPotentialFounderValue()
    {
        return $this->potentialFounderValue;
    }

    /**
     * Sets the potentialFounderValue
     *
     * @param integer $potentialFounderValue
     * @return void
     */
    public function setPotentialFounderValue($potentialFounderValue)
    {
        $this->potentialFounderValue = $potentialFounderValue;
    }

    /**
     * Returns the inspirationValue
     *
     * @return integer $inspirationValue
     */
    public function getInspirationValue()
    {
        return $this->inspirationValue;
    }

    /**
     * Sets the inspirationValue
     *
     * @param integer $inspirationValue
     * @return void
     */
    public function setInspirationValue($inspirationValue)
    {
        $this->inspirationValue = $inspirationValue;
    }

    /**
     * Returns the startUpsValue
     *
     * @return integer $startUpsValue
     */
    public function getStartUpsValue()
    {
        return $this->startUpsValue;
    }

    /**
     * Sets the startUpsValue
     *
     * @param integer $startUpsValue
     * @return void
     */
    public function setStartUpsValue($startUpsValue)
    {
        $this->startUpsValue = $startUpsValue;
    }

    /**
     * Returns the trendValue
     *
     * @return integer $trendValue
     */
    public function getTrendValue()
    {
        return $this->trendValue;
    }

    /**
     * Sets the trendValue
     *
     * @param integer $trendValue
     * @return void
     */
    public function setTrendValue($trendValue)
    {
        $this->trendValue = $trendValue;
    }

    /**
     * Returns the demandForSolutionValue
     *
     * @return integer $demandForSolutionValue
     */
    public function getDemandForSolutionValue()
    {
        return $this->demandForSolutionValue;
    }

    /**
     * Sets the demandForSolutionValue
     *
     * @param integer $demandForSolutionValue
     * @return void
     */
    public function setDemandForSolutionValue($demandForSolutionValue)
    {
        $this->demandForSolutionValue = $demandForSolutionValue;
    }

    /**
     * Returns the companyValue
     *
     * @return integer $companyValue
     */
    public function getCompanyValue()
    {
        return $this->companyValue;
    }

    /**
     * Sets the companyValue
     *
     * @param integer $companyValue
     * @return void
     */
    public function setCompanyValue($companyValue)
    {
        $this->companyValue = $companyValue;
    }

    /**
     * Returns the assistanceValue
     *
     * @return integer $assistanceValue
     */
    public function getAssistanceValue()
    {
        return $this->assistanceValue;
    }

    /**
     * Sets the assistanceValue
     *
     * @param integer $assistanceValue
     * @return void
     */
    public function setAssistanceValue($assistanceValue)
    {
        $this->assistanceValue = $assistanceValue;
    }

    /**
     * Returns the businessCustomerValue
     *
     * @return integer $businessCustomerValue
     */
    public function getBusinessCustomerValue()
    {
        return $this->businessCustomerValue;
    }

    /**
     * Sets the businessCustomerValue
     *
     * @param integer $businessCustomerValue
     * @return void
     */
    public function setBusinessCustomerValue($businessCustomerValue)
    {
        $this->businessCustomerValue = $businessCustomerValue;
    }
}
