<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="wrap text-center">
                                <h1>403 <br>Forbidden</h1>

                                <p>
                                    <?php if (!empty($message) && $message !== '(null)') : ?>
                                        <?= nl2br(esc($message)) ?>
                                    <?php else : ?>
                                        Access to this resource on the server is denied!
                                    <?php endif ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php echo $this->endSection() ?>