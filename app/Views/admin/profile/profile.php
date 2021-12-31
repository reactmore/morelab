<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <div class="content-header">

    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->
            <div class="row">


                <div class="col-lg-12 col-xl-4">
                    <?php echo view('admin/profile/_profile') ?>
                </div> <!-- end col -->

                <div class="col-lg-12 col-xl-8">
                    <?php echo view('admin/includes/_messages'); ?>
                    <?php if ($active_tab === 'details') : ?>
                        <?php echo view('admin/profile/form/_basic_informations') ?>
                    <?php endif; ?>
                    <?php if ($active_tab === 'address_information') : ?>
                        <?php echo view('admin/profile/form/_address_information') ?>
                    <?php endif; ?>
                    <?php if ($active_tab === 'change_password') : ?>
                        <?php echo view('admin/profile/form/_change_password') ?>
                    <?php endif; ?>
                    <?php if ($active_tab === 'delete_account') : ?>
                        <?php echo view('admin/profile/form/_delete_account') ?>
                    <?php endif; ?>
                </div>
            </div>
            <!-- /.row (main row) -->

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php echo $this->endSection() ?>