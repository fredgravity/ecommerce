<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vendor Order</title>
</head>
<body>
    <div style="width: 600px; padding: 15px; margin: 0 auto; background-color: #3c3f41; color: white;">
        <img src="/images/logo.jpg">
        <br>
        <?php
        echo "Customer Name: ".$data['custName'];
        ?>
        <br>
        <?php
        echo "Email: ".$data['custEmail'];
        ?>
        <br>
        <?php
        echo "Phone: ".$data['custPhone'];
        ?>
        <br>
        <?php
        echo "Phone: ".$data['custCountry'];
        ?>
        <br>
        <br>
        <br>

        <table>
            <thead>
                <tr>
                    <td>Image</td>
                    <td>Invoice No</td>
                    <td>Product Name</td>
                    <td>Unit Price</td>
                    <td>Quantity</td>
                    <td>Total $</td>
                </tr>
            </thead>
            <tbody>
                    <tr>
                        <td  style="width: 70px; height: 60px;"><img src=" <?php echo $data['productImg'] ?> " alt="<?php echo $data['productName'] ?> "></td>
                        <td><?php echo $data['orderId'] ?> </td>
                        <td><?php echo $data['productName'] ?> </td>
                        <td><?php echo $data['price'] ?> </td>
                        <td><?php echo $data['quantity'] ?> </td>
                        <td><?php echo $data['total'] ?> </td>
                    </tr>
            </tbody>
        </table>
        <br>
        <br>
        <br>
        <p>Customer with the above information has ordered for your product. Please contact customer and deliver products</p>
        <p>Thanks for Selling from Artisao</p>

        <p>
            Regards <br><br>
            <strong>Artisao Team</strong>
        </p>
    </div>
</body>
</html>

