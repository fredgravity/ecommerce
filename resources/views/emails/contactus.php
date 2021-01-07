<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <div style="width: 600px; padding: 15px; margin: 0 auto; background-color: #0a0a0a; color: white;">
        <img src="/images/logo.jpg">
        <br>
        <?php
        echo "Name: ".$data['name'];
        ?>
        <br>
        <?php
        echo "Email: ".$data['email'];
        ?>
        <br>
        <?php
        echo "Phone: ".$data['phone'];
        ?>
        <br>
        <br>
        <?php
        echo "Message: ". $data['message'] ;

        ?>

        <p>
            Regards <br><br>
            <strong>Artisao Team</strong>
        </p>
    </div>
</body>
</html>

