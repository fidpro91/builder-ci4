<?= $this->extend('themes/header') ?>
<?= $this->section('content') ?>
<!-- jquery block ui-->
<?=script_tag("assets/themes/libs/block-ui/jquery.blockUI.js")?>
<?=script_tag("assets/themes/extra-libs/block-ui/block-ui.js")?>

<!-- toastr plugin -->
<?=script_tag("assets/themes/extra-libs/toastr/dist/build/toastr.min.js")?>
<?=script_tag("assets/themes/extra-libs/toastr/toastr-init.js")?>
<!-- end jquery -->
<h2>
    HALAMAN DOKUMENTASI BUILDER HTML
</h2>
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Basic Material inputs</h4>
        <h6 class="card-subtitle">Just add <code>form-material</code> class to the form that's
            it.</h6>
        <div class="row">
            <div class="col-md-4 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <h4 class="card-title">Block Element</h4>
                                    <p>Block content components.</p>
                                    <button class="btn btn-lg btn-block font-medium btn-outline-success block-card">Block Card</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <h4 class="card-title">Block Whole Page</h4>
                                    <p>Block Whole Page</p>
                                    <button class="btn btn-lg btn-block font-medium btn-outline-danger block-default">Block Page</button>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
        <div class="row">
        <div class="col-md-12">
                        <div class="card overflow-hidden">
							<div class="card-body border-bottom">
								<h4 class="card-title mb-0">Toastr</h4>
							</div>
							<div class="row justify-content-center bg-light p-5">
								<div class="col-md-5">
									<div class="card shadow-sm">
										<div class="p-4">
											<h5>Basic Toastr</h5>
											<button type="button" class="btn btn-lg btn-block btn-outline-success" id="ts-success">Success</button>
											<h5 class="mt-3">Position Toastr</h5>	
			                                <button type="button" class="btn btn-lg btn-block btn-outline-primary" id="pos-top-center">Top Center</button>
											<h5 class="mt-3">With Close Toastr</h5>
											<button type="button" class="btn btn-lg btn-block btn-outline-success" id="close-button">Toast with close button</button>
											<h5 class="mt-3">Animation</h5>
											<button type="button" class="btn btn-lg btn-block btn-outline-primary" id="slide-toast">slideDown - slideUp</button>
										</div>	
									</div>
								</div>
							</div>
						</div>
                    </div>
        </div>
        <div class="row">
        <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Error Message
                                    <small>(Click on image)</small></h4>
                                <img src="<?=base_url()?>/assets/themes/images/alert/alert5.png" alt="alert" class="img-fluid model_img"
                                    id="model-error-icon">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Confirm Dialog <small>(Click on image)</small></h4>
                            <img src="<?=base_url()?>/assets/themes/images/alert/model.png" alt="alert" class="img-fluid model_img"
                                id="sa-confirm">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Success Message <small>(Click on image)</small></h4>
                            <img src="<?=base_url()?>/assets/themes/images/alert/alert3.png" alt="alert" class="img-fluid model_img"
                                id="sa-success">
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<!-- plugin sweat alert -->
<?=script_tag("assets/themes/libs/sweetalert2/dist/sweetalert2.all.min.js")?>
<?=script_tag("assets/themes/extra-libs/sweetalert2/sweet-alert.init.js")?>
<?= $this->endSection() ?>