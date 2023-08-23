<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="<?php echo e(getSystemSetting('type_name') ?? 'Manyvendor'); ?>">
    <meta name="keywords" content="<?php echo $__env->yieldContent('keywords'); ?>">
    <meta name="description" content="<?php echo e(getSystemSetting('type_name') ?? 'Manyvendor'); ?>">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(getSystemSetting('type_name')); ?> <?php echo $__env->yieldContent('title'); ?></title>
    <link rel="icon" href="<?php echo e(filePath(getSystemSetting('favicon_icon'))); ?>">
    
    <?php echo $__env->make('frontend.assets.css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
    <?php echo $__env->yieldContent('css'); ?>

</head>


<script>
  /**
 * Preloader
 */

 "use strict"

$(window).on("load", function () {
    var preLoder = $(".preloader");
    preLoder.fadeOut(1000);
});

</script>

<body>

  <!-- Preloader -->
  <div class="many-content preloader">
      <div class="loading">
          <p>Loading</p>
          <span></span>
      </div>
  </div>
  <!-- Preloader -->

  <div id="fb-root"></div>
  
 <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v7.0&appId=2307155716247033&autoLogAppEvents=1" nonce="TSPkAQLi"></script>


  
  <?php echo $__env->make('frontend.assets.url', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  
  <?php echo $__env->make('frontend.include.header.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  
  <?php echo $__env->make('frontend.include.header.mobile-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  
  <?php echo $__env->make('frontend.include.cart.shopping-cart', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  
  <?php echo $__env->make('frontend.include.sidebar.mobile.mobile-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
    <?php echo $__env->yieldContent('content'); ?>
    

  
  <?php echo $__env->make('frontend.include.footer.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


  
  <?php echo $__env->make('frontend.assets.js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  
  <?php echo $__env->yieldContent('js'); ?>

  
  <?php echo $__env->make('frontend.widgets.popup.login_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <div class="modal fade" id="product-quickview" tabindex="-1" role="dialog" aria-labelledby="product-quickview" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">

            <a href="javascript:void(0)" id="modelClose" class="modal-close" data-dismiss="modal">
              <i class="icon-cross2"></i>
            </a>

          </div>
      </div>
  </div>

  <?php echo $__env->make('backend.layouts.includes.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('sweetalert::alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</body>


</html>
<?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/frontend/master.blade.php ENDPATH**/ ?>