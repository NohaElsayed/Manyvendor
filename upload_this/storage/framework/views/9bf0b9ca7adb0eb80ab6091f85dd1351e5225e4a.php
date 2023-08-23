<?php
    $all_campaigns = App\Models\Campaign::where('active_for_customer',1)->where('end_at','>=',Carbon\Carbon::now()->format('Y-m-d'))->orderBy('start_from','asc')->get();
    $campaigns_count = App\Models\Campaign::where('active_for_customer',1)->where('end_at','>',Carbon\Carbon::now()->format('Y-m-d'))->count();
    $campaigns = collect();
    foreach ($all_campaigns as $single_campaign) {
        $demo_obj = new App\Models\Demo;
        $demo_obj->slug = $single_campaign->slug;
        $demo_obj->title = $single_campaign->title;
        $demo_obj->banner = filePath($single_campaign->banner);
        $demo_obj->end_at = $single_campaign->end_at;
        $campaigns->push($demo_obj);
    }
?>
<?php if( $campaigns_count > 0 ): ?>
    <div class="ps-deal-of-day">
        <div class="container">
            <div class="ps-section__header">
                <div class="ps-block--countdown-deal">
                    <div class="ps-block__left">
                        <h3>Live Campaigns</h3>
                    </div>

                </div>
                <a href="<?php echo e(route('customer.campaigns.index')); ?>">View all</a>
            </div>
            <div class="ps-section__content">
                <div class="row">

                    <?php $__empty_1 = true; $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php if($campaign->end_at > Carbon\Carbon::now()): ?>
                            <div class="col-md-6 col-xl-3 mb-5">
                                <a href="<?php echo e(route('customer.campaign.products', $campaign->slug)); ?>"
                                   title="<?php echo e($campaign->title); ?>">
                                    <div class="card card-body bd-light rounded-sm">
                                        <img src="<?php echo e($campaign->banner); ?>" class="img-fluid rounded-sm campaign-img"
                                             alt="<?php echo e($campaign->title); ?>"/>
                                        <?php if($campaign->end_at > Carbon\Carbon::now()): ?>
                                            <span class="bg-danger p-2 text-white rounded-pill live-now">Live now</span>
                                        <?php else: ?>
                                            <span class="bg-danger p-2 text-white rounded-pill live-now">Time Out</span>
                                        <?php endif; ?>
                                    </div>
                                </a>

                                <?php if($campaign->end_at > Carbon\Carbon::now()): ?>
                                    <div class="ps-block--countdown-deal mt-2 mb-2">
                                        <figure class="m-auto">
                                            <figcaption>End in:</figcaption>
                                            <ul class="ps-countdown"
                                                data-time="<?php echo e($campaign->end_at->format('F d, Y H:i:s')); ?>">
                                                <li><span class="days"></span></li>
                                                <li><span class="hours"></span></li>
                                                <li><span class="minutes"></span></li>
                                                <li><span class="seconds"></span></li>
                                            </ul>
                                        </figure>
                                    </div>
                                <?php endif; ?>

                            </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="col-md-12 text-center text-danger fs-18 py-5 card card-body">
                                There is no campaign live now.
                            </div>
                        <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/frontend/widgets/section/deal-day.blade.php ENDPATH**/ ?>