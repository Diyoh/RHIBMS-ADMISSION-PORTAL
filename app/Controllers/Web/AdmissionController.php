<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Services\AdmissionService;

/**
 * The Web Admission Controller handles requests from the browser
 * and returns HTML Views to the user.
 */
class AdmissionController extends BaseController
{
    protected $admissionService;

    public function __construct()
    {
        // Instantiate the Service Layer
        $this->admissionService = new AdmissionService();
    }

    /**
     * GET /admission
     * Displays the admission application form.
     */
    public function index()
    {
        // We load helpers we might need in the view, like form_helper
        helper(['form']);
        
        // Return the HTML view containing the form
        return view('admission/form');
    }

    /**
     * POST /admission/submit
     * Handles the form submission using the Service Layer.
     */
    public function submit()
    {
        // 1. Grab all the POST data submitted through the HTML form
        $requestData = $this->request->getPost();

        // 2. Pass the data to the Service Layer!
        // Notice how clean this Controller is? No messy database queries or random ID generation strings!
        // This is the power of "Skinny Controllers, Fat Models/Services"
        $result = $this->admissionService->processNewAdmission($requestData);

        if ($result['success']) {
            // Flashdata stores a message in the session for exactly ONE page redirect.
            // Perfect for "Success!" messages.
            session()->setFlashdata('success_message', $result['message']);
            
            // Redirect the user back to the form so they see the success message
            // In a real app, we might redirect to a 'success' dashboard instead.
            return redirect()->to('/admission');
            
        } else {
            // The validation failed! We send the errors back to the form so the 
            // user can fix their mistakes.
            return redirect()->back()->withInput()->with('errors', $result['errors']);
        }
    }
}
