<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
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
                            <li class="breadcrumb-item active"><a href="<?php echo admin_url() ?>">/</a></li>
                        <?php else :  ?>
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>"><?php echo trans('dashboard') ?></a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo trans('locations') ?></a></li>
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
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <?php echo view('admin/locations/_tabs') ?>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-locations">
                                <div class="tab-pane fade show active" id="custom-tabs-state" role="tabpanel" aria-labelledby="custom-tabs-state-tab">
                                    <div class="table-responsive">
                                        <table id="state_table" class="table table-bordered table-striped nowrap w-100 pageResize">
                                            <div class="row table-filter-container">
                                                <div class="col-sm-6">
                                                    <?php $request = \Config\Services::request(); ?>
                                                    <?php echo form_open(admin_url() . "master-locations", ['method' => 'GET']); ?>
                                                    <div class="item-table-filter" style="width: 80px; min-width: 80px;">
                                                        <label><?php echo trans("show"); ?></label>
                                                        <select name="show" class="form-control">
                                                            <option value="15" <?php echo ($request->getVar('show') == '15') ? 'selected' : ''; ?>>15</option>
                                                            <option value="30" <?php echo ($request->getVar('show') == '30') ? 'selected' : ''; ?>>30</option>
                                                            <option value="60" <?php echo ($request->getVar('show') == '60') ? 'selected' : ''; ?>>60</option>
                                                            <option value="100" <?php echo ($request->getVar('show') == '100') ? 'selected' : ''; ?>>100</option>
                                                        </select>
                                                    </div>

                                                    <div class="item-table-filter">
                                                        <label><?php echo trans('country'); ?></label>
                                                        <select name="country" class="form-control">
                                                            <option value=""><?php echo trans("all"); ?></option>
                                                            <?php
                                                            foreach ($countries as $item) : ?>
                                                                <option value="<?php echo $item->id; ?>" <?php echo ($request->getVar('country') == $item->id) ? 'selected' : ''; ?>>
                                                                    <?php echo html_escape($item->name); ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                    <div class="item-table-filter">
                                                        <label><?php echo trans("search"); ?></label>
                                                        <input name="q" class="form-control" placeholder="<?php echo trans("search"); ?>" type="search" value="<?php echo html_escape($request->getVar('q')); ?>">
                                                    </div>

                                                    <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                                                        <label style="display: block">&nbsp;</label>
                                                        <button type="submit" class="btn bg-primary"><?php echo trans("filter"); ?></button>
                                                    </div>
                                                    <?php echo form_close(); ?>
                                                </div>

                                                <div class="col-sm-6 text-right">
                                                    <a href="javascript:void(0)" class="btn bg-primary" data-toggle="modal" data-target="#modal-state"><i class="fa fa-plus pr-2"></i><?php echo trans("add"); ?></a>
                                                </div>
                                            </div>
                                            <thead>
                                                <tr class="text-center">
                                                    <th width="20"><?php echo trans('id'); ?></th>
                                                    <th><?php echo trans('name'); ?></th>
                                                    <th><?php echo trans('country'); ?></th>
                                                    <th><?php echo trans('options'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($state as $item) : ?>
                                                    <tr>
                                                        <td><?php echo html_escape($item->id); ?></td>
                                                        <td><?php echo html_escape($item->name); ?></td>
                                                        <td class="text-center">

                                                            <?php if ($item->country_status == 1) : ?>
                                                                <button class="btn btn-sm btn-success"><?php echo html_escape($item->country_name); ?></button>
                                                            <?php else : ?>
                                                                <button class="btn btn-sm btn-danger"><?php echo html_escape($item->country_name); ?></button>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="dropdown btn-group">
                                                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="mdi mdi-circle-edit-outline mr-2"></i><?php echo trans('select_an_option'); ?>
                                                                </button>

                                                                <div class="dropdown-menu dropdown-menu-animated">
                                                                    <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal-state" onclick="$('form').attr('action', '/admin/locations/state/saved_state_post'); $('#modal-modalLabel').text('<?php echo trans('edit'); ?>'); $('#modal_id').val('<?php echo html_escape($item->id); ?>'); $('#modal_name').val('<?php echo html_escape($item->name); ?>'); $('#modal_country').val('<?php echo html_escape($item->country_id); ?>').change();"><?php echo trans('edit'); ?></a>
                                                                    <div class="dropdown-divider"></div>
                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="delete_item('/admin/locations/delete_state_post','<?php echo $item->id; ?>','<?php echo trans('confirm_delete'); ?>');"><?php echo trans('delete'); ?></a>
                                                                </div>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <?php if (empty($state)) : ?>
                                            <p class="text-center text-muted"><?= trans("no_records_found"); ?></p>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer clearfix">
                            <div class="col-sm-12 float-right">
                                <?php echo $paginations ?>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div> <!-- end col -->
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- Modal -->
<div id="modal-state" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-modalLabel"><?php echo trans('add'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_safe" action="/admin/locations/state/saved_state_post" method="post">
                <input type="hidden" id="modal_id" name="id" class="form-control form-input">
                <input type="hidden" id="crsf" class="form-control form-input">

                <div class="modal-body">
                    <div class="form-group">
                        <label><?php echo trans('country'); ?></label>
                        <select id="modal_country" name="country_id" class="form-control" required>
                            <option value=""><?php echo trans("select"); ?></option>
                            <?php
                            foreach ($countries as $item) : ?>
                                <option value="<?php echo $item->id; ?>">
                                    <?php echo html_escape($item->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?php echo trans("name"); ?></label>
                        <input type="text" id="modal_name" name="name" class="form-control form-input" placeholder="<?php echo trans("name"); ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"><?php echo trans('save'); ?></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php echo $this->endSection() ?>