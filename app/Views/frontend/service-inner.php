<?= view('frontend/inc/header') ?>



	<div class="page-header bg-section dark-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<!-- Page Header Box Start -->
					<div class="page-header-box">
						<h1 class="text-anime-style-3" data-cursor="-opaque"><?=($page ? $page : '');?>
                         </h1>
						<nav class="wow fadeInUp">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#">home</a></li>
								<li class="breadcrumb-item active" aria-current="page"><?=($page ? $page : '');?></li>
                     

							</ol>
						</nav>
					</div>
					<!-- Page Header Box End -->
				</div>
			</div>
		</div>
	</div>



    <div class="page-case-study-single">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <!-- Page Single Sidebar Start -->
                    <div class="page-single-sidebar">
                        <!-- Page Single Category List Start -->
                        <div class="page-single-category-list wow fadeInUp">
                            <h3>Other Services </h3>
                            <ul>
                                <?php
                                if(!empty($titleBar)){
                                    foreach($titleBar as $index => $otherService){
                                    ?>
                                     <li><a href="#ser<?=$index?>"><?=$otherService['serviceTitle'];?></a></li>
                                    <?php
                                    }
                                }?>
                              
                            </ul>
                        </div>
                        <!-- Page Single Category List End -->
                        
                     
                        <!-- Sidebar CTA Box End -->
                    </div>
                    <!-- Page Single Sidebar End -->
                </div>


                <div class="col-lg-8">
                    <?php
                    if(!empty($services)) {
                        foreach($services as $index => $service) {
                        ?>
                          <div id="ser<?=$index;?>" class="case-study-single-content">
                   
                           <!-- Page Single FAQs start -->
                           <div class="page-single-faqs">
                            <!-- Section Title Start -->
                            <div class="section-title">
                                <h2 class="wow fadeInUp" data-wow-delay="0.2s" data-cursor="-opaque"><?=$service['serviceTitle']?></h2>
                            </div>
                            <!-- Section Title End -->
                            
                            <!-- FAQ Accordion Start -->
                            <div class="faq-accordion" id="accordion"><?=$service['description']?></div>
                            <!-- FAQ Accordion End -->
                        </div>


                    
                        <!-- Page Single FAQs End -->
                         <?php
                         $subImageGallery = $service['subImages'];
                         if(!empty($subImageGallery)) {?>

                         <div class="mt-3 mb-3"> 
                        <div class="row d-flex align-items-stretch">
                        
                            <?php 
                            foreach($subImageGallery as $gallery) { ?>
                            <div class="col-lg-4">
                                <div class="sidebar-cta-box  wow fadeInUp" data-wow-delay="0.25s">
                                    <!-- Sidebar CTA Image Start -->
                                    <div class="sidebar-cta-image h-100">
                                        <figure>
                                            <img src="<?= validImg($gallery['image']) ?>" alt="">
                                        </figure>
                                    </div>
                                </div>
                
                            </div>
                            <?php } ?>
                    
                        </div>
                
                        </div>
                        <?php } ?>
                        
                    </div>
                        <?php
                        }
                    }
                    ?>
                   
                </div>

            </div>
        </div>
    </div>              
<?= view('frontend/inc/footerLink') ?>
    
</body>

</html>