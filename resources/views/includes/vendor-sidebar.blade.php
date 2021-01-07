

<!-- SIDE BAR -->
<div class="off-canvas position-left reveal-for-large nav" id="offCanvas" data-off-canvas >

    <h3> Vendor Panel </h3>

    <div class="image-holder text-center">

        @if( user()->image_path )
            <img src="/{{ user()->image_path }}" alt="{{ user()->username }}" title="Vendor">
        @else
            <img src="/images/defaultProfile1.jpg" alt="{{ user()->username }}" title="Vendor">
        @endif
        <p>{{ user()->fullname }}</p>
    </div>


    <ul class="vertical menu">

        <li> <a href="/vendor"> <i class="fa fa-tachometer-alt fa-fw" aria-hidden="true"> </i> &nbsp; Dashboard </a> </li>
        <li> <a href="/vendor/vendorDetails"> <i class="fa fa-users fa-fw" aria-hidden="true"> </i> &nbsp; Vendor Details </a> </li>
        <li> <a href="/vendor/product/create"> <i class="fa fa-plus fa-fw" aria-hidden="true"> </i> &nbsp; Add Product </a> </li>
        <li> <a href="/vendor/product/manage"> <i class="fa fa-edit fa-fw" aria-hidden="true"> </i> &nbsp; Manage Inventory </a> </li>
        <li> <a href="/vendor/orders"> <i class="fa fa-shopping-cart fa-fw" aria-hidden="true"> </i> &nbsp; View Orders </a> </li>
        <li> <a href="/vendor/revenue"> <i class="fa fa-credit-card fa-fw" aria-hidden="true"> </i> &nbsp; Revenue </a> </li>
        <li> <a href="/vendor/validateAccount"> <i class="fa fa-check fa-fw" aria-hidden="true"> </i> &nbsp; Validate Account </a> </li>
        <li> <a href="/"> <i class="fa fa-home fa-fw" aria-hidden="true"> </i> &nbsp; Home </a> </li>
        <li> <a href="/logout"> <i class="fa fa-sign-out-alt fa-fw" aria-hidden="true"> </i> &nbsp; Logout </a> </li>

    </ul>
    <!-- END SIDE BAR -->
</div>