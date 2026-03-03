# Module 1: Production Readiness (Environment & Database)

Welcome to Week 5! In this module, we transition from writing basic PHP scripts to setting up a **Production-Ready** backend using CodeIgniter 4.

Two critical concepts for production readiness are **Environment Configuration** and **Database Migrations**. Let's break down what we just did and why it matters.

---

## 1. Environment Configuration (`.env`)

When you build an application, you usually run it on your local computer (the "development" environment) before uploading it to a live server (the "production" environment).

These environments have different settings. For example, your local database password might be empty, but your live server database will have a strong password. You also want to see all errors locally to debug them, but you _never_ want to show errors to users on a live site, as hackers could use that information against you.

To handle this, CodeIgniter uses an **Environment File** named `.env` situated in the root (`Admission_systerm/`) folder.

### What we changed in `.env`:

```ini
CI_ENVIRONMENT = development
```

- **What this does:** Tells CodeIgniter we are developing locally.
- **Why it's important:** It forces CodeIgniter to display detailed error messages on the screen if our code breaks. On a live server, this must be changed to `production` so errors are hidden and only safely logged to a file.

```ini
app.baseURL = 'http://localhost:8080/'
```

- **What this does:** Sets the base URL for our application.
- **Why it's important:** CodeIgniter uses this to build absolute links for images, CSS files, and page routing.

```ini
database.default.hostname = localhost
database.default.database = admission_system
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
```

- **What this does:** Connects our application to the MySQL database named `admission_system`.
- **Why it's important:** Hardcoding database credentials inside `Config/Database.php` is a massive security risk, especially if you push your code to GitHub. By keeping the credentials in `.env`, we can ignore the `.env` file in `.gitignore` so our passwords remain secret.

---

## 2. Database Migrations

In the past, you might have opened phpMyAdmin, clicked "New Table," and manually added columns.

**Wait! What if you need to deploy your project to a server?** Or what if another student joins your team? They would have to manually recreate every table. This is slow, error-prone, and not "Production Ready."

CodeIgniter solves this using **Database Migrations**. Migrations are like "version control" (Git) for your database structure. You write PHP code to define your tables, and CodeIgniter creates them for you!

### Understanding our Migration Code

We created a migration file inside `app/Database/Migrations/` named `[Date]_CreateAdmissionsTable.php`.

Take a look at the key parts of the code:

```php
public function up()
{
    // $this->forge is CodeIgniter's tool for building tables.
    $this->forge->addField([
        'id' => [
            'type'           => 'INT',
            'constraint'     => 11,
            'unsigned'       => true,
            'auto_increment' => true,
        ],
        'admission_number' => [
            'type'       => 'VARCHAR',
            'constraint' => '50',
            'unique'     => true, // No two students can have the same number
        ],
        // ... First Name, Last Name, Email, Phone, Course, DOB ...
        'status' => [
            'type'       => 'ENUM',
            'constraint' => ['pending', 'approved', 'rejected'],
            'default'    => 'pending', // By default, everyone is 'pending'
        ],
    ]);

    // We set 'id' as the Primary Key
    $this->forge->addKey('id', true);

    // Create the physical table in MySQL
    $this->forge->createTable('admissions');
}
```

- **`up()` function:** This code runs when we apply the migration. It tells the `$forge` tool (CodeIgniter's database builder) to create the `admissions` table with the exact columns and data types we specified.
- **`ENUM` data type:** For `status`, we used `ENUM`. This strictly limits the values in that column to _only_ 'pending', 'approved', or 'rejected'. This is a great way to ensure data integrity at the database level!

```php
public function down()
{
    $this->forge->dropTable('admissions');
}
```

- **`down()` function:** This code runs if we need to "rollback" or undo the migration. It safely drops (deletes) the table.

### Running the Migration

To execute this code and actually build the table in MySQL, we ran a simple terminal command:

```bash
php spark migrate
```

This ensures that no matter who works on the project, or what server it's deployed to, the database structure is built exactly the same way, perfectly reliably.

---

### What's Next?

Now that our environment is secure and our database table is structured, we are going to build the **Model and Service Layer** to start safely interacting with this data!
