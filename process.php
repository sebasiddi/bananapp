<?php
if (isset($_POST['submit'])) {
    $toEmail = 'ssiddi@gmail.com'; // Replace with the recipient's email address
    $fromEmail = $_POST['email'];
    $subject = 'File Upload from Website';
    $message = 'A file has been uploaded.';

    $file = $_FILES['file']['tmp_name'];
    $filename = $_FILES['file']['name'];

    $headers = "From: $fromEmail\r\n";
    $headers .= "Reply-To: $fromEmail\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=" . md5(time());

    $content = "--" . md5(time()) . "\r\n";
    $content .= "Content-Type: text/plain; charset=\"utf-8\"\r\n";
    $content .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $content .= "$message\r\n";

    if (is_uploaded_file($file)) {
        $attachment = chunk_split(base64_encode(file_get_contents($file)));
        $content .= "--" . md5(time()) . "\r\n";
        $content .= "Content-Disposition: attachment; filename=\"$filename\"\r\n";
        $content .= "Content-Type: application/octet-stream; name=\"$filename\"\r\n";
        $content .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $content .= $attachment . "\r\n";
    }

    $content .= "--" . md5(time()) . "--";

    if (mail($toEmail, $subject, $content, $headers)) {
        echo "Email sent successfully.";
    } else {
        echo "Error sending email.";
    }
}
?>
