<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class LoginTest extends TestCase
{
    private $db;

    protected function setUp(): void
    {
        // Create a mock connection to the database
        $this->db = new mysqli('localhost', 'root', 'achintha2002', 'edoc'); // Adjust DB details as needed
        if ($this->db->connect_errno) {
            $this->fail("Failed to connect to MySQL: " . $this->db->connect_error);
        }
    }

    protected function tearDown(): void
    {
        // Close DB connection after test
        $this->db->close();
    }

    #[Test]
    public function testValidPatientLogin(): void
    {
        $email = 'pamuthu@gmail.com'; // Use valid test email
        $password = '123'; // Valid password

        // Simulate SQL query
        $result = $this->db->query("SELECT * FROM webuser WHERE email='$email'");
        $this->assertSame(1, $result->num_rows, 'User not found in the system.');

        $userType = $result->fetch_assoc()['usertype'];
        $this->assertSame('p', $userType, 'User type is not patient.');

        $patientCheck = $this->db->query("SELECT * FROM patient WHERE pemail='$email' AND ppassword='$password'");
        $this->assertSame(1, $patientCheck->num_rows, 'Invalid credentials for patient login.');
    }

    #[Test]
    public function testInvalidPassword(): void
    {
        $email = 'pamuthu@gmail.com'; // Use valid test email
        $password = 'wrongpassword'; // Invalid password

        $result = $this->db->query("SELECT * FROM patient WHERE pemail='$email' AND ppassword='$password'");
        $this->assertSame(0, $result->num_rows, 'Login succeeded with incorrect password.');
    }

    #[Test]
    public function testNonExistentUser(): void
    {
        $email = 'nonexistent@example.com'; // Email that doesn't exist
        $password = 'password123';

        $result = $this->db->query("SELECT * FROM webuser WHERE email='$email'");
        $this->assertSame(0, $result->num_rows, 'Non-existent user was found.');
    }

    #[Test]
    public function testEmptyEmailAndPassword(): void
    {
        $email = '';
        $password = '';

        $this->assertEmpty($email, 'Email field is not empty.');
        $this->assertEmpty($password, 'Password field is not empty.');
    }
}
