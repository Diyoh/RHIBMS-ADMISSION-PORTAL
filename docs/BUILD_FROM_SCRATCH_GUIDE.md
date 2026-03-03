# How to Build the RHIMBS Admission System from Scratch

**A Step-by-Step Guide for Students**

Welcome to Week 5! If you are looking at the finished RHIMBS Admission System and wondering, _"How do I actually build this myself?"_ — this is the document for you.

Follow these exact steps in order, and you will recreate the entire Advanced Backend Architecture from scratch!

---

## Step 1: Install CodeIgniter 4 and Configure the Environment

Before we write any code, we need the framework and a secure environment.

1. **Install the Framework:** Open your terminal and run the Composer command to download the CodeIgniter 4 App Starter:
   ```bash
   composer create-project codeigniter4/appstarter admission_system
   ```
2. **Setup the Environment File:**
   - Navigate into `admission_system/`.
   - Rename the `env` file to `.env`.
   - Open `.env` and configure three critical things:
     - Uncomment and set: `CI_ENVIRONMENT = development` (This shows us error messages).
     - Uncomment and set: `app.baseURL = 'http://localhost:8080/'`.
     - Uncomment the database section and set your MySQL credentials (e.g., `database.default.database = admission_system`, `username = root`, password empty if using XAMPP).
3. **Create the Database:** Open phpMyAdmin or your MySQL CLI and create an empty database named `admission_system`.

_(Read `01_production_readiness.md` for a deeper explanation of the `.env` file!)_

---

## Step 2: Build the Database Structure (Migrations)

Instead of manually creating tables in phpMyAdmin, we use code. This makes our database "Production Ready."

1. **Generate the Migration File:**
   ```bash
   php spark make:migration CreateAdmissionsTable
   ```
2. **Define the Columns:**
   - Open the newly created file in `app/Database/Migrations/`.
   - Inside the `up()` method, use `$this->forge->addField([...])` to define your columns (`id`, `first_name`, `last_name`, `email`, `course`, `status`, etc.).
   - Set the primary key: `$this->forge->addKey('id', true);`
   - Build the table: `$this->forge->createTable('admissions');`
   - Inside the `down()` method, drop the table: `$this->forge->dropTable('admissions');`
3. **Run the Migration:**
   ```bash
   php spark migrate
   ```
   Check your database; the `admissions` table will magically appear!

---

## Step 3: Secure the Data Gateway (The Model)

We need a secure way to talk to our new database table.

1. **Create the Model:** Create a file `app/Models/AdmissionModel.php`.
2. **Configure Security:**
   - Set `protected $table = 'admissions';`
   - Set `protected $allowedFields = ['first_name', 'last_name', ...];` to prevent hackers from submitting fake fields (Mass Assignment).
   - Define `$validationRules` to ensure nobody can submit an empty name or invalid email.
   - Add a `$beforeInsert = ['sanitizeInput'];` callback. Write a `sanitizeInput()` method that uses CodeIgniter's `esc()` function to strip out dangerous JavaScript to prevent XSS attacks.

_(Read `02_models_and_repositories.md` for a deeper dive into Fat Models!)_

---

## Step 4: Add Global Security & Middleware (Filters)

Let's lock the system down against Cross-Site Request Forgery (CSRF) and unauthorized users.

1. **Enable CSRF globally:** Open `app/Config/Filters.php` and uncomment `'csrf'` inside the `public array $globals = ['before' => ['csrf']];` array. Every form now requires a secret token!
2. **Create Role-Based Access Control (RBAC):**
   - Run `php spark make:filter AuthFilter`.
   - Open `app/Filters/AuthFilter.php`. Inside the `before()` method, check if `$session->get('isLoggedIn')` is true. If not, return a 403 Forbidden response.
   - Register your new filter in `app/Config/Filters.php` by adding `'auth' => \App\Filters\AuthFilter::class,` to the `$aliases` array.

_(Read `03_security_and_middleware.md` to understand how CSRF works!)_

---

## Step 5: Extract Logic to a Service Layer

We don't want "Fat Controllers." We want a dedicated "Chef" to handle our complex business logic.

1. **Create the Service:** Make a new folder `app/Services/` and create `AdmissionService.php`.
2. **Write the Logic:**
   - Create a `processNewAdmission($data)` method.
   - Inside, automatically generate a unique `admission_number` (e.g., ADM-2026-X8P4Q).
   - Instantiate the `AdmissionModel` and call `$this->admissionModel->save($data)`.
   - If it succeeds, return `['success' => true]`. If it fails, return `['success' => false, 'errors' => $model->errors()]`.

_(Read `04_architecture_and_services.md` to understand why we separate concerns!)_

---

## Step 6: Build the Views (UI & UX)

Now we construct the HTML pages the user will actually see, using Tailwind CSS and View Inheritance.

1. **The Master Layout:** Create `app/Views/layouts/main.php`. Put your `<html>` tags, Tailwind CDN link, and header/footer here. Use `<?= $this->renderSection('content') ?>` in the middle.
2. **The Admission Form:** Create `app/Views/admission/form.php`.
   - Start with `<?= $this->extend('layouts/main') ?>`.
   - Build the HTML `<form action="/admission/submit" method="post">`.
   - **CRITICAL:** Add `<?= csrf_field() ?>` inside the form to pass the security filter!
   - Add input fields and use `<?= set_value('first_name') ?>` to remember typed data if an error occurs.
3. **The Admin Dashboard:** Create `app/Views/admin/dashboard.php` to display a table of students.

_(Read `05_web_controllers_and_ui.md` to see how View Layouts keep your code DRY!)_

---

## Step 7: Route the Traffic (Controllers & Routes)

Finally, we connect the browser URLs to our Views using a Web Controller.

1. **The Controller:** Create `app/Controllers/Web/AdmissionController.php`.
   - In the constructor, instantiate the `AdmissionService`.
   - Create an `index()` method that returns `view('admission/form')`.
   - Create a `submit()` method that grabs `$this->request->getPost()`, hands it to the Service Layer, and redirects the user with success/error flashdata.
2. **The Routes:** Open `app/Config/Routes.php`.
   - Add `$routes->get('admission', '\App\Controllers\Web\AdmissionController::index');`
   - Add `$routes->post('admission/submit', '\App\Controllers\Web\AdmissionController::submit');`
   - Add the secure dashboard route:
     `$routes->get('admin/dashboard', function(){ return view('admin/dashboard'); }, ['filter' => 'auth:admin,staff']);`

---

## Step 8: Look to the Future (REST APIs)

If your frontend team decides to build a Next.js App instead of standard HTML pages, they will need JSON data, not Views.

1. **The API Controller:** Create `app/Controllers/Api/V1/AdmissionController.php` extending `ResourceController`.
2. It will grab data via `$this->request->getJSON(true)` and pass it to the **exact same** `AdmissionService`.
3. Instead of returning `redirect()`, it returns `$this->response->setJSON([...])`.
4. Group those routes in `Routes.php` under `$routes->group('api/v1', ...)`.

_(Read `06_rest_apis.md` to understand Versioning and JSON structures!)_

---

## You're Done!

Open your terminal, ensure you are in the project folder, and run:

```bash
php spark serve
```

Visit `http://localhost:8080/admission` and marvel at the enterprise-grade system you just built from scratch!
