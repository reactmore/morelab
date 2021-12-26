<div class="page-aside-left">
    <div class="email-menu-list ">
        <a href="<?php echo admin_url() ?>settings/general" class="list-group-item  border-0 <?php echo ($active_tab == 'general_settings') ? 'active text-white' : 'text-dark'; ?>"><i class="fa fa-cog pr-2 font-18 align-middle "></i><?php echo trans('general_settings') ?></a>
        <a href="<?php echo admin_url() ?>settings/email" class="list-group-item  border-0 <?php echo ($active_tab == 'email_settings') ? 'active text-white' : 'text-dark'; ?>"><i class="fa fa-cog pr-2 font-18 align-middle "></i><?php echo trans('email_settings') ?></a>
        <a href="<?php echo admin_url() ?>settings/social" class="list-group-item  border-0 <?php echo ($active_tab == 'social_settings') ? 'active text-white' : 'text-dark'; ?>"><i class="fa fa-cog pr-2 font-18 align-middle "></i><?php echo trans('social_login_configuration') ?></a>
        <a href="<?php echo admin_url() ?>settings/visual" class="list-group-item  border-0 <?php echo ($active_tab == 'visual_settings') ? 'active text-white' : 'text-dark'; ?>"><i class="fa fa-cog pr-2 font-18 align-middle "></i><?php echo trans('visual_settings') ?></a>
        <a href="<?php echo admin_url() ?>settings/cache-system" class="list-group-item  border-0 <?php echo ($active_tab == 'cahce_system') ? 'active text-white' : 'text-dark'; ?>"><i class="fa fa-cog pr-2 font-18 align-middle "></i><?php echo trans('cache_system') ?></a>

    </div>
</div>