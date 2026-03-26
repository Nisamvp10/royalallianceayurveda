<?= view('frontend/inc/header') ?>

	<div class="page-header bg-section dark-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<!-- Page Header Box Start -->
					<div class="page-header-box">
						<h1 class="text-anime-style-3" data-cursor="-opaque">Knee
                         </h1>
						<nav class="wow fadeInUp">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#">home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Knee</li>
							</ol>
						</nav>
					</div>
					<!-- Page Header Box End -->
				</div>
			</div>
		</div>
	</div>


    
    <!-- Page Services Start -->
    <div class="page-services">
        <div class="container">

        <?php 
        $i=1;
        if(!empty($services)){
            foreach($services as $service) {
            ?>  
                <div class="row section-row align-items-center">
                    <div class="col-lg-12">
                        <!-- Section Title Start -->
                        <div class="section-title section-title-center">
                            <h2 class="text-anime-style-3" data-cursor="-opaque"><?php echo $service['sub_category_title']; ?>
                            </h2>
                        </div>
                        <!-- Section Title End -->
                    </div>
                </div>

                <!-- <div class="row">  -->
                       <?php
                        $items = $service['items'];
                        $it = 0;

                        if (!empty($items)) {
                            foreach ($items as $item) {

                                // OPEN ROW
                                if ($it % 3 == 0) {
                                    echo '<div class="row">';
                                }
                                ?>
                                <div class="col-lg-4 col-md-6">
                                    <!-- Service Item Start -->
                                    <div class="service-item wow fadeInUp">
                                        <div class="service-content">
                                            <div class="service-content-title">
                                                <h2>
                                                    <a href="<?= base_url('service-details/'.$item['slug']); ?>">
                                                        <?= esc($item['title']); ?>
                                                    </a>
                                                </h2>
                                            </div>
                                            <p><?= esc($item['note']); ?></p>
                                        </div>

                                        <div class="service-image">
                                            <a href="<?= base_url('service-details/'.$item['slug']); ?>" data-cursor-text="View">
                                                <figure class="image-anime">
                                                    <img src="<?= validImg($item['image']); ?>" alt="">
                                                </figure>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- Service Item End -->
                                </div>
                                <?php

                                if ($it % 3 == 2) {
                                    echo '</div>';
                                }

                                $it++;
                            }

                            if ($it % 3 != 0) {
                                echo '</div>';
                            }
                        }
                        ?>

                      
                     <!-- </div>  -->

            <?php
            }
        } ?>

    </div>
</div>
    <!-- Page Services End -->


<?= view('frontend/inc/footerLink') ?>