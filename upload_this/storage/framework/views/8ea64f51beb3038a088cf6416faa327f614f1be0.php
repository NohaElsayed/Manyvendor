<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta http-equiv="x-ua-compatible" content="ie=edge"> 
    <title><?php echo e(getSystemSetting('type_name')); ?> | <?php echo $__env->yieldContent('title'); ?></title>
    <link rel="icon" href="<?php echo e(filePath(getSystemSetting('favicon_icon'))); ?>">

    
    <?php echo $__env->make('backend.layouts.includes.style', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldContent('css'); ?>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    
    <?php echo $__env->make('backend.layouts.includes.url', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="wrapper">
    <?php echo $__env->make('backend.layouts.includes.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('backend.layouts.includes.aside', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="content-wrapper">
        <div class="content-header">
            <?php echo $__env->make('backend.layouts.includes.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('backend.layouts.includes.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
            <!--/. container-fluid -->
        </section>
    </div>
    <?php echo $__env->make('backend.layouts.includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('backend.layouts.includes.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('backend.layouts.includes.delete', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<?php echo $__env->make('backend.layouts.includes.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldContent('script'); ?>
<?php echo $__env->make('sweetalert::alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>
<?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/backend/layouts/master.blade.php ENDPATH**/ ?>