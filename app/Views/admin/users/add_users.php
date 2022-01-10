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
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>users"><?php echo trans('users') ?></a></li>
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
            <?php echo form_open_multipart('admin/usermanagement/add_user_post', ['id' => 'form',  'class' => 'custom-validation needs-validation']); ?>
            <?php echo $this->include('admin/includes/_messages') ?>
            <input type="hidden" id="crsf">
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="tab-form-add-user" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-basic-tab" data-toggle="pill" href="#custom-tabs-basic" role="tab" aria-controls="custom-tabs-basic" aria-selected="true"><?php echo trans('basic_informations') ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-contact-tab" data-toggle="pill" href="#custom-tabs-contact" role="tab" aria-controls="custom-tabs-contact" aria-selected="false"><?php echo trans('contact') ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-role-tab" data-toggle="pill" href="#custom-tabs-role" role="tab" aria-controls="custom-tabs-role" aria-selected="false"><?php echo trans('role') ?></a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-four-tabContent">

                                <div class="tab-pane fade show active" id="custom-tabs-basic" role="tabpanel" aria-labelledby="custom-tabs-basic-tab">



                                    <div class="form-group mb-3">
                                        <label><?php echo trans("username"); ?><span class="required"> *</span></label>
                                        <input type="text" name="username" class="form-control auth-form-input" placeholder="<?php echo trans("username"); ?>" value="<?php echo old("username"); ?>" data-parsley-required="true" required>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("firstname"); ?><span class="required"> *</span></label>
                                                <input type="text" name="first_name" class="form-control auth-form-input" placeholder="<?php echo trans("firstname"); ?>" value="<?php echo old("first_name"); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("lastname"); ?><span class="required"> *</span></label>
                                                <input type="text" name="last_name" class="form-control auth-form-input" placeholder="<?php echo trans("lastname"); ?>" value="<?php echo old("last_name"); ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="control-label"><?php echo trans('about_me'); ?></label>
                                        <textarea class="form-control text-area" name="about_me" placeholder="<?php echo trans('about_me'); ?>"></textarea>
                                    </div>



                                    <div class="form-group mb-3 float-right">
                                        <a href="javascript: void(0);" class="btn btn-primary  btnNext"><?php echo 'Next'; ?></a>
                                    </div>

                                </div>

                                <div class="tab-pane fade" id="custom-tabs-contact" role="tabpanel" aria-labelledby="custom-tabs-contact-tab">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("mobile_no"); ?></label>
                                                <input type="text" name="mobile_no" class="form-control auth-form-input" placeholder="<?php echo trans("mobile_no"); ?>" value="<?php echo old("mobile_no"); ?>">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("email"); ?><span class="required"> *</span></label>
                                                <input type="email" name="email" class="form-control auth-form-input" placeholder="<?php echo trans("email"); ?>" value="<?php echo old("email"); ?>" parsley-type="email" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="control-label"><?php echo trans('address'); ?></label>
                                        <div class="row">

                                            <div id="get_country_container" class="col-12 col-sm-3 m-b-15">
                                                <select id="select_countries" name="country_id" class="select2 form-control" onchange="get_states(this.value, 'false');">
                                                    <option value=""><?php echo trans('country'); ?></option>
                                                    <?php foreach ($countries as $item) :
                                                        if (!empty($country_id)) : ?>
                                                            <option value="<?php echo $item->id; ?>" <?php echo ($item->id == $country_id) ? 'selected' : ''; ?>><?php echo html_escape($item->name); ?></option>
                                                        <?php else : ?>
                                                            <option value="<?php echo $item->id; ?>"><?php echo html_escape($item->name); ?></option>
                                                    <?php endif;
                                                    endforeach; ?>
                                                </select>
                                            </div>

                                            <div id="get_states_container" class="col-12 col-sm-3 m-b-15 display-none">
                                                <select id="select_states" name="state_id" class="select2 form-control" onchange="get_cities(this.value, 'false');">
                                                    <option value=""><?php echo trans('state'); ?></option>
                                                </select>
                                            </div>

                                            <div id="get_cities_container" class="col-12 col-sm-3 m-b-15 display-none">
                                                <select id="select_cities" name="city_id" class="select2 form-control">
                                                    <option value=""><?php echo trans('city'); ?></option>

                                                </select>
                                            </div>

                                            <div id="get_zip_container" class="col-12 col-sm-3 m-b-15">
                                                <input type="text" name="zip_code" id="zip_code_input" class="form-control form-input" value="" placeholder="<?php echo trans("zip_code") ?>" maxlength="90">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="control-label"><?php echo trans('address'); ?></label>
                                        <textarea class="form-control text-area" name="address" placeholder="<?php echo trans('address'); ?>"></textarea>
                                    </div>

                                    <div class="form-group mb-3 float-right">
                                        <a href="javascript: void(0);" class="btn btn-primary  btnPrevious"><?php echo 'Previous'; ?></a>
                                        <a href="javascript: void(0);" class="btn btn-primary  btnNext"><?php echo 'Next'; ?></a>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="custom-tabs-role" role="tabpanel" aria-labelledby="custom-tabs-role-tab">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("form_password"); ?><span class="required"> *</span></label>
                                                <input type="password" name="password" class="form-control auth-form-input" placeholder="<?php echo trans("form_password"); ?>" value="<?php echo old("password"); ?>" data-parsley-required="true" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("role"); ?><span class="required"> *</span></label>
                                                <select id="role" name="role" class="form-control select2" required>
                                                    <option value=""><?php echo trans("select"); ?></option>
                                                    <?php foreach ($roles as $role) : ?>
                                                        <option value="<?php echo $role->role; ?>"><?php echo $role->role_name; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3 float-right">
                                        <a href="javascript: void(0);" class="btn btn-primary  btnPrevious"><?php echo 'Previous'; ?></a>
                                        <button type="submit" id="single_submit" name="validate" class="btn btn-primary"><?php echo trans('save_changes'); ?></button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer clearfix">
                            <small><strong><span class="required"> *</span> Must be filled</strong></small>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div> <!-- end col -->

        </div>

        <?php echo form_close(); ?>
        <!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<?php echo $this->endSection() ?>