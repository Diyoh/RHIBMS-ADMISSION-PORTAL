# Module 5: The View Layer (UI/UX) & Web Routing

A backend engineer's job isn't _only_ about databases and APIs. Sometimes, you need to render actual web pages. In this module, we built the UI for our Admission System using CodeIgniter's powerful View inheritance system.

---

## 1. Web Routes (The URL Map)

To connect a URL like `http://localhost:8080/admission` to our beautifully clean `AdmissionController`, we modified `app/Config/Routes.php`.

```php
// 1. Show the form
$routes->get('admission', '\App\Controllers\Web\AdmissionController::index');

// 2. Submit the form
$routes->post('admission/submit', '\App\Controllers\Web\AdmissionController::submit');
```

- **GET vs POST:** We explicitly state that you can only _GET_ the form page, and you can only _POST_ data to the submit endpoint. This is a basic form of API security.

### Protecting Routes with Middleware Filters

```php
$routes->get('admin/dashboard', function() {
    return view('admin/dashboard');
}, ['filter' => 'auth:admin,staff']);
```

- **The Power of Filters:** In Module 3, we built an `AuthFilter`. Here in the Routes file, we tell CodeIgniter: _"Do not let anyone load this dashboard unless they successfully pass the 'auth' filter with an 'admin' or 'staff' role."_

---

## 2. CI4 View Inheritance (Layouts)

In the old days of PHP, developers would `include('header.php')` at the top of every file and `include('footer.php')` at the bottom. This was tedious and error-prone.

CodeIgniter 4 uses **View Layouts**.

1.  **The Master Layout (`app/Views/layouts/main.php`):**
    We created one file that contains the `<html>`, `<head>`, the TailwindCSS CDN link, the navigation bar, and the footer.
    Inside the `<main>` tag, we placed a placeholder:

    ```php
    <?= $this->renderSection('content') ?>
    ```

2.  **The Child View (`app/Views/admission/form.php`):**
    The actual form doesn't need to rewrite the HTML head or footer. It simply says:

    ```php
    <?= $this->extend('layouts/main') ?>

    <?= $this->section('content') ?>
        <!-- Form HTML Goes Here -->
    <?= $this->endSection() ?>
    ```

    This approach keeps our frontend code extremely DRY (Don't Repeat Yourself) and makes redesigning the website a breeze because we only have to change the master layout once!

---

## 3. Premium UI/UX & Security

We utilized **Tailwind CSS** to build a modern "Glassmorphism" design. As software engineers, building interfaces that "WOW" the user is critical. A secure application that looks terrible will not be trusted by users.

But looks aren't everything. We baked in security:

### The CSRF Token

If you look inside `app/Views/admission/form.php`, right below the `<form>` tag is this snippet:

```php
<?= csrf_field() ?>
```

This single line tells CodeIgniter to generate the secret hidden input that satisfies the Global CSRF Filter we enabled in Module 3. Without this line, the form will literally never submit successfully.

### Error Repopulation

When a user forgets to type their email and hits submit, our Model validation fails. Our Controller redirects them back.
But how do we keep the name they _already_ typed so they don't have to retype it?

```php
<input name="first_name" value="<?= set_value('first_name') ?>">
```

The `set_value()` function grabs old flash data from the previous failed submission and puts it right back in the box. Excellent UX!

---

### What's Next?

We have successfully built a full Web MVC Application! But what if the Frontend Team wants to build a Mobile App using React Native? They can't read our HTML!

In **Module 6**, we will build a **REST API** using the exact same Service Layer!
