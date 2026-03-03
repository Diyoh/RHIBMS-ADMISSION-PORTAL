<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // ---------------------------------------------------------------------
        // ROLE-BASED ACCESS CONTROL (RBAC) MIDDLEWARE
        // ---------------------------------------------------------------------
        // This is where we protect our /admin routes.
        // Before the Controller is even loaded, this code runs.
        
        $session = session();
        
        // 1. Is the user logged in at all?
        if (!$session->get('isLoggedIn')) {
            // Not logged in? Redirect them to a local login page (or throw 403)
            // For now, let's just throw a 403 Forbidden since we are building the backend API structure.
            return service('response')
                ->setStatusCode(403)
                ->setBody('403 Forbidden: You must be logged in to view this page.');
        }

        // 2. Are they an Admin? 
        // We can pass arguments to filters in Routes.php like: 'filter' => 'auth:admin,staff'
        if ($arguments && !in_array($session->get('role'), $arguments)) {
            // Logged in, but they don't have the required role (e.g., a 'student' trying to access 'admin' panel)
            return service('response')
                ->setStatusCode(401)
                ->setBody('401 Unauthorized: You do not have the required role to access this system.');
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
