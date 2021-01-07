<?php $__env->startSection('title', 'Vendor Validate Account'); ?>
<?php $__env->startSection('data-page-id', 'vendorValidateAccount'); ?>


<?php $__env->startSection('content'); ?>

    <div class="admin_shared grid-container full" id="validateAccount">
        <div class="grid-padding-x grid-x">


                <?php echo $__env->make('includes.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <div class="small-12 medium-6 cell">
                    <div class="id-column">
                        <p>Please upload any valid identification card (eg.Voter's etc)</p>

                        <form action="/vendor/validate/identification" method="post" enctype="multipart/form-data">
                            <label for="id_card" class="button">Upload Identification</label>
                            <input type="file" @change="idOnChange" name="id_card" id="id_card" class="show-for-sr">
                            <span><input type="submit" name="" class="button warning" value="Submit"></span>
                            <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">
                        </form>

                    </div>

                    <h6 v-if="idSize > 2000000" style="color: red;" class="text-center" v-text="text"></h6>
                    <h6 class="text-center" v-text="message"></h6>

                    <template v-if="showId === 'get'">
                        <div id="id-box" v-for="id in idImg">
                            <img :src="'/'+id.id_card" alt="id_card">
                            <template v-if="id.id_card">
                                <template v-if="id.approval">
                                    <h4 style="color: #3adb76;"><i class="fa fa-check veri"></i> &nbsp; Verified</h4>
                                </template>
                            </template>
                        </div>

                    </template>

                    <template v-else-if="showId === 'ok'">
                        <img :src="id" alt="id_card">
                    </template>

                </div>


                <div class="small-12 medium-6 cell">
                    <div class="id-column">
                        <p>Please upload a valid business registration document</p>

                        <form action="/vendor/validate/certification" method="post" enctype="multipart/form-data">
                            <label for="cert" class="button">Upload Certificate</label>
                            <input type="file" @change="certOnChange" name="cert" id="cert" class="show-for-sr">
                            <span><input type="submit" value="Submit" class="button warning"></span>
                            <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">
                        </form>

                    </div>

                    <h6 v-if="certSize > 2000000" style="color: red;" class="text-center">Warning!!! file size should be < 2mb</h6>

                    <template v-if="showCert === 'get'">
                        <div id="cert-box" v-for="cert in certImg">
                            <template v-if="cert.business_cert">
                                <img :src="'/'+cert.business_cert" alt="business_cert">
                                <template v-if="cert.approval">
                                    <h4 style="color: #3adb76;"><i class="fa fa-check veri"></i> &nbsp; Verified</h4>
                                </template>
                            </template>

                        </div>
                    </template>

                    <template v-else-if="showCert === 'ok'">
                        <div id="cert-box">
                            <img :src="cert" alt="bussiness_cert">
                        </div>
                    </template>


                </div>


        </div>
    </div>



    <?php $__env->stopSection(); ?>






<?php echo $__env->make('vendor.layout.vendor_base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>