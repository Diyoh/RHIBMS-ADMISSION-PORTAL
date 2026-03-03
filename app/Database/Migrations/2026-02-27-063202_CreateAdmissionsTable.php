<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAdmissionsTable extends Migration
{
    public function up()
    {
        // $this->forge is a built-in CodeIgniter class used to construct database tables.
        // First, we define all the fields (columns) our 'admissions' table will have.
        $this->forge->addField([
            'id' => [
                'type'           => 'INT', // Integer format
                'constraint'     => 11,    // Maximum length of 11 digits
                'unsigned'       => true,  // Must be a positive number
                'auto_increment' => true,  // Automatically increments for each new record
            ],
            'admission_number' => [
                // A unique system-generated identifier for each student (e.g., ADM-2026-001)
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'unique'     => true,
            ],
            'first_name' => [
                'type'       => 'VARCHAR', // Variable character string
                'constraint' => '100',     // Maximum 100 characters
            ],
            'last_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'course' => [
                'type'       => 'VARCHAR',
                'constraint' => '100', // The chosen program of study
            ],
            'dob' => [
                'type' => 'DATE', // Date of birth
            ],
            'status' => [
                // The current state of the application
                'type'       => 'ENUM',
                'constraint' => ['pending', 'approved', 'rejected'],
                'default'    => 'pending', 
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true, // Can be empty initially
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // We set the 'id' column as the Primary Key for this table.
        // The TRUE parameter indicates it is a primary key.
        $this->forge->addKey('id', true);

        // Finally, we instruct the forge to actually create the table in the MySQL database.
        $this->forge->createTable('admissions');
    }

    public function down()
    {
        // The down() method is used to reverse the migration.
        // If we "rollback" this migration, it will drop (delete) the 'admissions' table.
        $this->forge->dropTable('admissions');
    }
}
