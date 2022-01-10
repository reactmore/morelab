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
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>invoices/list-invoices"><?php echo trans('invoices') ?></a></li>
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
            <?php echo form_open(base_url('admin/InvoicesManagement/edit_invoice_post')); ?>
            <input type="hidden" name="id" value="<?php echo $invoice->id; ?>">
            <?php echo view('admin/includes/_messages'); ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="app-search">
                                    <div class="mb-2 position-relative">
                                        <h5 class="mb-4 text-uppercase"><i class="fa fa-user pr-2"></i><?php echo trans('bill_to') ?></h5>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="client_id" class="control-label"><?php echo trans('select') ?> <?php echo trans('client') ?></label>
                                <select class="form-control customer" id="client_id" name="client_id" required>
                                    <option value="">Please Select Customer</option>
                                    <?php foreach ($client as $client) : ?>
                                        <option value="<?php echo $client->id ?>" <?php echo $client->id == $invoice->user_id ? 'selected' : '' ?>><?php echo $client->first_name . ' ' . $client->last_name  ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mt-2">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="invoice_no" class="control-label"><?php echo trans('invoice') ?>#</label>
                                                    <input type="text" name="invoice_no" class="form-control" id="invoice_no" value="<?php echo $invoice->invoice_no ?>" placeholder="eg. Inv-1001" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="date" class="control-label"><?php echo trans('date') ?></label>
                                                <input type="datetime-local" name="billing_date" class="form-control " id="billing_date" placeholder="" value="<?php echo date("Y-m-d\TH:i:s", strtotime($invoice->created_at)) ?>" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="date" class="control-label"><?php echo trans('due_date') ?></label>
                                                <input type="datetime-local" name="due_date" class="form-control " id="due_date" placeholder="" value="<?php echo date("Y-m-d\TH:i:s", strtotime($invoice->due_date)) ?>" required>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="firstname" class="control-label" required><?php echo trans('status') ?></label>
                                                    <select class="form-control" name="payment_status">
                                                        <option value="Unpaid" <?php echo ($invoice->payment_status === 'Unpaid') ? 'selected' : '' ?>>Unpaid</option>
                                                        <option value="Partially" <?php echo ($invoice->payment_status === 'Partially') ? 'selected' : '' ?>>Partially</option>
                                                        <option value="Paid" <?php echo ($invoice->payment_status === 'Paid') ? 'selected' : '' ?>>Paid</option>
                                                        <option value="Overdue" <?php echo ($invoice->payment_status === 'Overdue') ? 'selected' : '' ?>>Overdue</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mt-2">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th><?php echo trans('action') ?></th>
                                                    <th width="40%"><?php echo trans('item') ?></th>
                                                    <th class="text-center"><?php echo trans('quantity') ?></th>
                                                    <th class="text-center"><?php echo trans('price') ?></th>
                                                    <th class="text-center"><?php echo trans('tax') ?> <i class="fas fa-percent"></i></th>
                                                    <th><?php echo trans('total') ?></th>
                                                </tr>
                                            </thead>
                                            <tbody class="field_wrapper">
                                                <?php $items_detail = unserialize($invoice->items_detail); ?>
                                                <?php $count = count($items_detail['product_description']); ?>
                                                <?php for ($i = 0; $i < $count; $i++) : ?>
                                                    <tr class="item">
                                                        <td>
                                                            <div class=" form-group">
                                                                <a href="javascript:void(0);" class="<?php echo ($i == 0) ? 'add_button btn-primary' : 'remove_button btn-danger calcEvent'; ?> btn btn-sm" title="Add field"><i class="fa <?php echo ($i == 0) ? 'fa-plus' : 'fa-minus'; ?>"></i></a>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class=" form-group">
                                                                <input type="text" name="product_description[]" value="<?php echo $items_detail['product_description'][$i]; ?>" class="form-control calcEvent" id="product_description" placeholder="Description">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="number" name="quantity[]" value="<?php echo $items_detail['quantity'][$i]; ?>" value="1" class="form-control calcEvent quantity" id="quantity" placeholder="">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="number" name="price[]" value="<?php echo $items_detail['price'][$i]; ?>" class="form-control calcEvent price" id="price" placeholder="">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="number" name="tax[]" value="<?php echo $items_detail['tax'][$i]; ?>" class="form-control calcEvent tax" id="tax" placeholder="">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="hidden" name="total[]" value="<?php echo $items_detail['total'][$i]; ?>" class="form-control calcEvent item_total" placeholder="">
                                                            <strong class="item_total"><?php echo $items_detail['total'][$i]; ?></strong>
                                                        </td>

                                                    </tr>
                                                <?php endfor; ?>
                                            </tbody>
                                        </table>

                                        <div class="col-md-6 float-right">
                                            <table class="table">
                                                <tr>
                                                    <th style="border-top:0px"><strong><?php echo trans('subtotal') ?>: </strong></th>
                                                    <input type="hidden" name="sub_total" class="sub_total">
                                                    <td class="text-right" style="border-top:0px"><span class="sub_total"><?php echo $invoice->sub_total ?></span></td>
                                                </tr>
                                                <tr>
                                                    <th style="border-top:0px"><strong><?php echo trans('tax') ?>: </strong></th>
                                                    <input type="hidden" name="total_tax" class="total_tax">
                                                    <td class="text-right" style="border-top:0px"><span class="total_tax"><?php echo $invoice->total_tax ?></span></td>
                                                </tr>
                                                <tr>
                                                    <th style="border-top:0px"><strong><?php echo trans('discount') ?>: </strong></th>
                                                    <td class="text-right" style="border-top:0px">
                                                        <div class="input-group">
                                                            <div class=" input-group-append bg-custom b-0"><span class="input-group-text">Rp. </span>
                                                            </div>
                                                            <input type="number" dir="rtl" name="discount" class="form-control calcEvent float-right input-sm" id="discount" placeholder="" value="<?php echo $invoice->discount ?>" required style="width: 40%">
                                                        </div>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <input type="hidden" name="grand_total" class="grand_total" value="<?php echo $invoice->grand_total ?>">
                                                    <th style="border-top:0px"><strong><?php echo trans('total') ?>: </strong></th>
                                                    <td class="text-right" style="border-top:0px"><span id="grand_total"><?php echo $invoice->grand_total ?></span></td>
                                                </tr>
                                            </table>
                                        </div>


                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mt-2">
                                        <div class="form-group">
                                            <label for="invoice_no" class="control-label"><?php echo trans('note') ?></label>
                                            <textarea name="client_note" class="form-control " rows="2" placeholder="<?php echo trans('note') ?>"><?php echo $invoice->client_note ?></textarea>
                                        </div>

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary float-right"><?php echo trans('save_changes'); ?></button>
                        </div>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                $(function() {
                    $(document).on("click change paste keyup", ".calcEvent", function() {
                        calculate_total();
                    });

                    var max_field = 10;
                    var add_button = $('.add_button');
                    var wrapper = $('.field_wrapper');
                    var html_fields = '<tr class="item"><td><div class="form-group"><a href="javascript:void(0);" class="remove_button btn btn-sm btn-danger" title="Remove field"><i class="fa fa-minus"></i></a></div></td> <td> <div class="form-group"> <input type="text" name="product_description[]" class="form-control calcEvent" id="product_description" placeholder="Description" required> </div> </td> <td> <div class="form-group"> <input type="text" name="quantity[]" value="1" class="form-control calcEvent quantity" id="quantity" placeholder="" required> </div> </td> <td> <div class="form-group"> <input type="text" name="price[]" class="form-control calcEvent price" id="price" placeholder="" required> </div> </td> <td> <div class="form-group"> <input type="text" name="tax[]" class="form-control calcEvent tax" id="tax" placeholder="" required> </div> </td> <td> <input type="hidden" name="total[]" class="form-control calcEvent item_total" placeholder="" required><strong class="item_total">0.00</strong> </td> </tr>';

                    var x = 1; // 

                    $(add_button).click(function() {
                        if (x < max_field) {
                            x++;
                            $(wrapper).append(html_fields);
                        }

                    });

                    $(wrapper).on('click', '.remove_button', function(e) {
                        e.preventDefault();
                        $(this).closest('tr').remove(); //Remove field html
                        x--; //Decrement field counter
                    });

                });








                //---------------------------------------------------------------
                function calculate_total() {

                    var sub_total = 0;
                    var total = 0;
                    var amountDue = 0;
                    var total_tax = 0;
                    var numeric_format = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        currencyDisplay: 'symbol'
                    });

                    var localCurrencySymbol = getCurrencySymbol('id-ID',
                        'IDR');

                    var CurrencySymbolNeedle = new RegExp(localCurrencySymbol,
                        "g");

                    $('tr.item').each(function() {
                        var quantity = parseFloat($(this).find(".quantity").val());
                        var price = parseFloat($(this).find(".price").val());
                        var item_tax = $(this).find(".tax").val();

                        var item_total = parseFloat(quantity * price) > 0 ? parseFloat(quantity * price) : 0;
                        sub_total += parseFloat(price * quantity) > 0 ? parseFloat(price * quantity) : 0;
                        total_tax += parseFloat(price * quantity * item_tax / 100) > 0 ? parseFloat(price * quantity * item_tax / 100) : 0;

                        var amount = numeric_format.format(item_total);

                        //menghilangkan RP
                        // amount = amount.replace(CurrencySymbolNeedle, '').replace(/\s+/g, '');

                        $(this).find('.item_total').text(amount);
                        $(this).find('.item_total').val(item_total.toFixed(0));
                    });

                    var discount = parseFloat($("[name='discount']").val()) > 0 ? parseFloat($("[name='discount']").val()) : 0;
                    total += parseFloat(sub_total + total_tax - discount);

                    var gtotal = numeric_format.format(total);
                    var gsubtotal = numeric_format.format(sub_total);
                    var gtaxtotal = numeric_format.format(total_tax);

                    $('.sub_total').text(gsubtotal);
                    $('.sub_total').val(sub_total.toFixed(0)); // for hidden field

                    $('.total_tax').text(gtaxtotal);
                    $('.total_tax').val(total_tax.toFixed(0)); // for hidden field

                    $('#grand_total').text(gtotal);
                    $('.grand_total').val(total.toFixed(0)); // for hidden field

                }

                function getCurrencySymbol(locale, currency) {
                    return (0).toLocaleString(locale, {
                        style: 'currency',
                        currency: currency,
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }).replace(/\d/g, '').trim();
                }

                var currpage = window.location.href;
                var lasturl = sessionStorage.getItem("last_url");

                if (lasturl == null || lasturl.length === 0 || currpage !== lasturl) {
                    sessionStorage.setItem("last_url", currpage);
                    calculate_total();
                } else {
                    calculate_total();
                }
            </script>

            <?php echo form_close(); ?>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<?php echo $this->endSection() ?>