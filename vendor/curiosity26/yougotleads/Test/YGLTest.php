<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 9:05 PM
 */

// Test Encryption: eWdsQXBpVGVzdDE6cGFzc3dvcmQ=
// Test User = yglApiTest1
// Test Password = password

use \YGL\YGLClient;

class YGLTest extends \PHPUnit_Framework_TestCase {
    private $accessToken = 'eWdsQXBpVGVzdDE6cGFzc3dvcmQ=';

    /**
     * @return \YGL\YGLClient
     */
    public function testConnection() {
        $ygl = new YGLClient($this->accessToken);
        $request = $this->getMockForAbstractClass('\YGL\Request\YGLRequest', array($ygl));
        $request->setFunction('properties');
        $response = $request->send();
        $this->assertTrue($response->isSuccess());
        return $ygl;
    }

    /**
     * @depends testConnection
     * @param YGLClient $ygl
     * @return \YGL\Properties\Collection\YGLPropertyCollection
     */
    public function testPropertiesList(YGLClient $ygl) {
        $properties = $ygl->getProperties();
        $properties->setClient($ygl);
        $this->assertNotEmpty($properties);
        return $properties;
    }

    /**
     * @depends testPropertiesList
     * @param \YGL\Properties\Collection\YGLPropertyCollection $properties
     * @return \YGL\Properties\YGLProperty
     */
    public function testPropertiesGet(\YGL\Properties\Collection\YGLPropertyCollection $properties) {
        $property = $properties->current();
        $ygl = $properties->getClient();
        $this->assertTrue($ygl instanceof YGLClient);
        if ($ygl instanceof YGLClient) {
            $get_property = $ygl->getProperties($property->id);
            $this->assertEquals($property->id, $get_property->id);
            $this->assertEquals($property->name, $get_property->name);
        }
        return $property;
    }

    /**
     * @depends testPropertiesList
     * @param \YGL\Properties\Collection\YGLPropertyCollection $properties
     * @return \YGL\Leads\Collection\YGLLeadCollection
     */
    public function testLeadsList(\YGL\Properties\Collection\YGLPropertyCollection $properties) {
        $property = $properties->current();
        $leads = $property->getLeads();
        $this->assertNotEmpty($leads);
        return $leads;
    }

    /**
     * @depends testLeadsList
     * @param \YGL\Leads\Collection\YGLLeadCollection $leads
     */
    public function testLeadsGet(\YGL\Leads\Collection\YGLLeadCollection $leads) {
         $lead = $leads->rewind()->current();
         $get_lead = $lead->getProperty()->getLeads($lead->id);
         $this->assertEquals($lead->id, $get_lead->id);
         $this->assertEquals($lead->primaryContact->id, $get_lead->primaryContact->id);

        return $lead;
    }

    /**
     * @depends testPropertiesList
     * @param \YGL\Properties\Collection\YGLPropertyCollection $properties
     * @return \YGL\Leads\YGLLead
     */
    public function testLeadPost(\YGL\Properties\Collection\YGLPropertyCollection $properties) {
        $property = $properties->current();
        $lead = new \YGL\Leads\YGLLead(array(
            'addedOn' => new DateTime(),
            'associate' => 'SageAPITest',
            'primaryContact' => new \YGL\Leads\Contact\YGLContact(array(
                'firstName' => 'Bob',
                'lastName'  => 'Jones',
                'gender'    => 'M',
                'isInquirer'=> TRUE,
                'address'   => new \YGL\Leads\Address\YGLAddress(array(
                    'address1'  => '17 Pierce Lane',
                    'city'      => 'Montoursville',
                    'state'     => 'Pennsylvania',
                    'zip'       =>  '17754'
                ))
            )),
            'userName' => 'Guest5'
        ));
        $response = $property->addLead($lead);
        $this->assertEquals('Bob', $response->primaryContact->firstName);
        $this->assertEquals('Jones', $response->primaryContact->lastName);
        return $response;
    }

    /**
     * @depends testPropertiesGet
     * @param \YGL\Properties\YGLProperty $property
     */
    public function testPropertyTasksList(\YGL\Properties\YGLProperty $property) {
        $tasks = $property->getTasks();
        $this->assertNotEmpty($tasks);
    }

    /**
     * @depends testLeadsGet
     * @param \YGL\Leads\YGLLead $lead
     * @return mixed
     */
    public function testLeadTasksList(\YGL\Leads\YGLLead $lead) {
        $tasks = $lead->getTasks();
        $this->assertNotEmpty($tasks);
        return $tasks->current();
    }

    /**
     * @depends testLeadTasksList
     * @param \YGL\Tasks\YGLTask $task
     */
    public function testLeadTasksGet(\YGL\Tasks\YGLTask $task) {
        $lead = $task->getLead();
        $get_task = $lead->getTasks($task->id);
        $this->assertEquals($task->id, $get_task->id);
    }

    /**
     * @depends testLeadsGet
     * @param \YGL\Leads\YGLLead $lead
     *
     * Required fields: "FollowupDate" "TaskTypeId", "TaskTitle"
     */

    public function testLeadTasksAdd(\YGL\Leads\YGLLead $lead) {
        $task = new \YGL\Tasks\YGLTask(array(
          'contactId' => 135224,
          'taskTitle' => 'Test Post Task',
          'taskTypeId'=> 24,
          'priorityId' => 2,
          'followupDate' => '01/20/2015'
        ));
        $response = $lead->addTask($task);
        $this->assertNotNull($response->id);
    }

    /**
     * @depends testPropertiesGet
     * @param \YGL\Properties\YGLProperty $property
     * @return $this|bool|mixed|\YGL\Response\YGLResponse|\YGL\Users\YGLUser|\YGL\Users\Collection\YGLUsersCollection
     */
    public function testUsersList(\YGL\Properties\YGLProperty $property) {
        $users = $property->getUsers();
        $this->assertNotEmpty($users);
        return $users;
    }

    /**
     * @depends testUsersList
     * @param \YGL\Users\Collection\YGLUsersCollection $users
     * @TODO Getting uses by ID is not yet supported, test once it is
     */
    /*
    public function testUserGet(\YGL\Users\Collection\YGLUsersCollection $users) {
        $user = $users->current();
        $property = $users->getProperty();
        $get_user = $property->getUsers($user->id);
        $this->assertEquals($user->id,$get_user->id);
        $this->assertEquals($user->firstName.' '.$user->lastName, $get_user->firstName.' '.$get_user->lastName);

        $filter = new \ODataQuery\Filter\Operators\Logical\ODataEqualsOperator('FirstName', $user->firstName);
        $query = new \ODataQuery\ODataResource($filter->_and(new
        \ODataQuery\Filter\Operators\Logical\ODataEqualsOperator('LastName', 'A')));
        $get_user = $property->getUsers(NULL, $query);

        $this->assertEquals($user->id,$get_user->id);
        $this->assertEquals($user->firstName.' '.$user->lastName, $get_user->firstName.' '.$get_user->lastName);
    }
    */
    /**
     * @depends testConnection
     * @param YGLClient $ygl
     */
    public function testAmbulationsGet(YGLClient $ygl) {
        $response = $ygl->getAmbulations();
        $this->assertNotEmpty($response);
    }

    /**
     * @depends testConnection
     * @param YGLClient $ygl
     */
    public function testAmenitiesGet(YGLClient $ygl) {
        $response = $ygl->getAmenities();
        $this->assertNotEmpty($response);
    }

    /**
     * @depends testConnection
     * @param YGLClient $ygl
     */
    public function testApartmentTypesGet(YGLClient $ygl) {
        $response = $ygl->getApartmentTypes();
        $this->assertNotEmpty($response);
    }

    /**
     * @depends testConnection
     * @param YGLClient $ygl
     */
    public function testCareLevelsGet(YGLClient $ygl) {
        $response = $ygl->getCareLevels();
        $this->assertNotEmpty($response);
    }

    /**
     * @depends testConnection
     * @param YGLClient $ygl
     */
    public function testContactPreferencesGet(YGLClient $ygl) {
        $response = $ygl->getContactPreferences();
        $this->assertNotEmpty($response);
    }

    /**
     * @depends testConnection
     * @param YGLClient $ygl
     */
    public function testContactTimePreferencesGet(YGLClient $ygl) {
        $response = $ygl->getContactTimePreferences();
        $this->assertNotEmpty($response);
    }

    /**
     * @depends testConnection
     * @param YGLClient $ygl
     */
    public function testCurrentLivingSituationsGet(YGLClient $ygl) {
        $response = $ygl->getCurrentLivingSituations();
        $this->assertNotEmpty($response);
    }

    /**
     * @depends testConnection
     * @param YGLClient $ygl
     */
    public function testFamilyStatusesGet(YGLClient $ygl) {
        $response = $ygl->getFamilyStatuses();
        $this->assertNotEmpty($response);
    }

    /**
     * @depends testConnection
     * @param YGLClient $ygl
     */
    public function testFundingTypesGet(YGLClient $ygl) {
        $response = $ygl->getFundingTypes();
        $this->assertNotEmpty($response);
    }

    /**
     * @depends testConnection
     * @param YGLClient $ygl
     */
    public function testLeadPriorities(YGLClient $ygl) {
        $response = $ygl->getLeadPriorities();
        $this->assertNotEmpty($response);
    }

    /**
     * @depends testConnection
     * @param YGLClient $ygl
     */
    public function testMemoryLossesGet(YGLClient $ygl) {
        $response = $ygl->getMemoryLosses();
        $this->assertNotEmpty($response);
    }

    /**
     * @depends testConnection
     * @param YGLClient $ygl
     */
    public function testRelationsToResidentGet(YGLClient $ygl) {
        $response = $ygl->getRelationsToResident();
        $this->assertNotEmpty($response);
    }

    /**
     * @depends testConnection
     * @param YGLClient $ygl
     */
    public function testTaskTypesGet(YGLClient $ygl) {
        $response = $ygl->getTaskTypes();
        $this->assertNotEmpty($response);
    }

    /**
     * @depends testPropertiesGet
     * @param \YGL\Properties\YGLProperty $property
     */
    public function testReferralSourcesGet(\YGL\Properties\YGLProperty $property) {
        $response = $property->getReferralSources();
        $this->assertNotEmpty($response);
    }
}
 