<?php if (session()->getFlashdata('success_form')) : ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class="icon fas fa-ban"></i> <?php echo session()->getFlashdata('success_form'); ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('errors_form')) : ?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class="icon fas fa-ban"></i> <?php echo session()->getFlashdata('errors_form'); ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error_form')) : ?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class="icon fas fa-ban"></i> <?php echo session()->getFlashdata('error_form'); ?>
    </div>
<?php endif; ?>