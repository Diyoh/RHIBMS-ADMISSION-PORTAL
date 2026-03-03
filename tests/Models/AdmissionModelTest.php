<?php

namespace Tests\Models;

use App\Models\AdmissionModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

class AdmissionModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate     = true;
    protected $migrateOnce = false;
    protected $refresh     = true;
    protected $namespace   = 'App';

    public function testSanitizeInputRemovesHtmlTags()
    {
        $model = new AdmissionModel();

        // Simulate a form submission with malicious HTML/Script
        $maliciousData = [
            'first_name' => '<script>alert("hacked")</script>John',
            'last_name'  => 'Doe'
        ];

        // Access the protected sanitizeInput method directly via reflection for unit testing
        $method = new \ReflectionMethod(AdmissionModel::class, 'sanitizeInput');
        $method->setAccessible(true);
        
        $cleanedData = $method->invoke($model, ['data' => $maliciousData]);

        // Assert the returned data is sanitized (esc() changes < and > to HTML entities)
        $this->assertStringContainsString('&lt;script&gt;', $cleanedData['data']['first_name']);
        $this->assertStringNotContainsString('<script>', $cleanedData['data']['first_name']);
    }

    public function testInsertValidRegistration()
    {
        $model = new AdmissionModel();
        
        $data = [
            'admission_number' => 'ADM-2026-TEST1',
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'email'      => 'john.doe.tester@example.com',
            'phone'      => '1234567890',
            'course'     => 'Computer Science',
            'dob'        => '2000-01-01',
            'status'     => 'pending'
        ];

        $result = $model->insert($data);

        // CodeIgniter 4 Model inserts return the ID of the new row on success
        $this->assertIsInt($result);
        
        // DatabaseTestTrait allows us to inspect the DB directly
        $this->seeInDatabase('admissions', ['email' => 'john.doe.tester@example.com']);
    }

    public function testFailsOnDuplicateEmail()
    {
        $model = new AdmissionModel();
        
        // 1. Insert first valid record
        $model->insert([
            'admission_number' => 'ADM-2026-TEST1',
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'email'      => 'duplicate@example.com',
            'phone'      => '1234567890',
            'course'     => 'Computer Science',
            'dob'        => '2000-01-01',
            'status'     => 'pending'
        ]);

        // 2. Attempt second insert with the EXACT SAME email
        $result = $model->insert([
            'admission_number' => 'ADM-2026-TEST2',
            'first_name' => 'Jane',
            'last_name'  => 'Smith',
            'email'      => 'duplicate@example.com', // Duplicate
            'phone'      => '0987654321',
            'course'     => 'Business',
            'dob'        => '2001-01-01',
            'status'     => 'pending'
        ]);

        // It should reject the insert and return false
        $this->assertFalse($result);
        
        // Verify the custom error message we set in AdmissionModel is triggered
        $errors = $model->errors();
        $this->assertArrayHasKey('email', $errors);
        $this->assertEquals('Sorry, that email address has already been registered in our admission system.', $errors['email']);
    }
}
