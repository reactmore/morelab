<div class="card">
    <div class="card-header">
        <h5><?php echo trans('profile') ?></h5>
    </div>
    <div class="card-body">
        <input type="hidden" name="id" value="<?php echo html_escape($user->id); ?>">
        <div class="form-group mb-3 text-center">
            <div class="row">
                <div class="col-sm-12 col-profile">
                    <center><img data-toggle="modal" data-target="#file_manager_image" data-bs-image-type="input" data-bs-item-id="#userimg" data-bs-input-id="#newimage_id" id="userimg" src="<?php echo get_user_avatar($user->avatar); ?>" alt="" class="img-fluid rounded-circle avatar-lg img-thumbnail"> </center>
                </div>
            </div>
            <h3 class="profile-username text-center"><?php echo html_escape($user->fullname); ?></h3>
            <p class="text-muted text-center"><?php echo html_escape($user->username); ?></p>
        </div>
    </div> <!-- end card-body -->
    <ul class="list-group list-group-flush">
        <a href="<?php echo admin_url(); ?>profile" class="list-group-item list-group-item-action <?php echo $active_tab === 'details' ? 'active' : '' ?>"><?php echo trans('basic_informations') ?></a>
        <a href="<?php echo admin_url(); ?>profile/address-information" class="list-group-item list-group-item-action <?php echo $active_tab === 'address_information' ? 'active' : '' ?>"><?php echo trans('address_information') ?></a>
        <a href="<?php echo admin_url(); ?>profile/change-password" class="list-group-item list-group-item-action <?php echo $active_tab === 'change_password' ? 'active' : '' ?>"><?php echo trans('change_password') ?></a>
        <a href="<?php echo admin_url(); ?>profile/delete-account" class="list-group-item list-group-item-action <?php echo $active_tab === 'delete_account' ? 'active' : '' ?>"><?php echo trans('delete_account') ?></a>

    </ul>
</div> <!-- end card -->