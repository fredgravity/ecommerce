

<!-- SIDE BAR -->
<div class="off-canvas position-left reveal-for-large nav" id="offCanvas" data-off-canvas >

    <h3> Admin Panel </h3>

    <div class="image-holder text-center">
        <img src="/images/fred.jpg" alt="gravity" title="Admin">
        <p><?php echo e(user()->fullname); ?></p>
    </div>


    <ul class="vertical menu">

        <li> <a href="/admin"> <i class="fa fa-tachometer-alt fa-fw" aria-hidden="true"> </i> &nbsp; Dashboard </a> </li>
        <li> <a href="/admin/users-dashboard"> <i class="fa fa-users fa-fw" aria-hidden="true"> </i> &nbsp; Users </a> </li>
        <li> <a href="/admin/product/create"> <i class="fa fa-plus fa-fw" aria-hidden="true"> </i> &nbsp; Add Product </a> </li>
        <li> <a href="/admin/products"> <i class="fa fa-edit fa-fw" aria-hidden="true"> </i> &nbsp; Manage Product </a> </li>
        <li> <a href="/admin/product/categories"> <i class="fa fa-layer-group fa-fw" aria-hidden="true"> </i> &nbsp; Categories </a> </li>
        <li> <a href="/admin/orders"> <i class="fa fa-shopping-cart fa-fw" aria-hidden="true"> </i> &nbsp; View Orders </a> </li>
        <li> <a href="/admin/users/payments"> <i class="fa fa-credit-card fa-fw" aria-hidden="true"> </i> &nbsp; Payments </a> </li>
        <li> <a href="/admin/vendorVerify"> <i class="fa fa-check fa-fw" aria-hidden="true"> </i> &nbsp; Verify Accounts </a> </li>
        <li> <a href="/admin/broadcast-email"> <i class="fa fa-broadcast-tower fa-fw" aria-hidden="true"> </i> &nbsp; Broadcast Email </a> </li>
        <li> <a href="/"> <i class="fa fa-home fa-fw" aria-hidden="true"> </i> &nbsp; Home </a> </li>
        <li> <a href="/logout"> <i class="fa fa-sign-out-alt fa-fw" aria-hidden="true"> </i> &nbsp; Logout </a> </li>

    </ul>
    <!-- END SIDE BAR -->
</div>