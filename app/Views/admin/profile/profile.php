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
                <?php echo view('admin/includes/_messages'); ?>

                <div class="col-lg-12 col-xl-4">
                    <?php echo view('admin/profile/_profile') ?>
                </div> <!-- end col -->

                <div class="col-lg-12 col-xl-8">
                    <?php if ($active_tab === 'details') : ?>
                        <?php echo view('admin/profile/form/_basic_informations') ?>
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