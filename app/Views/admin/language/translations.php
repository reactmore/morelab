<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
<link href="<?php echo base_url() ?>/assets/admin/plugins/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet" type="text/css" />
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
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>language-settings"><?php echo trans('language') ?></a></li>
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
                <div class="col-lg-12 col-xl-12">
                    <div class="card ">
                        <div class="card-header">
                            <h5 class="card-title text-uppercase">
                                <i class="fa fa-language pr-1"></i> <?php echo $title; ?> <?php echo $language->name; ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <?php echo view('admin/language/_filter_translations'); ?>
                                        <table class="table table-bordered table-striped dataTable">
                                            <thead>
                                                <tr role="row">
                                                    <th><?php echo trans('id'); ?></th>
                                                    <th><?php echo trans('label'); ?></th>
                                                    <th><?php echo trans('translation'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php foreach ($paginate['translations'] as $item) : ?>
                                                    <tr class="tr-phrase">
                                                        <td style="width: 50px;"><?php echo $item->id; ?></td>
                                                        <td style="width: 40%;"><?php echo $item->label; ?></td>
                                                        <td style="width: 60%;"><a href="javascript:void(0)" class="inline-editable" id="inline-editable" data-type="text" data-pk="<?php echo $item->id; ?>" data-name="translations" data-title="Enter Label" data-link="<?php echo admin_url() ?>language-settings/update-translation-post"><?php echo $item->translation; ?></a></td>

                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>

                                        <?php if (empty($paginate['translations'])) : ?>
                                            <p class="text-center text-muted"><?= trans("no_records_found"); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-4 float-end">
                                    <?php echo $pager->Links('default', 'custom_pager') ?>
                                </div>
                            </div>
                        </div>
                        <!-- end card-body -->
                    </div>
                </div> <!-- end col -->

            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script src="<?php echo base_url() ?>/assets/admin/plugins/bootstrap-editable/js/index.js"></script>
<script src="<?php echo base_url() ?>/assets/admin/js/pages/languages-translations.js"></script>
<?php echo $this->endSection() ?>