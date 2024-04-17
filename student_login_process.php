<?php
// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection
    $host = 'localhost';
    $dbname = 'exam';
    $username = 'root';
    $password = '1234';
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Retrieve form data
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        // Query to fetch student details
        $stmt = $pdo->prepare("SELECT * FROM students WHERE email = ?");
        $stmt->execute([$email]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Validate credentials
        if ($student && password_verify($password, $student['password'])) {
            // Redirect to exam registration page upon successful login
            header('Location: student_registration.html');
            exit();
        } else {
            echo "Invalid email or password.";
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
