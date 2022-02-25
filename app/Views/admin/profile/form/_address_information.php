<?php echo form_open_multipart('admin/profile/address_information_post', ['id' => 'form_safe', 'class' => 'custom-validation needs-validation']); ?>
<input type="hidden" name="id" value="<?php echo html_escape($user->id); ?>">
<input id="newimage_id" type="hidden" class="form-control mb-3" name="newimage_id" value="">
<input type="hidden" id="crsf">
<div class="card">
    <div class="card-header">
        <h5><?php echo trans('address_information') ?></h5>
    </div>
    <div class="card-body">
        <div class="form-group mb-3">
            <label class="control-label"><?php echo trans('address'); ?><span class="required"> *</span></label>
            <div class="row">

                <div id="get_country_container" class="col-12 col-sm-3 m-b-15">
                    <select id="select_countries" name="country_id" class="select2 form-control" onchange="get_states(this.value, 'true');" required>
                        <option value=""><?php echo trans('country'); ?></option>
                        <?php foreach ($countries as $item) :
                            if (!empty($user->country_id)) : ?>
                                <option value="<?php echo $item->id; ?>" <?php echo ($item->id == $user->country_id) ? 'selected' : ''; ?>><?php echo html_escape($item->name); ?></option>
                            <?php else : ?>
                                <option value="<?php echo $item->id; ?>"><?php echo html_escape($item->name); ?></option>
                        <?php endif;
                        endforeach; ?>
                    </select>
                </div>

                <div id="get_states_container" class="col-12 col-sm-3 m-b-15 <?php echo empty($user->state_id) ? 'display-none' : '' ?>">
                    <select id="select_states" name="state_id" class="select2 form-control" onchange="get_cities(this.value, 'true');" required>
                        <option value=""><?php echo trans('state'); ?></option>
                        <?php foreach ($states as $item) :
                            if (!empty($user->state_id)) : ?>
                                <option value="<?php echo $item->id; ?>" <?php echo ($item->id == $user->state_id) ? 'selected' : ''; ?>><?php echo html_escape($item->name); ?></option>
                            <?php else : ?>
                                <option value="<?php echo $item->id; ?>"><?php echo html_escape($item->name); ?></option>
                        <?php endif;
                        endforeach; ?>
                    </select>
                </div>

                <div id="get_cities_container" class="col-12 col-sm-3 m-b-15 <?php echo empty($user->city_id) ? 'display-none' : '' ?>">
                    <select id="select_cities" name="city_id" class="select2 form-control" onchange="update_product_map();">
                        <option value=""><?php echo trans('city'); ?></option>
                        <?php foreach ($cities as $item) :
                            if (!empty($user->city_id)) : ?>
                                <option value="<?php echo $item->id; ?>" <?php echo ($item->id == $user->city_id) ? 'selected' : ''; ?>><?php echo html_escape($item->name); ?></option>
                            <?php else : ?>
                                <option value="<?php echo $item->id; ?>"><?php echo html_escape($item->name); ?></option>
                        <?php endif;
                        endforeach; ?>
                    </select>
                </div>

                <div id="get_zip_container" class="col-12 col-sm-3 m-b-15">
                    <input type="text" name="zip_code" id="zip_code_input" class="form-control form-input" onchange="update_product_map();" value="<?php echo $user->zip_code ?>" placeholder="<?php echo trans("zip_code") ?>" maxlength="90" required>
                </div>
            </div>
        </div>

        <div class="form-group mb-3">

            <textarea class="form-control text-area" id="address_input" name="address" placeholder="<?php echo trans('address'); ?>" onchange="update_product_map();" required><?php echo $user->address ?></textarea>
        </div>

        <button type="submit" name="submit" value="basic" class="btn btn-primary float-right"><?php echo trans('save_changes'); ?></button>

    </div>
</div>

<div class="card text-center">
    <div class="card-body">
        <div class="form-group">
            <div id="map-result">
                <div class="map-container">
                    <iframe src="https://maps.google.com/maps?width=100%&height=600&hl=en&q=<?php echo get_location(user()); ?>&ie=UTF8&t=&z=8&iwloc=B&output=embed&disableDefaultUI=true" id="IframeMap" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                </div>
            </div>
        </div>
    </div> <!-- end card-body -->
</div> <!-- end card -->
<?php echo form_close(); ?>