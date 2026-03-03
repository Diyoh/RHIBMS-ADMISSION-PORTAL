# Module 7: Production Readiness & Deployment Strategy

Congratulations! You have built a secure, MVC-architectured, API-ready Backend System.
But an application isn't finished until it is securely running on a live server (like AWS, DigitalOcean, or cPanel) for the world to see.

This module covers the mindset of deploying a live system safely without breaking anything.

---

## 1. Environment Configurations

Remember your `.env` file from Module 1?
When you copy your code to the live server, you must **NEVER** copy the `.env` file that has your local "root" database password.

On your live server, you will create a _brand new_ `.env` file with these critical changes:

```ini
CI_ENVIRONMENT = production
```

Changing this single word from `development` to `production` tells CodeIgniter to completely hide all PHP errors from the screen. If something breaks, users will see a generic "Whoops, something went wrong" page instead of a screen full of sensitive stack traces pointing to your database.

```ini
logger.threshold = 4
```

Because errors are hidden from the screen, you must ensure your logger is working. CodeIgniter will write the errors securely into the `writable/logs/` folder. This is where you look when a user complains the site is broken!

---

## 2. The Version Control Workflow (Git)

You should never use FTP (FileZilla) to drag-and-drop code changes onto a live server. If you drag the wrong folder, the site instantly breaks.

Instead, we use **Git** (Version Control).

**The Professional Workflow:**

1.  **Local Dev:** You build the feature on your laptop.
2.  **Commit & Push:** You `git commit` your code and push it to GitHub/GitLab.
3.  **Pull:** You SSH into your live server (or use an automated CI/CD pipeline) and run `git pull`. The server securely downloads only the exact lines of code that changed.

---

## 3. Safe Database Updates

Imagine your live Admission System has been running for 6 months. It has 5,000 real students inside the `admissions` table.

Suddenly, the University decides they need to track a student's `gender`.

**The WRONG Way (Amateur):**
Log into the live server's phpMyAdmin, click the `admissions` table, and manually add a `gender` column.
_Why is this bad?_ Because if your new code crashes, you might corrupt the table, or your local laptop database now doesn't match the live server database!

**The RIGHT Way (Backend Engineer):**

1.  **Backup First:** Run a MySQL dump just in case. `mysqldump -u root -p admission_system > backup_feb2026.sql`
2.  **Write a Migration:** On your laptop, you run `php spark make:migration AddGenderToAdmissions`.
3.  **Code the Change:** In the migration file, you write:
    ```php
    $fields = ['gender' => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true]];
    $this->forge->addColumn('admissions', $fields);
    ```
4.  **Push:** Push the code to GitHub.
5.  **Pull & Migrate:** Pull the code to the live server, and simply run `php spark migrate`. The live server instantly and safely modifies the database without losing any of the 5,000 students!

---

## The Engineer's Oath

As you graduate from this Week 5 curriculum, remember:

1.  **Never trust user input.** (Use Validation & XSS Sanity checks).
2.  **Keep Controllers Skinny.** (Use Service Layers).
3.  **Assume the server will fail.** (Use Error Logging and Backups).
4.  **Never break backward compatibility without versioning.** (Use API v1, v2).

You are now ready to build Enterprise-grade web applications. Happy coding!
