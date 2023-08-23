
<?php if(env('STRIPE_KEY') == "" || env('STRIPE_SECRET') == ""): ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        Stripe payment is disabled, set credentials to active.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php if(env('PAYPAL_APP_SECRET') == "" || env('PAYPAL_CLIENT_ID') == ""): ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        Paypal Payment is disabled, set credentials to active.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>



<?php if(env('GOOGLE_CLIENT_ID') == "" || env('GOOGLE_CALLBACK') == "" || env('GOOGLE_SECRET') == ""): ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        Google Login Registration for customer is disabled, set credentials to active.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>


<?php if(env('FACEBOOK_CLIENT_ID') == "" || env('FACEBOOK_SECRET') == "" || env('FACEBOOK_CALLBACK') == ""): ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        Facebook Login Registration for customer is disable, set credentials to active.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

<?php endif; ?>

<?php if(env('MAIL_DRIVER') == "" ||
 env('MAIL_HOST') == "" ||
 env('MAIL_USERNAME') == "" ||
 env('MAIL_PASSWORD') == "" ||
 env('MAIL_ENCRYPTION') == "" ||
 env('MAIL_FROM_ADDRESS') == "" ||
 env('MAIL_FROM_NAME') == "" ||
 env('MAIL_PORT') == ""): ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        Smtp / Mail is disabled, set credentials to active.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>
<?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/backend/layouts/includes/config.blade.php ENDPATH**/ ?>