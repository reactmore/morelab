<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
<?php $ed_langs = array();
$ed_langs[] = array("short" => "ar", "name" => "Arabic");
$ed_langs[] = array("short" => "hy", "name" => "Armenian");
$ed_langs[] = array("short" => "az", "name" => "Azerbaijani");
$ed_langs[] = array("short" => "eu", "name" => "Basque");
$ed_langs[] = array("short" => "be", "name" => "Belarusian");
$ed_langs[] = array("short" => "bn_BD", "name" => "Bengali (Bangladesh)");
$ed_langs[] = array("short" => "bs", "name" => "Bosnian");
$ed_langs[] = array("short" => "bg_BG", "name" => "Bulgarian");
$ed_langs[] = array("short" => "ca", "name" => "Catalan");
$ed_langs[] = array("short" => "zh_CN", "name" => "Chinese (China)");
$ed_langs[] = array("short" => "zh_TW", "name" => "Chinese (Taiwan)");
$ed_langs[] = array("short" => "hr", "name" => "Croatian");
$ed_langs[] = array("short" => "cs", "name" => "Czech");
$ed_langs[] = array("short" => "da", "name" => "Danish");
$ed_langs[] = array("short" => "dv", "name" => "Divehi");
$ed_langs[] = array("short" => "nl", "name" => "Dutch");
$ed_langs[] = array("short" => "en", "name" => "English");
$ed_langs[] = array("short" => "et", "name" => "Estonian");
$ed_langs[] = array("short" => "fo", "name" => "Faroese");
$ed_langs[] = array("short" => "fi", "name" => "Finnish");
$ed_langs[] = array("short" => "fr_FR", "name" => "French");
$ed_langs[] = array("short" => "gd", "name" => "Gaelic, Scottish");
$ed_langs[] = array("short" => "gl", "name" => "Galician");
$ed_langs[] = array("short" => "ka_GE", "name" => "Georgian");
$ed_langs[] = array("short" => "de", "name" => "German");
$ed_langs[] = array("short" => "el", "name" => "Greek");
$ed_langs[] = array("short" => "he", "name" => "Hebrew");
$ed_langs[] = array("short" => "hi_IN", "name" => "Hindi");
$ed_langs[] = array("short" => "hu_HU", "name" => "Hungarian");
$ed_langs[] = array("short" => "is_IS", "name" => "Icelandic");
$ed_langs[] = array("short" => "id", "name" => "Indonesian");
$ed_langs[] = array("short" => "it", "name" => "Italian");
$ed_langs[] = array("short" => "ja", "name" => "Japanese");
$ed_langs[] = array("short" => "kab", "name" => "Kabyle");
$ed_langs[] = array("short" => "kk", "name" => "Kazakh");
$ed_langs[] = array("short" => "km_KH", "name" => "Khmer");
$ed_langs[] = array("short" => "ko_KR", "name" => "Korean");
$ed_langs[] = array("short" => "ku", "name" => "Kurdish");
$ed_langs[] = array("short" => "lv", "name" => "Latvian");
$ed_langs[] = array("short" => "lt", "name" => "Lithuanian");
$ed_langs[] = array("short" => "lb", "name" => "Luxembourgish");
$ed_langs[] = array("short" => "ml", "name" => "Malayalam");
$ed_langs[] = array("short" => "mn", "name" => "Mongolian");
$ed_langs[] = array("short" => "nb_NO", "name" => "Norwegian Bokmål (Norway)");
$ed_langs[] = array("short" => "fa", "name" => "Persian");
$ed_langs[] = array("short" => "pl", "name" => "Polish");
$ed_langs[] = array("short" => "pt_BR", "name" => "Portuguese (Brazil)");
$ed_langs[] = array("short" => "pt_PT", "name" => "Portuguese (Portugal)");
$ed_langs[] = array("short" => "ro", "name" => "Romanian");
$ed_langs[] = array("short" => "ru", "name" => "Russian");
$ed_langs[] = array("short" => "sr", "name" => "Serbian");
$ed_langs[] = array("short" => "si_LK", "name" => "Sinhala (Sri Lanka)");
$ed_langs[] = array("short" => "sk", "name" => "Slovak");
$ed_langs[] = array("short" => "sl_SI", "name" => "Slovenian (Slovenia)");
$ed_langs[] = array("short" => "es", "name" => "Spanish");
$ed_langs[] = array("short" => "es_MX", "name" => "Spanish (Mexico)");
$ed_langs[] = array("short" => "sv_SE", "name" => "Swedish (Sweden)");
$ed_langs[] = array("short" => "tg", "name" => "Tajik");
$ed_langs[] = array("short" => "ta", "name" => "Tamil");
$ed_langs[] = array("short" => "tt", "name" => "Tatar");
$ed_langs[] = array("short" => "th_TH", "name" => "Thai");
$ed_langs[] = array("short" => "tr", "name" => "Turkish");
$ed_langs[] = array("short" => "ug", "name" => "Uighur");
$ed_langs[] = array("short" => "uk", "name" => "Ukrainian");
$ed_langs[] = array("short" => "vi", "name" => "Vietnamese");
$ed_langs[] = array("short" => "cy", "name" => "Welsh"); ?>

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
				<div class="col-xl-4 col-lg-5">
					<div class="card ">
						<div class="card-header">
							<h5 class="card-title text-uppercase">
								<i class="fa fa-language pr-1"></i> <?php echo trans("default_language"); ?>
							</h5>
						</div>
						<div class="card-body">
							<?php echo form_open('admin/language-settings/set-language-post'); ?>
							<!-- include message block -->
							<?php if (!empty(session()->getFlashdata('mes_set_language'))) :
								echo view('admin/includes/_messages');
							endif; ?>

							<div class="form-group mb-3">
								<label><?php echo trans("language"); ?></label>
								<select name="site_lang" class="form-control select2" data-toggle="select2">
									<?php foreach ($languages as $language) : ?>
										<option value="<?php echo $language->id; ?>" <?php echo (selected_lang()->id == $language->id) ? 'selected' : ''; ?>><?php echo $language->name; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<button type="submit" class="btn btn-primary float-right"><?php echo trans('save_changes'); ?></button>
							<?php echo form_close(); ?>
						</div>
						<!-- end card-body -->
					</div>

					<div class="card ">
						<div class="card-header">
							<h5 class="card-title text-uppercase">
								<i class="fa fa-language pr-1"></i> <?php echo trans("add_language"); ?>
							</h5>
						</div>
						<div class="card-body">

							<!-- form start -->
							<?php echo form_open_multipart('admin/language-settings/add-language-post', ['id' => 'form_add_language_post', 'class' => 'custom-validation needs-validation']); ?>

							<?php if (empty(session()->getFlashdata('mes_set_language'))) :
								echo view('admin/includes/_messages');
							endif; ?>



							<div class="form-group mb-3">
								<label><?php echo trans("language_name"); ?><span class="required"> *</span></label>
								<input type="text" class="form-control" name="name" placeholder="<?php echo trans("language_name"); ?>" value="<?php echo old('name'); ?>" required>
								<small>(Ex: English)</small>
							</div>

							<div class="form-group mb-3">
								<label class="control-label"><?php echo trans("short_form"); ?><span class="required"> *</span></label>
								<input type="text" class="form-control" name="short_form" placeholder="<?php echo trans("short_form"); ?>" value="<?php echo old('short_form'); ?>" required>
								<small>(Ex: en)</small>
							</div>

							<div class="form-group mb-3">
								<label class="control-label"><?php echo trans("language_code"); ?><span class="required"> *</span></label>
								<input type="text" class="form-control" name="language_code" placeholder="<?php echo trans("language_code"); ?>" value="<?php echo old('language_code'); ?>" required>
								<small>(Ex: en_us)</small>
							</div>

							<div class="form-group mb-3">
								<label><?php echo trans('language_order'); ?><span class="required"> *</span></label>
								<input type="number" class="form-control" name="language_order" placeholder="<?php echo trans('order'); ?>" value="1" min="1" required>
							</div>

							<div class="form-group mb-3">
								<label><?php echo trans('text_editor_language'); ?><span class="required"> *</span></label>
								<select name="text_editor_lang" class="form-control select2" data-toggle="select2" required>
									<?php foreach ($ed_langs as $ed_lang) : ?>
										<option value="<?php echo $ed_lang['short']; ?>" <?php echo (selected_lang()->short_form == $ed_lang['short']) ? 'selected' : '' ?>><?php echo $ed_lang['name']; ?></option>
									<?php endforeach; ?>
								</select>
							</div>

							<div class="form-group mb-3">
								<div class="row">
									<div class="col-sm-4 col-xs-12">
										<label><?php echo trans('text_direction'); ?><span class="required"> *</span></label>
									</div>
									<div class="col-sm-4 col-xs-12 col-option">
										<input type="radio" id="rb_type_1" name="text_direction" value="ltr" class="square-purple" checked>
										<label for="rb_type_1" class="cursor-pointer"><?php echo trans("left_to_right"); ?></label>
									</div>
									<div class="col-sm-4 col-xs-12 col-option">
										<input type="radio" id="rb_type_2" name="text_direction" value="rtl" class="square-purple">
										<label for="rb_type_2" class="cursor-pointer"><?php echo trans("right_to_left"); ?></label>
									</div>
								</div>
							</div>

							<div class="form-group mb-3">
								<div class="row">
									<div class="col-sm-4 col-xs-12">
										<label><?php echo trans('status'); ?></label>
									</div>
									<div class="col-sm-4 col-xs-12 col-option">
										<input type="radio" name="status" value="1" id="status1" class="square-purple" checked>
										<label for="status1" class="option-label"><?php echo trans('active'); ?></label>
									</div>
									<div class="col-sm-4 col-xs-12 col-option">
										<input type="radio" name="status" value="0" id="status2" class="square-purple">
										<label for="status2" class="option-label"><?php echo trans('inactive'); ?></label>
									</div>
								</div>
							</div>
							<button type="submit" class="btn btn-primary float-right"><?php echo trans('add_language'); ?></button>
							<?php echo form_close(); ?>

						</div>
					</div>
				</div>
				<!-- Right Sidebar -->
				<div class="col-xl-8 col-lg-7">
					<div class="card">
						<div class="card-body">
							<div class="row align-items-center">
								<div class="col-sm-6">
									<h5 class="card-title mb-4 text-uppercase">
										<i class="fa fa-language pr-1"></i> <?php echo trans("languages"); ?>
									</h5>
								</div>

								<div class="col-sm-6">
									<div class="float-right d-none d-md-block mb-4">
										<a href="javascript:void(0)" class="btn btn-primary rounded btn-custom btn-block waves-effect waves-light" data-toggle="modal" data-target="#add-translations"><?php echo trans("add_translations") ?></a>
									</div>
								</div>
							</div>

							<div class="table-responsive">
								<table id="cs_datatable" class="table nowrap w-100 pageResize">
									<thead>
										<tr>
											<th width="20"><?php echo trans('id'); ?></th>
											<th><?php echo trans('language_name'); ?></th>
											<th><?php echo trans('translation'); ?></th>
											<th><?php echo trans('status'); ?></th>
											<th class="th-options"><?php echo trans('options'); ?></th>
										</tr>
									</thead>


									<tbody>
										<?php foreach ($languages as $item) : ?>
											<tr>
												<td><?php echo html_escape($item->id); ?></td>
												<td><?php echo html_escape($item->name); ?></td>
												<td>
													<a href="<?php echo admin_url(); ?>language-settings/translations/<?php echo $item->id; ?>?show=50" class="btn btn-sm btn-success ">
														<i class="ti-bookmark"></i>&nbsp;&nbsp;<?php echo trans('edit_translations'); ?>
													</a>
												</td>
												<td>
													<?php if ($item->status == 1) : ?>
														<span class="badge bg-success text-white"><?php echo trans('active'); ?></span>
													<?php else : ?>
														<span class="badge bg-danger"><?php echo trans('inactive'); ?></span>
													<?php endif; ?>
												</td>
												<td>
													<div class="dropdown btn-group">
														<button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															<i class="mdi mdi-circle-edit-outline mr-2"></i><?php echo trans('select_an_option'); ?>
														</button>
														<div class="dropdown-menu dropdown-menu-animated">
															<a class="dropdown-item" href="<?php echo admin_url(); ?>language-settings/edit-language/<?php echo html_escape($item->id); ?>"><?php echo trans('edit'); ?></a>
															<div class="dropdown-divider"></div>
															<a class="dropdown-item" href="javascript:void(0)" onclick="delete_item('/admin/language-settings/delete-language-post','<?php echo $item->id; ?>','<?php echo trans('confirm_language'); ?>');"><?php echo trans('delete'); ?></a>
														</div>
													</div>


												</td>
											</tr>

										<?php endforeach; ?>
									</tbody>
								</table>

							</div>
						</div> <!-- end card body -->
					</div> <!-- end card -->
				</div>
				<!-- end Col -->
			</div><!-- End row -->
			<!-- /.row (main row) -->
		</div><!-- /.container-fluid -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php echo view('admin/language/_modal_form'); ?>
<?php echo $this->endSection() ?>