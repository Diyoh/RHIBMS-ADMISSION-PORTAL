<?php

namespace App\Services;

use App\Models\AdmissionModel;

/**
 * The AdmissionService layer handles complex business logic.
 * It sits between the Controller and the Model.
 * 
 * WHY A SERVICE LAYER?
 * Controllers should only: receive an HTTP request and send an HTTP response (or load a View).
 * Models should only: interact with the database.
 * The Service does everything else: generating IDs, formatting dates, sending emails, etc.
 */
class AdmissionService
{
    protected $admissionModel;

    public function __construct()
    {
        // We load the Model here so the Service can talk to the database
        $this->admissionModel = new AdmissionModel();
    }

    /**
     * Processes a new admission application.
     * 
     * @param array $data The raw POST data from the form
     * @return array Returns an array with 'success', 'errors', and any success messages.
     */
    public function processNewAdmission(array $data): array
    {
        // 1. Generate a unique Admission Number
        $data['admission_number'] = $this->generateAdmissionNumber();
        
        // 2. We explicitly set status to pending to override anything a hacker might try to send
        $data['status'] = 'pending';

        // 3. Attempt to save the data securely via the Model
        // The Model will automatically run its $validationRules before saving!
        if ($this->admissionModel->save($data)) {
            
            // Logically, this is where we would also send a "Welcome Email" using an Email library.
            // Example: email_service->sendWelcome($data['email']);
            
            return [
                'success' => true,
                'message' => 'Application submitted successfully! Your tracking number is: ' . $data['admission_number']
            ];
            
        } else {
            // Because the Model failed validation, we can grab those exact error messages
            return [
                'success' => false,
                'errors'  => $this->admissionModel->errors(),
            ];
        }
    }

    /**
     * Internal method to generate a unique, professional admission number
     */
    private function generateAdmissionNumber(): string
    {
        $year = date('Y');
        // Let's generate a random string, e.g., ADM-2026-X8P4Q
        $randomChars = strtoupper(substr(md5(uniqid('', true)), 0, 5));
        
        return "ADM-{$year}-{$randomChars}";
    }

    /**
     * Retrieves all admissions for the Admin Dashboard
     */
    public function getAllAdmissions()
    {
        // This is a simple pass-through to the Model, but if we needed to sort or filter data
        // before giving it to the Admin Controller, we would do it here.
        return $this->admissionModel->orderBy('created_at', 'DESC')->findAll();
    }
}
