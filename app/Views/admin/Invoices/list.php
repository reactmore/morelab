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
                <?php echo $this->include('admin/includes/_messages') ?>
                <div class="col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row table-filter-container">
                                <div class="col-sm-12">
                                    <?php $uri = service('uri'); ?>
                                    <?php $request = \Config\Services::request(); ?>
                                    <?php $url = !empty($uri->getSegment(3)) ? $uri->getSegment(2) . '/' . $uri->getSegment(3) : $uri->getSegment(2) ?>
                                    <?php echo form_open(admin_url() . $url, ['method' => 'GET']); ?>


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
                                        <label><?php echo trans("status"); ?></label>
                                        <select name="status" class="form-control">
                                            <option value=""><?php echo trans("all"); ?></option>
                                            <option value="Paid" <?php echo ($request->getVar('status') == "Paid") ? 'selected' : ''; ?>><?php echo "Paid"; ?></option>
                                            <option value="Unpaid" <?php echo $request->getVar('status') == "Unpaid" ? 'selected' : ''; ?>><?php echo "Unpaid"; ?></option>
                                            <option value="Partially" <?php echo $request->getVar('status') == "Unpaid" ? 'selected' : ''; ?>><?php echo "Partially"; ?></option>
                                            <option value="Overdue" <?php echo $request->getVar('status') == "Unpaid" ? 'selected' : ''; ?>><?php echo "Overdue"; ?></option>
                                        </select>
                                    </div>


                                    <div class="item-table-filter item-table-filter-long">
                                        <label><?php echo trans("search"); ?></label>
                                        <input name="search" class="form-control" placeholder="<?php echo trans("search") ?>" type="search" value="<?php echo $request->getVar('search'); ?>">
                                    </div>
                                    <input type="hidden" name="page" value="<?php echo (!empty($request->getVar('page'))) ? $request->getVar('page') : '1'; ?>">

                                    <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                                        <label style="display: block">&nbsp;</label>
                                        <button type="submit" class="btn btn-primary"><?php echo trans("filter"); ?></button>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">

                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr role="row">
                                                    <th width="20"><?php echo trans('id'); ?></th>
                                                    <th><?php echo trans('invoice') ?></th>
                                                    <th><?php echo trans('client') ?> </th>
                                                    <th><?php echo trans('amount') ?> </th>
                                                    <th><?php echo trans('due_date') ?> </th>
                                                    <th><?php echo trans('date') ?> </th>
                                                    <th><?php echo trans('status') ?> </th>
                                                    <th class="max-width-120"><?php echo trans('options'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($invoices as $invoice) : ?>
                                                    <tr>
                                                        <td><?php echo $invoice->id ?></td>
                                                        <td><?php echo $invoice->invoice_no ?></td>
                                                        <td><?php echo $invoice->client_name ?> </td>
                                                        <td><?php echo price_formatted($invoice->grand_total, $invoice->currency); ?></td>
                                                        <td><?php echo $invoice->due_date ?></td>
                                                        <td><?php echo $invoice->created_at ?></td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-outline-<?php echo ($invoice->payment_status === 'Unpaid' || $invoice->payment_status === 'Overdue') ? 'danger' : 'success' ?> waves-effect waves-light"><?php echo $invoice->payment_status ?></button>
                                                        </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm btn-primary dropdown-toggle waves-effect waves-light" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="mdi mdi-circle-edit-outline mr-2"></i> <?php echo trans('select_an_option'); ?>
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-right">

                                                                    <a class="dropdown-item" href="<?php echo base_url('/invoices/') . html_escape($invoice->txn_id); ?>"><?php echo trans('url'); ?></a>
                                                                    <a class="dropdown-item" href="<?php echo admin_url(); ?>invoices/detail-invoice/<?php echo html_escape($invoice->id); ?>"><?php echo trans('view'); ?></a>
                                                                    <a class="dropdown-item" href="<?php echo admin_url(); ?>invoices/edit-invoice/<?php echo html_escape($invoice->id); ?>"><?php echo trans('edit'); ?></a>

                                                                    <div class="dropdown-divider"></div>
                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="delete_item('/admin/invoicesmanagement/delete_invoice_post','<?php echo $invoice->id; ?>','<?php echo trans('confirm_invoice'); ?>');"><?php echo trans('delete'); ?></a>

                                                                </div>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <?php if (empty($invoices)) : ?>
                                            <p class="text-center text-muted"><?php echo trans("no_records_found"); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 float-right">
                                    <?php echo $paginations ?>
                                </div>
                            </div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->

            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<?php echo $this->endSection() ?>