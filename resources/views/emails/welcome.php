<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<div style="width: 600px; padding: 15px; margin: 0 auto; background-color: #ffffff; color: #000000;">
    <img src=" <?php getenv('APP_URL'); ?>/images/logo.png " style="height: 50px; width: 100px;">
        <br>
            Dear <?php echo $data['fullname'] ?>,

        <br>
        <br>

        <p>This email is to confirm that you have created account with Artisao.</p>
        <p>If you would like to find out more about artisao, please do not hesitated to contact us on our Contact Us page of our website</p>
        <p>
            Thank you for registering as a User on Artisao.
        </p>




        <p>
            Regards <br><br>
            <strong>Artisao Team</strong>
        </p>

        <p><a href=" <?php getenv('APP_URL'); ?>/termsandconditions">Terms and Conditions</a></p>
</div>
</body>
</html>

