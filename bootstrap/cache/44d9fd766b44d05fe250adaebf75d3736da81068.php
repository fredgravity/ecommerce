<?php $__env->startSection('title', 'Users Details'); ?>
<?php $__env->startSection('data-page-id', 'users'); ?>

<?php $__env->startSection('content'); ?>


    <div class="users admin_shared grid-container full" id="user-search">

            <div class="grid-x grid-padding-x">
                <div class="cell">
                    <h2 class="text-center">Manage <?php echo e(ucfirst($role)); ?></h2><hr>
                </div>
            </div>


        <div class="grid-x grid-padding-x">

            <div class="cell medium-6">
                <form action="" method="post" class="small-12 medium-5 ">
                    <div class=" input-group">
                        <input type="text" class="input-group-field" placeholder="Search User" id="searchUserField" name="search_field" value="<?php echo e(\App\classes\Request::oldData('post','search_field')); ?>" data-token="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">
                        <div class="input-group-button">
                            <input type="button" value="Search" class="button search-user" @click.prevent="search_<?php echo e($role); ?>">
                        </div>
                    </div>
                </form>

            </div>


            
            <div class="text-center">
                <img src="/images/spinners/cube.gif" alt="loader" v-show="loading" class="cube-loader" style="width: 100px; height: 100px; padding-bottom: 3rem;" >
            </div>

            <div v-if="showSearch" class="cell" >



                            
                            <table class="hover unstriped small-12" data-form="userDelete">
                                <thead>
                                <tr>
                                    <td>Username</td>
                                    <td>Full Name</td>
                                    <td>Email</td>
                                    <td>Phone#</td>
                                    <td>Location</td>
                                    <td>Role</td>
                                    <td width="70">Action</td>
                                </tr>
                                </thead>

                                <tbody>



                                    <tr v-for="searchUser in searchUsers" v-cloak>
                                        
                                        <td>{{ searchUser.username }}</td>
                                        <td>{{ searchUser.fullname }}</td>
                                        <td>{{ searchUser.email }}</td>
                                        <td>{{ searchUser.phone }}</td>
                                        <td>{{ searchUser.country_name }}</td>
                                        <td>{{ searchUser.role }}</td>


                                        <td width="50" class="text-center">
                                            <span data-tooltip class="has-tip top" tabindex="1" title="Edit User" >
                                                <a :href="'/admin/user/'+searchUser.id+'/edit'"><i class="fa fa-edit" title="Edit User"></i></a>
                                            </span>
                                                &nbsp;

                                                <span data-tooltip class="has-tip top" tabindex="1" title="Delete User">
                                                <form :action="'/admin/user/'+searchUser.id+'/deleteuser'" method="post" class="delete-user">
                                                    <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">
                                                    <button type="button"><i class="fa fa-times delete" @click="confirmDelete"></i></button>
                                                </form>
                                            </span>

                                        </td>


                                    </tr>



                                <?php echo $__env->make('includes.delete-model', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                </tbody>
                            </table>

                            
                                

                            


                <div v-if="searchUsers.length == 0">
                    <div class="cell">
                        <h2>The <?php echo e($role); ?> you are looking for is not available</h2>
                    </div>
                </div>


            </div >

            <div v-else class="cell">
                <?php if(count($users)): ?>


                            
                            <table class="hover unstriped small-12" data-form="userDelete">
                                <thead>
                                <tr>
                                    <td>Username</td>
                                    <td>Full Name</td>
                                    <td>Email</td>
                                    <td>Phone#</td>
                                    <td>Location</td>
                                    <td>Role</td>
                                    <td width="70">Action</td>
                                </tr>
                                </thead>

                                <tbody>

                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <tr>
                                        
                                        <td><?php echo e($user['username']); ?></td>
                                        <td><?php echo e($user['fullname']); ?></td>
                                        <td><?php echo e($user['email']); ?></td>
                                        <td><?php echo e($user['phone']); ?></td>
                                        <td><?php echo e($user['country_name']); ?></td>
                                        <td><?php echo e($user['role']); ?></td>


                                        <td width="50" class="text-center">
                                            <span data-tooltip class="has-tip top" tabindex="1" title="Edit User" >
                                                <a href="/admin/user/<?php echo e($user['id']); ?>/edit"><i class="fa fa-edit" title="Edit User"></i></a>
                                            </span>
                                                &nbsp;

                                            <span data-tooltip class="has-tip top" tabindex="1" title="Delete User">
                                                <form action="/admin/user/<?php echo e($user['id']); ?>/deleteuser" method="post" class="delete-user">
                                                    <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">
                                                    <button type="button"><i class="fa fa-times delete" @click="confirmDelete"></i></button>
                                                </form>
                                            </span>

                                        </td>


                                    </tr>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php echo $__env->make('includes.delete-model', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                </tbody>
                            </table>

                            <?php if(count($links)): ?>
                                <?php echo $links; ?>


                            <?php endif; ?>


                <?php else: ?>
                    <div class="cell">

                            <h2>The <?php echo e($role); ?> you are looking for is not available</h2>
                    </div>


                <?php endif; ?>
            </div>





        </div>



        <?php $__env->stopSection(); ?>


    </div>


<?php echo $__env->make('admin.layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>