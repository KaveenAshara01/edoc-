<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class SignupTest extends TestCase
{
    private $mysqli;

    protected function setUp(): void
    {
        // Establish a database connection for testing.
        $this->mysqli = new mysqli('localhost', 'root', 'achintha2002', 'edoc');
        if ($this->mysqli->connect_errno) {
            $this->fail("Database connection failed: " . $this->mysqli->connect_error);
        }
    }

    protected function tearDown(): void
    {
        // Clean up the database connection.
        if ($this->mysqli) {
            $this->mysqli->close();
        }
    }

    #[Test]
    public function testSuccessfulSignup(): void
    {
        $email = "newuser2@example.com";
        $usertype = "p";

        // Prepare the SQL statement
        $stmt = $this->mysqli->prepare("INSERT INTO webuser (email, usertype) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $usertype);
        $stmt->execute();

        $result = $this->mysqli->query("SELECT * FROM webuser WHERE email='$email'");
        $this->assertSame(1, $result->num_rows, "User was not added successfully.");
    }

    #[Test]
    public function testSignupWithExistingEmail(): void
    {
        $email = "pamuthu@gmail.com";  // Assume this already exists in DB

        $query = "SELECT * FROM webuser WHERE email='$email'";
        $result = $this->mysqli->query($query);
        
        $this->assertTrue($result->num_rows > 0, "Email should already exist.");
    }

    #[Test]
    public function testPasswordMismatch(): void
    {
        $password = "password123";
        $confirmPassword = "password456";  // Mismatched password

        $this->assertNotSame($password, $confirmPassword, "Passwords should not match.");
    }

    #[Test]
    public function testInvalidEmailFormat(): void
    {
        $email = "invalid-email-format";

        $this->assertFalse(filter_var($email, FILTER_VALIDATE_EMAIL), "Invalid email format passed.");
    }

    #[Test]
    public function testInvalidMobileNumber(): void
    {
        $mobile = "123456";  // Too short

        $this->assertDoesNotMatchRegularExpression('/^[0]{1}[0-9]{9}$/', $mobile, "Mobile number format is invalid.");
    }
}
