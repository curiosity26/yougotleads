YGL
===

YouGotLeads PHP SDK - https://www.youvegotleads.com/webservices/documentation

<h2>Requirements</h2>
<ul>
    <li>PHP >= 5.4</li>
    <li>cURL PHP Extension (tested with libcurl 7.37 installed)</li>
    <li>JSON PHP Extension >= v1.2 (PHP 5.4+ has the JSON functions required)</li>
    <li>Composer (http://getcomposer.org/)</li>
</ul>

<h2>Installation</h2>
<h3>As a Composer Requirement</h3>
When developing an application which also makes use of composer, you can easily include the YGL library by adding the
following line to your composer.json file:

```JSON
{
    "require": {
        "curiosity26/yougotleads": "@stable"
    }
}
```
<h3>Via the Autoloader</h3>
First you have to create the autoloader file by running the following command inside the YGL project folder:
```BASH
composer install
```
You can also update the YGL code when new releases are available by running:
```BASH
composer update
```
Once composer completes, a new directory will be created in the YGL project folder named 'vendor'. Within the 'vendor'
folder is the 'autoload.php' file.

You can include the autoload.php file during the bootstrap of your application or at the top of any PHP files where the
YGL library will be used by adding the following code:
```PHP
<?php
    require_once "path/to/YGL/vendor/autoload.php";
?>
```

<h2>Usage</h2>
Using the YGL library is pretty simple. The YGLClient object acts as a client and a factory, sending authenticated HTTP
requests to YGL and creating the objects and collections of objects from HTTP responses.

The first thing you need to do to start using YGL is create a client from the YGLClient class and pass your authentication
token to it. The client will also accept a YGL username and password. After all, the auth token is simply just a 
base64 encoded string matching the format 'username:password'.

For the sake of simplicity, let's suppose you or your editor software has added the proper namespaces to the top of your
file.

```PHP
<?php
    $client = new YGLClient('youryardiauthtoken');
    // OR
    $client = new YGLClient('youryardiuser', 'yourpassword');
?>
```

Once the client is initialized, you can request your Property or the collection of Properties available to you. All
collections in this library function pretty much the same. You can add, remove from the collection or use the collection
like an array of objects. A YGLPropertyCollection is a collection of YGLProperty objects. The same goes for 
YGLLeadCollections, YGLTaskCollections and so forth.

All requests from the YGLClient will be a form of YGLCollection or YGLJsonObject (if only one item is returned) if the 
request was processed successfully. Otherwise a YGLResponse object is returned which you will be able to gather the 
response code (via <code>YGLResponse::getResponseCode()</code>) and the error message 
(via <code>YGLResponse::getBody()</code>). If you need more details about the raw response, you can get the 
HTTPResponse object by calling <code>YGLResponse::getRawResponse()</code>.

<h3>Properties</h3>
When requesting a list of properties, the library has a default limit of 20. You can override this limit by passing a 
new limit as the second parameter of the getProperties function. You can also page ahead by passing the page number of
results as the third parameter. Pages start at 0.

```PHP
<?php
    // Let's continue to assume that $client is the YGLClient from before
    $properties = $client->getProperties(); // returns YGLPropertyCollection unless only 1 is returned then YGLProperty
    // Overriding limits, going to 2nd page of results
    $properties = $client->getProperties(NULL, 100, 1); // returns YGLPropertyCollection unless only 1 is returned then YGLProperty
    // Or if you know the ID of your Property, the pager won't help here.
    $property = $client->getProperties($idofmyproperty); // returns YGLProperty
?>
```

<h3>Leads</h3>
Using a YGLProperty object, you can easily get leads directly from the object. Or you can pass the Property back into
a YGLClient object (same or different) to return leads.

```PHP
<?php
    // Get leads from the property
    $leads = $property->getLeads(); // return YGLLeadsCollection or YGLLead if only one item in the response
    // Get leads from the client using the property
    $leads = $client->getLeads($property); // same return value as before
    // Get a single lead by ID
    $lead = $property->getLeads($leadId);
?>
```

The API allows new leads to be posted. The YGL PHP SDK makes this process very simple:

```PHP
<?php
        $lead = new YGLLead(array(
            'addedOn' => new DateTime(),
            'associate' => 'Your Searchable Value Here',
            'primaryContact' => new YGLContact(array(
                'firstName' => 'Bob',
                'lastName'  => 'Jones',
                'gender'    => 'M',
                'isInquirer'=> TRUE,
                'address'   => new YGLAddress(array(
                    'address1'  => '111 North America Lane',
                    'city'      => 'Bumblesville',
                    'state'     => 'Pennsylvania',
                    'zip'       =>  '19920'
                ))
            )),
            'userName' => 'A Username on the System' // Use YGLClient::getUsers() for a list of available users
        ));
        // A YGLLead object will be returned if successful with all the proper values filled in
        // If unsuccessful a YGLResponse object is returned.
        $response = $property->addLead($lead); 
?>
```
<h3>Tasks</h3>
The same process is available for querying and posting Tasks. 

```PHP
<?php
    $tasks = $lead->getTasks();
    // Get a single task by Id
    $task = $lead->getTasks($taskId);
    // Post a new Task. The following fields are required
    $new_task = new YGLTask();
    $new_task->taskTitle = 'My new task';
    $new_task->taskTypeId = 24; // Mail
    $new_task->follupDate = '01/20/2015';
    $saved_task = $lead->addTask($new_task);
    print $new_task->id; // prints saved task's new id
?>
```

<h3>References</h3>
You can also get any of the reference functions that can be used with a request via the client as well. For all References,
a subscription ID can be passed as the first variable. Defaultly the subscription ID is 0, meaning all shared values.

The reference functions do support OData queries as their second (last) parameter, so you could use OData's expand or
search to find a Reference by Id or Name.

```PHP
<?php
    $subscriptionId = 0; // Not necessary (Shared)
    // Ambulations
    $ambulations = $client->getAmbulations($subscriptionId);
    //TaskTypes (technically unsupported at this time)
    $taskTypes = $client->getTaskTypes();
?>
```

<h3>Users</h3>
The API can also return a list of users, though currently you can't get a specific user by an ID. This library is built
to allow getting a User by its ID, but currently the system <code>FALSE</code>, regardless. It's most likely possible to
use OData, but it hasn't been tested.

```PHP
<?php
    $users = $client->getUsers();
?>
```