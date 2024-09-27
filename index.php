<?php
// Zorg ervoor dat de Composer autoloader wordt geladen
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Verwerk het formulier na het indienen
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = $_POST['naam'];
    $email = $_POST['email'];
    $klacht = $_POST['klacht'];

    // Maak een nieuwe PHPMailer instantie
    $mail = new PHPMailer(true);

    try {
        // Server instellingen
        $mail->isSMTP();
        $mail->Host       = 'smtp.example.com'; // Gebruik je SMTP-server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'jouw_email@example.com'; // SMTP gebruikersnaam
        $mail->Password   = 'jouw_wachtwoord'; // SMTP wachtwoord
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587; // SMTP poort

        // Ontvangers
        $mail->setFrom('jouw_email@example.com', 'Klachtverwerking');
        $mail->addAddress($email); // Verstuur naar de gebruiker
        $mail->addCC('jouw_email@example.com'); // Voeg jezelf toe aan de CC

        // Inhoud van de e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Uw klacht is in behandeling';
        $mail->Body    = "<h1>Klachtverwerking</h1>
                          <p>Beste $naam,</p>
                          <p>Uw klacht is in behandeling.</p>
                          <p><strong>Uw klacht:</strong></p>
                          <p>$klacht</p>";

        // Verstuur de e-mail
        $mail->send();
        echo 'De klacht is verzonden naar uw e-mail.';
    } catch (Exception $e) {
        echo "Er is een fout opgetreden tijdens het versturen: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klachtverwerking</title>
</head>
<body>
    <h1>Dien uw klacht in</h1>
    <form action="index.php" method="post">
        <label for="naam">Naam:</label><br>
        <input type="text" id="naam" name="naam" required><br><br>

        <label for="email">E-mail:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="klacht">Omschrijving van uw klacht:</label><br>
        <textarea id="klacht" name="klacht" rows="4" cols="50" required></textarea><br><br>

        <input type="submit" value="Verstuur">
    </form>
</body>
</html>
