<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/admin/plugins/file-manager/fileicon.css" />
<?php if (!empty($load_images)) {
    $images = model('imagesModel')->get_images(60);
    echo view("admin/file-manager/_file_manager_image", ['images' => $images]);
} ?>