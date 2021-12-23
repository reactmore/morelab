<ul class="nav nav-tabs" id="tab-locations" role="tablist">
    <li class="nav-item">
        <a href="<?php echo admin_url() ?>locations/country" class="nav-link <?php echo $active_tab === 'country' ? 'active' : '' ?>" id="custom-tabs-country-tab" role="tab" aria-controls="custom-tabs-country" aria-selected="<?php echo $active_tab === 'country' ? 'true' : 'false' ?>"><?php echo trans('country') ?></a>
    </li>
    <li class="nav-item">
        <a href="<?php echo admin_url() ?>locations/state" class="nav-link <?php echo $active_tab === 'state' ? 'active' : '' ?>" id="custom-tabs-state-tab" role="tab" aria-controls="custom-tabs-state" aria-selected="<?php echo $active_tab === 'state' ? 'true' : 'false' ?>"><?php echo trans('state') ?></a>
    </li>
    <li class="nav-item">
        <a href="<?php echo admin_url() ?>locations/city" class="nav-link <?php echo $active_tab === 'city' ? 'active' : '' ?>" id="custom-tabs-city-tab" role="tab" aria-controls="custom-tabs-city" aria-selected="<?php echo $active_tab === 'city' ? 'true' : 'false' ?>"><?php echo trans('city') ?></a>
    </li>
</ul>