# Module 3: Security Hardening & Middleware (Filters)

Security is not an afterthought; it must be built into the foundation of a Production-Ready application.

In this module, we applied two critical security principles: **Global CSRF Protection** and **Role-Based Access Control (RBAC) via Middleware**.

---

## 1. Global CSRF Protection

### What is CSRF?

CSRF stands for **Cross-Site Request Forgery**.

Imagine you are logged into the RHIMBS Admission System as an Administrator. In another tab, you visit a malicious website `www.free-movies.com`. That bad website might have a hidden HTML form that automatically submits a POST request to `http://localhost:8080/admission/delete/all`.

Because you are already logged into RHIMBS, your browser automatically sends your session cookies along with that malicious request. The server thinks _you_ actively clicked the "delete all" button!

### How we solved it:

In `app/Config/Filters.php`, we uncommented `'csrf'` in the `$globals['before']` array.

```php
public array $globals = [
    'before' => [
        'csrf', // Enabled globally!
    ],
...
```

**How it works:**

1. CodeIgniter now requires every single POST, PUT, and DELETE request to include a unique, secret "Token" that it generates.
2. When we build our HTML Views later, we will use the `csrf_field()` function which outputs a hidden input like: `<input type="hidden" name="csrf_test_name" value="a1b2c3d4...">`.
3. The malicious website `free-movies.com` does NOT know this secret token! When it tries to forge a request to our server, CodeIgniter's CSRF Filter steps in, notices the token is missing, and immediately blocks the request with a **403 Forbidden** error.

---

## 2. Role-Based Access Control (RBAC) Middleware

As Backend Engineers, we often have different types of users: Students, Staff, and Administrators. We need an elegant way to block Students from accessing Admin pages.

Beginners might put an `if` statement at the top of every single Controller method:

```php
if (session()->get('role') != 'admin') { return redirect(); } // Bad Practice!
```

This is repetitive and easy to forget.

### The CodeIgniter Solution: Filters (Middleware)

We generated a custom filter named `AuthFilter` (`app/Filters/AuthFilter.php`). A filter allows us to run code **before** the Controller even gets touched.

Look at our custom logic:

```php
public function before(RequestInterface $request, $arguments = null)
{
    $session = session();

    // 1. Is the user logged in?
    if (!$session->get('isLoggedIn')) {
        return service('response')->setStatusCode(403)->setBody('403 Forbidden: You must be logged in.');
    }

    // 2. Do they have the required role?
    // We can pass allowed roles from our routing file via the $arguments array.
    if ($arguments && !in_array($session->get('role'), $arguments)) {
        return service('response')->setStatusCode(401)->setBody('401 Unauthorized.');
    }
}
```

### Registering the Middleware

We then opened `app/Config/Filters.php` and added our new filter to the aliases:

```php
public array $aliases = [
    // ...
    'auth' => \App\Filters\AuthFilter::class,
];
```

Now, when we set up our Routes in the next modules, we can simply tell CodeIgniter:
_"Only let people use the Admin dashboard if they pass the 'auth:admin' filter!"_

The Controller remains perfectly clean (Skinny Controllers), and the security logic is centralized.

---

### What's Next?

We are going to move into **Architecture Principles: The Service Layer**, where we will extract complex business logic out of our Controllers to make our code truly Enterprise-grade!
