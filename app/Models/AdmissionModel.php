<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * The AdmissionModel handles all interactions with the 'admissions' database table.
 */
class AdmissionModel extends Model
{
    // The exact name of the table in the MySQL database
    protected $table = 'admissions';
    
    // The primary key used to identify unique rows
    protected $primaryKey = 'id';
    
    // The format in which database results are returned to us
    protected $returnType = 'array';
    
    /*
     * THE ALLOWED FIELDS ARRAY (CRITICAL SECURITY FEATURE)
     *-------------------------------------------------------------------------
     * This defines exactly WHICH columns are allowed to be saved to the database.
     * This prevents Mass Assignment Vulnerabilities.
     * Imagine a hacker inspects our HTML form and adds an input field: 
     * <input name="role" value="admin">
     * If 'role' is not in the array below, CodeIgniter completely ignores it!
     */
    protected $allowedFields = [
        'admission_number',
        'first_name',
        'last_name',
        'email',
        'phone',
        'course',
        'dob',
        'status',
    ];

    // Automatically fill the 'created_at' and 'updated_at' columns whenever we save or update a record
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /*
     * DATA VALIDATION
     *-------------------------------------------------------------------------
     * Putting validation rules inside the Model ensures that no matter where 
     * we try to save data from (an API, a Web Form, or a CLI script), the data 
     * MUST pass these strict rules before it hits the database.
     */
    protected $validationRules = [
        // Name must be provided, contain only letters/spaces, and be between 2 and 100 characters.
        'first_name' => 'required|alpha_space|min_length[2]|max_length[100]',
        'last_name'  => 'required|alpha_space|min_length[2]|max_length[100]',
        
        // Email is required, must look like an email, and must not already exist in the 'admissions' table.
        'email'      => 'required|valid_email|is_unique[admissions.email]',
        
        'phone'      => 'required|min_length[9]|max_length[20]',
        'course'     => 'required|max_length[100]',
        'dob'        => 'required|valid_date',
    ];

    // Custom Error Messages for specific rules
    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Sorry, that email address has already been registered in our admission system.'
        ]
    ];
    
    // Never skip validation
    protected $skipValidation = false;
    
    /*
     * EVENT CALLBACKS (HOOKS)
     *-------------------------------------------------------------------------
     * These functions run automatically when a specific event happens.
     * We want to 'sanitizeInput' right BEFORE we insert or update any data.
     */
    protected $beforeInsert = ['sanitizeInput'];
    protected $beforeUpdate = ['sanitizeInput'];

    /**
     * Sanitizes string data before it is saved to the database.
     * This strongly protects against Cross-Site Scripting (XSS) attacks.
     */
    protected function sanitizeInput(array $data)
    {
        if (isset($data['data'])) {
            foreach ($data['data'] as $field => $value) {
                if (is_string($value)) {
                    // esc() safely converts HTML tags like <script> into harmless text &lt;script&gt;
                    $data['data'][$field] = esc($value);
                }
            }
        }
        return $data; // Return the cleaned data package
    }
}
