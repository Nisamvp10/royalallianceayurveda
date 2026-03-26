<?= view('frontend/inc/header') ?>
	<div class="page-header bg-section dark-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<!-- Page Header Box Start -->
					<div class="page-header-box">
						<h1 class="text-anime-style-3" data-cursor="-opaque">Purpose and Values

                         </h1>
						<nav class="wow fadeInUp">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#">home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Purpose and Values</li>
                     

							</ol>
						</nav>
					</div>
					<!-- Page Header Box End -->
				</div>
			</div>
		</div>
	</div>



    <div class="page-team-single">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <!-- Our Approach Content Start -->
                    <div class="our-approach-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">our Hospital</h3>
                            <h2 class="text-anime-style-3" data-cursor="-opaque">Purpose and Values</h2>
                        </div>
                        <!-- Section Title End -->

                        <!-- Our Approach Body Start -->
                        <div class="our-approach-body wow fadeInUp" data-wow-delay="0.4s">
                            <!-- Mission Vision Item Start -->
                            <div class="mission-vison-item">
                                <div class="icon-box">
                                    <img src="<?=base_url('public/assets/template/images/icon-mission.svg')?>" alt="">
                                </div>
                                <div class="mission-vison-content">
                                    <h3>our mission</h3>
                                  <p><?=getappdata('mission') ?></p>
                                </div>
                            </div>
                            <!-- Mission Vision Item End -->

                            <!-- Mission Vision Item Start -->
                            <div class="mission-vison-item">
                                <div class="icon-box">
                                    <img src="<?=base_url('public/assets/template/images/icon-vision.svg')?>" alt="">
                                </div>
                                <div class="mission-vison-content">
                                    <h3>our vision</h3>
                                    <p><?=getappdata('vision') ?></p>
                                </div>
                            </div>

                            <div class="mission-vison-item">
                                <div class="icon-box">
                                    <img src="<?=base_url('public/assets/template/images/icon-mission.svg')?>" alt="">
                                </div>
                                <div class="mission-vison-content">
                                    <h3>Goals</h3>
                                    <p>Accessibility, Availability and Affordability of neoteric healthcare system and science which is inclusive to all across nations.</p>
                                </div>
                            </div>
                            <!-- Mission Vision Item End -->

                            <!-- Mission Vision Item Start -->
                            <div class="mission-vison-item">
                                <div class="icon-box">
                                    <img src="<?=base_url('public/assets/template/images/icon-vision.svg')?>" alt="">
                                </div>
                                <div class="mission-vison-content">
                                    <h3>Values</h3>
                                   <p><?=getappdata('values') ?></p>
                                </div>
                            </div>
                            <!-- Mission Vision Item End -->
                        </div>
                        <!-- Our Approach Body End -->
                    </div>
                    <!-- Our Approach Content End -->
                </div>
               
            </div>
        </div>
    </div>


<?= view('frontend/inc/footerLink') ?>

    
</body>

</html>