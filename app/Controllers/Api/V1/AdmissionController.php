<?php

namespace App\Controllers\Api\V1;

use CodeIgniter\RESTful\ResourceController;
use App\Services\AdmissionService;

/**
 * The API Admission Controller handles requests from Frontend teams 
 * (like React/Next.js) or Mobile Apps. 
 *
 * It NEVER returns HTML. It ALWAYS returns JSON.
 */
class AdmissionController extends ResourceController
{
    // A built-in CodeIgniter feature to quickly set the response type
    protected $format = 'json';
    
    protected $admissionService;

    public function __construct()
    {
        // Notice we are using the EXACT SAME Service Layer as our Web Controller!
        // This is DRY (Don't Repeat Yourself) architecture in action.
        $this->admissionService = new AdmissionService();
    }

    /**
     * POST /api/v1/admissions
     * Handles creating a new admission record via API
     */
    public function create()
    {
        // 1. Grab the JSON payload sent by the React/Next.js frontend
        $requestData = $this->request->getJSON(true); // true = return as an associative array

        if (!$requestData) {
            return $this->failValidationError('No data was sent in the request body.');
        }

        // 2. Hand the data to the Chef (Service Layer)!
        $result = $this->admissionService->processNewAdmission($requestData);

        // 3. Return structured JSON responses
        if ($result['success']) {
            
            // HTTP 201 Created
            return $this->response->setJSON([
                'status'  => 201,
                'message' => $result['message']
            ])->setStatusCode(201);
            
        } else {
            
            // HTTP 400 Bad Request
            return $this->response->setJSON([
                'status'  => 400,
                'message' => 'Validation failed.',
                'errors'  => $result['errors']
            ])->setStatusCode(400);
            
        }
    }

    /**
     * GET /api/v1/admissions
     * (Requires Admin API Token in a real system)
     */
    public function index()
    {
        // Grab the data using the Service Layer
        $admissions = $this->admissionService->getAllAdmissions();
        
        // Return 200 OK with the array of records
        return $this->respond([
            'status' => 200,
            'data'   => $admissions
        ]);
    }
}
