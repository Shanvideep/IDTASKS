<?php
// PHP mailer library files importing
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Start the session
session_start();

// Function to send registration email using Gmail SMTP
function sendRegistrationEmails($emailAddresses) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = 1;                 // Enable verbose debug output
        $mail->isSMTP();                      // Send using SMTP
        $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth   = true;             // Enable SMTP authentication
        $mail->Username   = 'vinaynishad507@gmail.com'; // Your Gmail email address
        $mail->Password   = 'ojwlhuftrtmidesg'; // Your Gmail password or an App Password if 2-Step Verification is enabled
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable TLS encryption
        $mail->Port       = 465;              // TCP port to connect to

        // Content
        $mail->isHTML(true);         // Set email format to HTML
        $mail->Subject = 'Unlock Your Future: Join Btech Walleh Exciting Internship Program!';

        $mail->AddEmbeddedImage('emailheadernew.png', 'emailheader');
        
        // Embed the QR code image in the email body
        $mail->isHTML(true); // Make sure HTML format is enabled
        $mail->Body = "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                    background-color: #f2f2f2;
                    border-radius: 10px;
                    box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
                }
                .content {
                    max-width: 600px;
                    max-height: 849px;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <a href='https://btechwalleh.live/' target='_blank'>
                    <img class='content' src='cid:emailheader' alt='Btech Walleh' />
                </a>
            </div>
        </body>
        </html>
        ";
        

        foreach ($emailAddresses as $toEmail) {
            // Recipients
            $mail->setFrom('vinaynishad507@gmail.com', 'Internship Program!');
            $mail->addAddress($toEmail);  // Add a recipient

            // Send the email
            if ($mail->send()) {
                // Log or handle success
            } else {
                // Log or handle failure
            }
        }
    } catch (Exception $e) {
        // Handle exceptions
    }
}

// Example usage:
try {
    // Replace with your database credentials
    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPassword = '';
    $dbName = 'test';

    // Establish a database connection using PDO
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to retrieve email addresses from your table
    $stmt = $pdo->prepare("SELECT email FROM gadmin");
    $stmt->execute();
    $emailRows = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Call the sendRegistrationEmails function with the retrieved email addresses
    if (sendRegistrationEmails($emailRows)) {
        echo "Emails sent successfully.";
    } else {
        echo "Emails could not be sent. Error: " . $_SESSION['email_error'];
    }
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
}
?>
