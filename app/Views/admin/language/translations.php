<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

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
                                    <?php $this->load->view('admin/language/_filter_translations'); ?>
                                    <table class="table table-bordered table-striped dataTable">
                                        <thead>
                                            <tr role="row">
                                                <th><?php echo trans('id'); ?></th>
                                                <th><?php echo trans('label'); ?></th>
                                                <th><?php echo trans('translation'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php foreach ($translations as $item) : ?>
                                                <tr class="tr-phrase">
                                                    <td style="width: 50px;"><?php echo $item->id; ?></td>
                                                    <td style="width: 40%;"><?php echo $item->label; ?></td>
                                                    <td style="width: 60%;"><a href="javascript:void(0)" class="inline-editable" id="inline-editable" data-type="text" data-pk="<?php echo $item->id; ?>" data-name="translations" data-title="Enter Label" data-link="<?php echo base_url() ?>language_controller/update_translation_post"><?php echo $item->translation; ?></a></td>

                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>

                                    <?php if (empty($translations)) : ?>
                                        <p class="text-center text-muted"><?= trans("no_records_found"); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 float-end">
                                <?php echo $this->pagination->create_links(); ?>
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