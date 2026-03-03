<?php

namespace Tests\Services;

use App\Services\AdmissionService;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

class AdmissionServiceTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate     = true;
    protected $migrateOnce = false;
    protected $refresh     = true;
    protected $namespace   = 'App';

    public function testProcessNewAdmissionSuccess()
    {
        $service = new AdmissionService();

        // Simulate incoming POST data from the form
        $postData = [
            'first_name' => 'Alice',
            'last_name'  => 'Wonderland',
            'email'      => 'alice.service.test@example.com',
            'phone'      => '1231231234',
            'course'     => 'Nursing',
            'dob'        => '1995-05-15'
        ];

        $result = $service->processNewAdmission($postData);

        // It should flag success as true
        $this->assertTrue($result['success']);
        
        // It should generate and return the correct success messages
        $this->assertStringContainsString('Application submitted successfully!', $result['message'] ?? '');
        $this->assertStringContainsString('Your tracking number is: ADM-', $result['message'] ?? '');
        
        // We ensure the Service successfully passed it down to the Model which saved it in the DB
        $this->seeInDatabase('admissions', ['email' => 'alice.service.test@example.com']);
    }

    public function testProcessNewAdmissionFailsValidation()
    {
        $service = new AdmissionService();

        // Intentionally missing 'email' and 'dob' which are strictly required
        $postData = [
            'first_name' => 'Alice',
            'last_name'  => 'Wonderland',
            'phone'      => '1231231234',
            'course'     => 'Nursing'
        ];

        $result = $service->processNewAdmission($postData);

        // It should flag success as false and return the validation errors
        $this->assertFalse($result['success']);
        $this->assertArrayHasKey('email', $result['errors']);
        $this->assertArrayHasKey('dob', $result['errors']);
    }
}
