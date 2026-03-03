# Module 2: The Model Layer & The Repository Pattern

As Backend Engineers, our job is not just to "make it work." We have to make applications that are **Secure**, **Organized**, and **Scalable**.

In this module, we built the `AdmissionModel`. This isn't just a place to store database functions; it is the absolute gateway to our data.

---

## 1. Why build "Fat" Models?

Historically, beginner PHP developers write massive chunks of code in their Controllers to extract form data, check if it's valid, format it, and then write raw SQL to insert it into the database. This leads to "Fat Controllers" – a terrible architecture practice because Controllers should only be traffic cops routing requests to different systems.

By putting functionality inside the Model, we practice **Fat Models, Skinny Controllers**.

### What our Model accomplishes automatically:

If you look at `app/Models/AdmissionModel.php`, you will see we wrote almost no actual functions, just arrays of rules. That is the power of CodeIgniter 4!

1.  **Mass Assignment Protection (`$allowedFields`):**
    A common vulnerability is "Mass Assignment." Imagine a hacker injects an `<input type="hidden" name="status" value="approved">` into our web form. If we just bulk-save the form data, the hacker just approved their own admission!
    _Fix:_ By defining `$allowedFields = ['first_name', 'last_name', ...]`, CodeIgniter acts as a bouncer. Even if a hacker submits the "status" field, the Model simply throws it away because it's not on the VIP guest list!

2.  **Centralized Validation (`$validationRules`):**
    We put our validation (`required|valid_email|is_unique`) in the Model. Why? Because later in this project, we might create an Android App that submits admissions through our API endpoint. By keeping the rules in the Model, both the Web HTML Form _and_ the Mobile App API use the exact same strict security checks.

3.  **Cross-Site Scripting (XSS) Prevention (`$beforeInsert`):**
    XSS is when a terrible user types JavaScript into their First Name field (`<script>alert('hacked')</script>`). If we save that text and print it back on our Admin dashboard, it executes in the Admin's browser and steals their session!
    _Fix:_ We used **Callbacks**. Right before data is inserted, our Model automatically runs `sanitizeInput()`, calling CodeIgniter's `esc()` function. This safely neutralizes all HTML tags.

---

## 2. Conceptualizing The Repository Pattern

### What is a Repository?

Right now, our Controller will talk directly to the `AdmissionModel`. This is the standard MVC pattern and perfectly fine for small-to-medium apps.

However, in Enterprise applications, you might implement the **Repository Pattern**.
A Repository is an extra layer _between_ the Model and the specialized Business Logic.

- **The Problem MVC creates:** Imagine you change your database from MySQL to a NoSQL database like MongoDB. You'd have to rewrite all your CodeIgniter Models and find every place in your Controllers/Services where you called those Models.
- **The Repository Solution:** A Repository provides an "Interface" (a contract). Your Controller asks the `AdmissionRepository` for `getAllAdmissions()`. The Repository then figures out whether to grab it from a MySQL Model, a MongoDB Model, or even an external API! The Controller never knows nor cares where the data comes from.

We won't build a full Repository interface today because it's overkill for an Admission form, but professional software engineers must understand _why_ Repositories exist to hide direct database dependence from the main application logic!

---

### What's Next?

Next, we will look at **Security Hardening and Middleware (Filters)**. We need to make sure hackers can't forge requests from other websites, and we need a way to lock certain pages down to Administrators only!
