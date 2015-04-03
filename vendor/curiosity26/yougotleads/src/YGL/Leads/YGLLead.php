<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/6/14
 * Time: 9:49 PM
 */

namespace YGL\Leads;


use YGL\Properties\YGLProperty;
use YGL\ReferralSource\Collection\YGLReferralSourceCollection;
use YGL\ReferralSource\YGLReferralSource;
use YGL\Tasks\YGLTask;
use YGL\Tasks\Collection\YGLTaskCollection;
use YGL\YGLClient;
use YGL\YGLJsonObject;

class YGLLead extends YGLJsonObject {
  protected $property;
  protected $uniqueId = 'leadId';

  public function __construct($values = NULL, YGLClient $client = NULL) {
    if (isset($client)) {
      $this->setClient($client);
    }

    $this->_properties = array(
      'leadId'             => self::integerProperty(),
      'contactId'          => self::integerProperty(),
      'secondaryContactId' => self::integerProperty(),
      'addedOn'            => self::datetimeProperty(),
      'associate'          => self::stringProperty(45),
      'budgetMin'          => self::integerProperty(),
      'budgetMax'          => self::integerProperty(),
      'callCenterId'       => self::stringProperty(),
      'createdOn'          => self::datetimeProperty(),
      'dischargePlannerId' => self::integerProperty(),
      'familyStatusId'     => self::integerProperty(),
      'fundingType'        => self::integerProperty(),
      'inquiryMethod'      => self::stringProperty(30),
      'leadResident'       => self::residentProperty(),
      'notes'              => self::notesProperty(),
      'ownership'          => self::stringProperty(1),
      'primaryContact'     => self::contactProperty(),
      'priority'           => self::integerProperty(),
      'referralSources'    => self::referralSourceCollectionProperty(),
      'residentContact'    => self::contactProperty(),
      'secondaryContact'   => self::contactProperty(),
      'secondFundingType'  => self::integerProperty(),
      'userName'           => self::stringProperty(10),
      'veteran'            => self::stringProperty(1)
    );

    parent::__construct((array) $values);
  }

  public function setClient(YGLClient $client) {
    parent::setClient($client);
    if ($this->property instanceof YGLProperty) {
      $this->property->setClient($client);
    }

    if ($this->referralSources instanceof YGLReferralSourceCollection) {
      $this->referralSources->setClient($client);
    }

    if ($this->tasks instanceof YGLTaskCollection) {
      $this->tasks->setClient($client);
    }

    return $this;
  }

  public function setProperty(YGLProperty $property) {
    $this->property = NULL;
    if (isset($this->client)) {
      $property->setClient($this->client);
    }
    elseif ($client = $property->getClient()) {
      $this->setClient($client);
    }
    $this->property = $property;
  }

  public function getProperty() {
    return $this->property;
  }

  public function addReferralSource(YGLReferralSource $source) {
    if (!($this->referralSources instanceof YGLReferralSourceCollection)) {
      $this->referralSources = new YGLReferralSourceCollection($this->getClient());
    }
    return $this->referralSources->append($source);
  }

  public function setReferralSources(YGLReferralSourceCollection $sources) {
    if ($this->getClient() !== null) {
      $sources->setClient($this->getClient());
    }
    $this->referralSources = $sources;

    return $this;
  }

  public function getReferralSources() {
    return $this->referralSources;
  }

  /**
   * @param \YGL\Tasks\YGLTask $task
   * @return $this|bool|mixed|\YGL\Response\YGLResponse
   */
  public function addTask(YGLTask $task) {
    $task->setLead($this);
    if (($client = $this->getClient(
      )) && $client instanceof YGLClient && ($property = $this->getProperty(
      )) &&
      $property instanceof YGLProperty
    ) {
      return $client->addTask($property, $this, $task);
    }

    return FALSE;
  }

  /**
   * @param \YGL\Tasks\Collection\YGLTaskCollection $tasks
   * @return $this|bool|mixed|\YGL\Response\YGLResponse
   */
  public function addTasks(YGLTaskCollection $tasks) {
    $tasks->setLead($this);
    if (($client = $this->getClient(
      )) && $client instanceof YGLClient && ($property = $this->getProperty(
      )) &&
      $property instanceof YGLProperty
    ) {
      return $client->addTasks($property, $this, $tasks);
    }

    return FALSE;
  }

  /**
   * @param null $id
   * @return $this|mixed|null|\YGL\Response\YGLResponse|\YGL\Tasks\Collection\YGLTaskCollection
   */
  public function getTasks($id = NULL) {
    if (($client = $this->getClient(
      )) && $client instanceof YGLClient && ($property = $this->getProperty(
      )) &&
      $property instanceof YGLProperty
    ) {
      return $client->getTasks($property, $this, $id);
    }

    return NULL;
  }
} 