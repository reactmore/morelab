<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo $title ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <?php if ($title === 'Dashboard') : ?>
                            <li class="breadcrumb-item active"><a href="<?php admin_url() ?>">/</a></li>
                        <?php else :  ?>
                            <li class="breadcrumb-item"><a href="<?php admin_url() ?>"><?php echo trans('dashboard') ?></a></li>
                            <li class="breadcrumb-item active"><?php echo $title ?></li>
                        <?php endif  ?>

                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->
            <div class="row">
                <div class="col-xl-4 col-lg-5">
                    <?php echo $this->include('admin/settings/_tabs') ?>
                </div>
                <!-- Right Sidebar -->
                <div class="col-xl-8 col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="app-search">

                                    <div class="mb-2 position-relative">
                                        <h5 class="mb-4 text-uppercase"><i class="fa fa-cog pr-2"></i><?php echo trans('general_settings') ?></h5>

                                    </div>
                                </div>

                            </div>

                            <div class="mt-3">


                            </div>


                        </div> <!-- end card body -->
                    </div> <!-- end card -->
                </div>
                <!-- end Col -->
            </div><!-- End row -->
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

</div>
<!-- /.content-wrapper -->
<?php echo $this->endSection() ?>