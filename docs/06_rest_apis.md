# Module 6: REST API Design (Versioned APIs)

In modern web development, the Backend Team rarely builds the HTML Views. Instead, the Backend builds an API (Application Programming Interface), and the **Frontend-Heavy Team** uses a framework like React, Vue, or Next.js to build the visual interface.

In this module, we built a **REST API** endpoint for the Admissions System.

---

## 1. What is an API?

If our Web Controller is a Waiter delivering a plated meal (HTML View) directly to the customer (Web Browser)...
Then an API is a drive-thru window. The customer (React Native App, Next.js Website) drives up, asks for raw ingredients, and the API hands them securely packaged boxes of data.

It is up to the React application to open those boxes and arrange the data on the screen.

The universal language of these "boxes" is **JSON (JavaScript Object Notation)**.

### Look at our API Controller

Open `app/Controllers/Api/V1/AdmissionController.php`.

```php
public function create()
{
    // 1. Grab raw JSON data from React instead of an HTML form post
    $requestData = $this->request->getJSON(true);

    // 2. Hand data to the EXACT SAME Chef (Service Layer) we used for the Web Controller!
    $result = $this->admissionService->processNewAdmission($requestData);

    // 3. Return JSON instead of redirecting or loading a view
    if ($result['success']) {
        return $this->response->setJSON([
            'status'  => 201, // HTTP Status 201: Created
            'message' => $result['message']
        ]);
    } else {
        return $this->response->setJSON([
            'status'  => 400, // HTTP Status 400: Bad Request
            'message' => 'Validation failed',
            'errors'  => $result['errors']
        ]);
    }
}
```

Because we built the `AdmissionService` in Module 4, creating this entire API took less than 20 lines of code! We didn't have to rewrite validation rules, we didn't have to rewrite the tracking number generator. This is **Software Architecture Mastery**.

---

## 2. API Versioning (`/v1/`)

We grouped our API endpoints in `app/Config/Routes.php` under the URL prefix `/api/v1/`.

Why?

Imagine thousands of students have downloaded the RHIMBS Mobile App to their iPhones. That app currently expects the API to be at `https://rhimbs.com/api/admissions`.

Next year, you decide to change the database. Instead of a `name` field, you split it into `first_name` and `last_name`. If you update the API, suddenly every student who hasn't updated their iPhone app will get a massive crash error, because their old app is sending data in the wrong format!

**The Versioning Solution:**
When we change the database next year, we leave `/api/v1/admissions` exactly as it is (perhaps using the Service Layer to silently combine the old data structure before saving). We then create a brand new route `/api/v2/admissions` for the new app update.

This ensures backward compatibility—an essential requirement for production systems.

---

## 3. The `ResourceController`

Notice that our API Controller extends `ResourceController` instead of `BaseController`.
The ResourceController provides helpful shortcut methods like `$this->respond()` and `$this->failValidationError()` specifically generated for working with REST APIs.

Coupled with `$routes->resource('admissions')` in our Routing file, CodeIgniter automatically maps HTTP requests like this:

- **POST** `/api/v1/admissions` -> `create()` -> Adds a new student
- **GET** `/api/v1/admissions` -> `index()` -> Lists all students
- **DELETE** `/api/v1/admissions/5` -> `delete(5)` -> Deletes student ID 5

This strict, predictable naming convention is what makes an API truly **RESTful**.

---

### What's Next?

Our system is fundamentally complete! The last step in Week 5 is **Module 7: Deployment Strategy**, where we will discuss how to safely push this application to a live production server.
