<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <div class="float-right">
                        <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i> Print</a>
                        <?php if (empty($invoice->payment_option) || $invoice->payment_status != 'Paid') : ?>
                            <a href="javascript:void(0)" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#createPayment"><?php echo trans("add") ?> Payment</a>
                        <?php endif; ?>

                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header no-print">
                            <h3 class="card-title"> <i class="fa fa-file-invoice pr-2"></i><?php echo trans('detail') ?> <?php echo trans('invoice') ?></h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="invoice-title">
                                        <h4 class="float-right font-size-16"><strong><?php echo $invoice->invoice_no ?></strong></h4>
                                        <h3 class="mt-0">
                                            <img src="<?php echo get_logo_dark(get_general_settings()); ?>" alt="logo" height="24" />
                                        </h3>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-6">
                                            <address>
                                                <strong><?php echo trans('bill_to') ?>:</strong><br>
                                                <?php echo $invoice->client_name ?><br>
                                                <table width="50%">
                                                    <tr>
                                                        <td><?php echo $invoice->client_address ?></td>
                                                    </tr>
                                                </table>
                                            </address>
                                        </div>
                                        <div class="col-6 float-right text-right">
                                            <address>
                                                <strong><?php echo trans('bill_from') ?>:</strong><br>
                                                <?php echo  get_general_settings()->contact_name ?><br>
                                                <table class="float-right" width="50%">
                                                    <tr>
                                                        <td><?php echo get_general_settings()->contact_address ?></td>
                                                    </tr>
                                                </table>

                                            </address>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mt-4">
                                            <address>
                                                <strong>Payment Method:</strong><br>
                                                <?php echo $invoice->payment_name ?><br>
                                                <?php echo $invoice->payment_account ?>
                                            </address>
                                        </div>
                                        <div class="col-6 mt-4 text-right">
                                            <address>
                                                <strong>Order Date:</strong><br>
                                                <?php echo helper_date_format($invoice->created_at); ?><br><br>
                                            </address>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">


                                <div class="col-12">
                                    <div>
                                        <div class="p-2">
                                            <h3 class="font-size-16"><strong>Order summary</strong></h3>
                                        </div>
                                        <div class="">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <td><strong><?php echo trans('item') ?></strong></td>
                                                            <td class="text-center"><strong><?php echo trans('quantity') ?></strong></td>
                                                            <td class="text-center"><strong><?php echo trans('price') ?></strong></td>
                                                            <td class="text-center"><strong><?php echo trans('tax') ?></strong></td>
                                                            <td class="text-right"><strong><?php echo trans('total') ?></strong></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                                        <?php $items_detail = unserialize($invoice->items_detail); ?>
                                                        <?php $count = count($items_detail['product_description']); ?>
                                                        <?php for ($i = 0; $i < $count; $i++) : ?>
                                                            <tr>
                                                                <td><?php echo $items_detail['product_description'][$i]; ?></td>
                                                                <td class="text-center"><?php echo $items_detail['quantity'][$i]; ?></td>
                                                                <td class="text-center"><?php echo price_formatted($items_detail['price'][$i], $invoice->currency); ?></td>
                                                                <td class="text-center"><?php echo $items_detail['tax'][$i]; ?>%</td>
                                                                <td class="text-right"><?php echo price_formatted($items_detail['total'][$i], $invoice->currency); ?></td>
                                                            </tr>
                                                        <?php endfor; ?>
                                                        <tr>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line text-right"></td>
                                                            <td class="no-line text-right"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-6">
                                    <address>
                                        <strong>Note :</strong><br>
                                        <?php echo $invoice->client_note ?><br>
                                        <?php if ($invoice->payment_option === 'Manual') : ?>
                                            <strong><?php echo 'Please fill in the transfer report with the invoice number' ?></strong><br>
                                        <?php endif; ?>
                                    </address>
                                </div>
                                <div class="col-6">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td class="no-line" style="border-top: 0px;"></td>
                                                <td class="no-line" style="border-top: 0px;"></td>
                                                <td class="no-line" style="border-top: 0px;"></td>
                                                <td class="no-line text-right" style="border-top: 0px;">
                                                    <strong><?php echo trans('subtotal') ?></strong>
                                                </td>
                                                <td class="no-line text-right" style="border-top: 0px;">
                                                    <?php echo price_formatted($invoice->sub_total, $invoice->currency); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="no-line" style="border-top: 0px;"></td>
                                                <td class="no-line" style="border-top: 0px;"></td>
                                                <td class="no-line" style="border-top: 0px;"></td>
                                                <td class="no-line text-right" style="border-top: 0px;">
                                                    <strong><?php echo trans('tax') ?></strong>
                                                </td>
                                                <td class="no-line text-right" style="border-top: 0px;">
                                                    <?php echo price_formatted($invoice->total_tax, $invoice->currency); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="no-line" style="border-top: 0px;"></td>
                                                <td class="no-line" style="border-top: 0px;"></td>
                                                <td class="no-line" style="border-top: 0px;"></td>
                                                <td class="no-line text-right" style="border-top: 0px;">
                                                    <strong><?php echo trans('discount') ?></strong>
                                                </td>
                                                <td class="no-line text-right" style="border-top: 0px;">
                                                    <?php echo $invoice->discount; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="no-line" style="border-top: 0px;"></td>
                                                <td class="no-line" style="border-top: 0px;"></td>
                                                <td class="no-line" style="border-top: 0px;"></td>
                                                <td class="no-line text-right" style="border-top: 0px;">
                                                    <strong><?php echo trans('total') ?></strong>
                                                </td>
                                                <td class="no-line text-right" style="border-top: 0px;">
                                                    <h4 class="m-0"><?php echo price_formatted($invoice->grand_total, $invoice->currency) . ' ' . $invoice->currency; ?></h4>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div> <!-- end row -->
                        </div>
                    </div>
                </div>


                <div class="col-lg-12 ">
                    <div class="card d-print-none">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table id="cs_datatable" class="table table-bordered table-striped">
                                            <thead>
                                                <tr role="row">
                                                    <th width="20"><?php echo trans('id'); ?></th>
                                                    <th><?php echo trans('payment_method'); ?></th>
                                                    <th><?php echo trans('amount'); ?></th>
                                                    <th><?php echo trans('date'); ?></th>
                                                    <th><?php echo trans('options'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>



        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php echo $this->endSection() ?>