<?php

namespace Tests\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;

class AdmissionControllerTest extends CIUnitTestCase
{
    use ControllerTestTrait;
    use DatabaseTestTrait;

    protected $migrate     = true;
    protected $migrateOnce = false;
    protected $refresh     = true;
    protected $namespace   = 'App';

    public function testShowsAdmissionForm()
    {
        // Simulate an HTTP GET request to the admission route
        $result = $this->withURI('http://localhost:8081/admission')
                       ->controller(\App\Controllers\Web\AdmissionController::class)
                       ->execute('index');

        // It should return a 200 HTTP OK status code
        $this->assertTrue($result->isOK());
        
        // It should load the correct view containing this specific form text
        $this->assertStringContainsString('Student Admission Portal', $result->getBody());
        $this->assertStringContainsString('First Name', $result->getBody());
    }

    public function testSubmitFormWithMissingDataReturnsErrors()
    {
        // Simulate an HTTP POST request with empty fields
        $result = $this->withURI('http://localhost:8081/admission/submit')
                       ->controller(\App\Controllers\Web\AdmissionController::class)
                       ->execute('submit');

        // It should redirect the user back to the form page
        $this->assertTrue($result->isRedirect());
        
        // Let's verify it flashed errors to the session
        $this->assertTrue(session()->has('errors'));
    }
}
