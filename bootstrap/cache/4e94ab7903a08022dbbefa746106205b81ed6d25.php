
<header class="navigation" id="navBar">
    <div class="title-bar toggle grid-x" data-responsive-toggle="main-menu" data-hide-for="medium">
        <div class="small-5">
            <button class="menu-icon float-left" type="button" data-toggle="main-menu"></button>
        </div>


        <div class="small-6">
            <a href="/" class="small-logo align-right"><img src="/images/logo.png" alt="atisao"></a>
        </div>

    </div>

    <div class="top-bar" id="main-menu">
        <div class="top-bar-title show-for-medium">
            <a href="/" class="logo"><img src="/images/logo.png" alt="artisao"></a>
        </div>
        <div>

            <div class="top-bar-left">
                <ul class="dropdown menu vertical medium-horizontal" data-dropdown-menu  >
                    <?php if(isAuthenticated()): ?>
                        <?php if( user()->image_path ): ?>
                            <li><a href="/<?php echo e(user()->role); ?>"><img src="/<?php echo e(user()->image_path); ?>" alt="<?php echo e(user()->username); ?>" id="nav-profile-pic">&nbsp;<?php echo e(user()->username); ?> </a> </li>

                        <?php else: ?>
                            <li><a href="/<?php echo e(user()->role); ?>"><img src="/images/defaultProfile1.jpg" alt="<?php echo e(user()->username); ?>" id="nav-profile-pic"> &nbsp;<?php echo e(user()->username); ?> </a> </li>
                        <?php endif; ?>


                    <?php endif; ?>

                    
                    <?php if($categories): ?>
                        <li >
                            <a class="top-bar-item" href="#">Categories &nbsp;<i class="fa fa-list"></i></a>

                            <ul class="dropdown menu vertical sub">
                                
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <li>
                                        <a href="/category_items/<?php echo e($category->id); ?>"><?php echo e($category->name); ?></a>

                                        
                                        <?php if(count($category->subCategories)): ?>

                                            <ul class="dropdown menu sub">
                                                
                                                <?php $__currentLoopData = $category->subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    

                                                    <li>
                                                        <a href="/all_sub_items/<?php echo e($subCategory->id); ?>" ><?php echo e($subCategory->name); ?></a>
                                                    </li>

                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </ul>
                                        <?php endif; ?>

                                    </li>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </li>
                    <?php endif; ?>


                </ul>
            </div>
        </div>



        <div class="top-bar-right">
            <ul class="dropdown menu vertical medium-horizontal">
                


                <li>
                    

                        <form action="/search-product" method="post" class="grid-x grid-padding-y" >
                            <div class="medium-8 cell">
                                <input class="input-group-field" type="text" name="searchField" placeholder="Search" id="home-search">
                            </div>
                            <div class="medium-4 cell">
                                <button class="button hollow small search-btn "  type="submit" ><i class="fa fa-search"></i>Search</button>
                                <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">
                            </div>

                        </form>


                    

                </li>

                <?php if(isAuthenticated()): ?>

                    <li><a class="top-bar-item" href="/logout"> Logout <i class="fa fa-sign-out-alt"></i> </a></li>
                <?php else: ?>
                    <li><a class="top-bar-item" href="/register">Register &nbsp;<i class="fa fa-user-plus"></i></a></li>
                    <li><a class="top-bar-item" href="/login"> Login <i class="fa fa-sign-in-alt"></i> </a></li>

                <?php endif; ?>

                <li><a class="top-bar-item" href="/contactus">Contact Us</a></li>
            </ul>



        </div>
    </div>
</header>