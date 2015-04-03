<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 9:03 PM
 */

namespace YGL;

use ODataQuery\ODataResourceInterface;
use YGL\Leads\YGLLead;
use YGL\Leads\Collection\YGLLeadCollection;
use YGL\Properties\YGLProperty;
use YGL\Leads\Request\YGLLeadRequest;
use YGL\Properties\Request\YGLPropertyRequest;
use YGL\Reference\Ambulations\Request\YGLAmbulationRequest;
use YGL\Reference\Amenities\Request\YGLAmenitiesRequest;
use YGL\Reference\ApartmentTypes\Request\YGLApartmentTypeRequest;
use YGL\Reference\CareLevels\Request\YGLCareLevelsRequest;
use YGL\Reference\ContactPreferences\Request\YGLContactPreferencesRequest;
use YGL\Reference\ContactTimePreferences\Request\YGLContactTimePreferencesRequest;
use YGL\Reference\CurrentLivingSituations\Request\YGLCurrentLivingSituationsRequest;
use YGL\Reference\FamilyStatuses\Request\YGLFamilyStatusesRequest;
use YGL\Reference\FundingTypes\Request\YGLFundingTypesRequest;
use YGL\Reference\LeadPriortities\Request\YGLLeadPrioritiesRequest;
use YGL\Reference\MemoryLosses\Request\YGLMemoryLossesRequest;
use YGL\Reference\RelationsToResident\Request\YGLRelationsToResidentRequest;
use YGL\Reference\TaskTypes\Request\YGLTaskTypesRequest;
use YGL\ReferralSource\Request\YGLReferralSourceRequest;
use YGL\Tasks\Request\YGLTaskRequest;
use YGL\Users\Request\YGLUserRequest;
use YGL\Tasks\YGLTask;
use YGL\Tasks\Collection\YGLTaskCollection;

class YGLClient
{
    protected $username;
    protected $password;

    public function __construct($accessToken = null, $password = null)
    {
        if (isset($accessToken)) {
            $this->setAccessToken($accessToken, $password);
        }
    }

    public function setAccessToken($userToken, $password = null)
    {
        if (!isset($password)) {
            list($username, $password) = explode(
                ':',
                base64_decode($userToken)
            );
            $this->username = $username;
            $this->password = $password;
        } else {
            $this->username = $userToken;
            $this->password = $password;
        }

        return $this;
    }

    public function getAccessToken()
    {
        return base64_encode($this->username . ':' . $this->password);
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getProperties(
        $id = null,
        $limit = 20,
        $page = 0,
        ODataResourceInterface $query = null
    ) {
        $request = new YGLPropertyRequest($this, $id, $limit, $page, $query);

        return $request->send();
    }

    public function getLeads(
        YGLProperty $property,
        $id = null,
        $limit = 20,
        $page = 0,
        ODataResourceInterface $query = null
    ) {
        $request = new YGLLeadRequest($this, $property, $id, $limit, $page, $query);

        return $request->send();
    }

    public function addLead(YGLProperty $property, YGLLead $lead)
    {
        $request = new YGLLeadRequest($this, $property);
        $request->setBody($lead);

        return $request->send();
    }

    public function addLeads(YGLProperty $property, YGLLeadCollection $leads)
    {
        $request = new YGLLeadRequest($this, $property);
        $request->setBody($leads);

        return $request->send();
    }

    public function getTasks(
        YGLProperty $property,
        YGLLead $lead = null,
        $id = null,
        ODataResourceInterface $query = null
    ) {
        $request = new YGLTaskRequest($this, $property, $lead, $id, $query);

        return $request->send();
    }

    public function addTask(YGLProperty $property, YGLLead $lead, YGLTask $task)
    {
        $request = new YGLTaskRequest($this, $property, $lead);
        $request->setBody($task);

        return $request->send();
    }

    public function addTasks(
        YGLProperty $property,
        YGLLead $lead,
        YGLTaskCollection $tasks
    ) {
        $request = new YGLTaskRequest($this, $property, $lead);
        $request->setBody($tasks);

        return $request->send();
    }

    public function getUsers(
        YGLProperty $property,
        $id = null,
        ODataResourceInterface $query = null
    ) {
        $request = new YGLUserRequest($this, $property, $id, $query);

        return $request->send();
    }

    public function getReferralSources(YGLProperty $property,
        $id = null,
        ODataResourceInterface $query = null) {
        $request = new YGLReferralSourceRequest($this, $property, $id, $query);
        return $request->send();
    }

    /**
     * Reference calls
     */

    public function getAmbulations($subscriptionId = 0, ODataResourceInterface $query = NULL) {
        $request = new YGLAmbulationRequest($this, $subscriptionId, $query);
        return $request->send();
    }

    public function getAmenities($subscriptionId = 0, ODataResourceInterface $query = NULL) {
        $request = new YGLAmenitiesRequest($this, $subscriptionId, $query);
        return $request->send();
    }

    public function getApartmentTypes($subscriptionId = 0, ODataResourceInterface $query = NULL) {
        $request = new YGLApartmentTypeRequest($this, $subscriptionId, $query);
        return $request->send();
    }

    public function getCareLevels($subscriptionId = 0, ODataResourceInterface $query = NULL) {
        $request = new YGLCareLevelsRequest($this, $subscriptionId, $query);
        return $request->send();
    }

    public function getContactPreferences($subscriptionId = 0, ODataResourceInterface $query = NULL) {
        $request = new YGLContactPreferencesRequest($this, $subscriptionId, $query);
        return $request->send();
    }

    public function getContactTimePreferences($subscriptionId = 0, ODataResourceInterface $query = NULL) {
        $request = new YGLContactTimePreferencesRequest($this, $subscriptionId, $query);
        return $request->send();
    }

    public function getCurrentLivingSituations($subscriptionId = 0, ODataResourceInterface $query = NULL) {
        $request = new YGLCurrentLivingSituationsRequest($this, $subscriptionId, $query);
        return $request->send();
    }

    public function getFamilyStatuses($subscriptionId = 0, ODataResourceInterface $query = NULL) {
        $request = new YGLFamilyStatusesRequest($this, $subscriptionId, $query);
        return $request->send();
    }

    public function getFundingTypes($subscriptionId = 0, ODataResourceInterface $query = NULL) {
        $request = new YGLFundingTypesRequest($this, $subscriptionId, $query);
        return $request->send();
    }

    public function getLeadPriorities($subscriptionId = 0, ODataResourceInterface $query = NULL) {
        $request = new YGLLeadPrioritiesRequest($this, $subscriptionId, $query);
        return $request->send();
    }

    public function getMemoryLosses($subscriptionId = 0, ODataResourceInterface $query = NULL) {
        $request = new YGLMemoryLossesRequest($this, $subscriptionId, $query);
        return $request->send();
    }

    public function getRelationsToResident($subscriptionId = 0, ODataResourceInterface $query = NULL) {
        $request = new YGLRelationsToResidentRequest($this, $subscriptionId, $query);
        return $request->send();
    }

    public function getTaskTypes($subscriptionId = 0, ODataResourceInterface $query = NULL) {
        $request = new YGLTaskTypesRequest($this, $subscriptionId, $query);
        return $request->send();
    }

} 