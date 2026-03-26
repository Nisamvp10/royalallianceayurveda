<?= view('frontend/inc/header') ?>
	<div class="page-header bg-section dark-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<!-- Page Header Box Start -->
					<div class="page-header-box">
						<h1 class="text-anime-style-3" data-cursor="-opaque">Surgeon Profile

                         </h1>
						<nav class="wow fadeInUp">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#">home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Surgeon Profile</li>
                     

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
            <div class="row">
                <div class="col-lg-12">
                    <!-- Page Team Single Box Start -->
				    <div class="page-team-single-box">
                        <!-- Team Member Info Box Start -->
                        <div class="team-member-info-box">
                            <!-- Team Member Image Start -->
                            <div class="team-member-image">
                                <figure class="image-anime reveal">
                                    <img src="<?=base_url('public/assets/template/images/dr1.jpg') ?>" alt="">
                                </figure>
                            </div>
                            <!-- Team Member Image End -->

                            <!-- Team Member Content Start -->
                            <div class="team-member-content">
                                <!-- Member Content Header Start -->
                                <div class="section-title">
                                    <h3 class="wow fadeInUp">Expert Orthopedic & Joint
                                        Replacement</h3>
                                    <h2 class="text-anime-style-3" data-cursor="-opaque">Dr. Ram Sudhan Subramaniyan</h2>
                                    <p class="wow fadeInUp" data-wow-delay="0.2s">Associate Prof. Dr. Ram Sudhan Subramaniyan is a specialist in Sports surgeries and joint reconstruction with a special interest in "joint preservation" of the Hip, shoulder, and knee. He is a pioneer in Hip arthroscopy and preservation in Kerala. He is a notable alumnus of Annamalai University and graduated with a medical degree from Rajah Muthiah Medical College and Hospital (now, Government Medical College, Cuddalore, state of Tamil Nadu), class of 2004. He pursued his postgraduation in orthopaedic surgery from Government Medical College, Kozhikode under Kerala University of Health Sciences (KUHS) and DNB Orthopaedics in Medical Trust Hospital, Ernakulam (State of Kerala) from the National Board.</p>
                                    <p class="wow fadeInUp" data-wow-delay="0.2s">Associate Prof. Dr. Ram Sudhan Subramaniyan is a specialist in Sports surgeries and joint reconstruction with a special interest in "joint preservation" of the Hip, shoulder, and knee. He is a pioneer in Hip arthroscopy and preservation in Kerala. He is a notable alumnus of Annamalai University and graduated with a medical degree from Rajah Muthiah Medical College and Hospital (now, Government Medical College, Cuddalore, state of Tamil Nadu), class of 2004. He pursued his postgraduation in orthopaedic surgery from Government Medical College, Kozhikode under Kerala University of Health Sciences (KUHS) and DNB Orthopaedics in Medical Trust Hospital, Ernakulam (State of Kerala) from the National Board.</p>

                                </div>
                                <!-- Member Content Header End -->
                            
                            </div>
                            <!-- Team Member Content End -->
                        </div>
                        <!-- Team Member Info Box End -->

                        <!-- Team Member About Start -->
                        <div class="team-member-about">
                            <!-- Section Title Start -->
                            <div class="section-title">
                                <p class="wow fadeInUp" data-wow-delay="0.2s">
                                    Over the course of his extensive academic and professional experience of more than a decade, he has treated several patients and given hope in their lives to regain their career and confidence which can be witnessed from the patient's endorsements. He is a passionate researcher in the sector, and his extensive expertise has earned him significant honors, including over 20 national and international publications and countless podium presentations across the globe. In addition, to handling several research projects as a research associate affiliated with the nation's prominent medical and biotechnology institutions including the National Institute of Technology (NIT), he currently serves as the research head of the Orthopaedic Research and Certification Academy (ORCA) as well.


                                </p>
                            </div>
                            <!-- Section Title End -->
                             
                         
                        </div> 
                        <!-- Team Member About End -->

                      
                    </div>
                    <!-- Page Team Single Box End -->

                    <div class="marquee-wrapper">
                        <div class="marquee-track">
                            <?php
                            if(!empty($expertise)) {
                                foreach($expertise as $expertise) {
                                ?>
                                    <div class="img"><img src="<?=validImg($expertise['image']) ?>" alt="image"></div>
                                <?php
                                }
                            }?>
                           
                           
                        
                           <!-- ... add more duplicates if needed ... -->
                        </div>
                     </div>
                </div>
            </div>
        </div>
    </div>


    <div class="our-approach bg-section">
        <div class="container">
            <div class="row section-row align-items-center">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title section-title-center">
                        <h3 class="wow fadeInUp">Doctor's Profile</h3>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">Academic Qualifications
                        </h2>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>

            <div class="row align-items-center">
                <div class="col-lg-12">
                     <div class="service-enhance-item-list">
                    <?php
                    if(!empty($data)) {
                        foreach($data as $qualifications) {
                        ?>
                         <!-- Service Expert Item Start -->
                        <div class="service-enhance-item wow fadeInUp">
                            <div class="icon-box">
                                <?=$qualifications['note'];?>
                            </div>
                            <div class="service-enhance-item-content">
                                <h3><?=$qualifications['title'];?></h3>
                                <p><?=$qualifications['description'];?></p>
                            </div>
                        </div>
                        <!-- Service Expert Item End -->
                        <?php
                        }
                    }?>
                        <!-- Service Expert Item End -->
                    </div>


                </div>
             
            </div>
        </div>
    </div>



    <div class="page-service-single">
        <div class="container">
            <div class="row section-row align-items-center">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title section-title-center">
                        <h3 class="wow fadeInUp">Doctor's Profile</h3>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">Research Works & Publications

                        </h2>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>
            <div class="row">
               
                <div class="col-lg-12">
                    <div class="skcol">

                        <div class="faq-accordionsk" id="accordion2">                            
                            <!-- FAQ Item Start -->
                            <div class="accordion-item wow fadeInUp">
                                <h2 class="accordion-header" id="heading11">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse11" aria-expanded="true" aria-controls="collapse11">
                                        Publications & Book chapters
                                    
                                    </button>
                                </h2>
                                <div id="collapse11" class="accordion-collapse collapse" aria-labelledby="heading11" data-bs-parent="#accordion2">
                                    <div class="accordion-body">
                                        <p>
                                            Ram Sudhan S, MuthuKumar Subramanian, Rajkumar V, Fardeen Shariff, Linish Baalan R, & Sharat Balemane. Systemic Juvenile Idiopathic Arthritis and arthralgia - can it be diagnosed early within the window period? – An observation of serum biomarkers and analysis with other differential conditions in children. 61(4), 191–201.


                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- FAQ Item End -->

                            <!-- FAQ Item Start -->
                            <div class="accordion-item wow fadeInUp" data-wow-delay="0.2s">
                                <h2 class="accordion-header" id="heading12">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse12" aria-expanded="false" aria-controls="collapse12">
                                        Presentations(International / National)
                                                                        </button>
                                </h2>
                                <div id="collapse12" class="accordion-collapse collapse" aria-labelledby="heading12" data-bs-parent="#accordion2">
                                    <div class="accordion-body">
                                        <p>Pulseless Limbs in Polytrauma, Always A Vascular Injury? Think of an Arterial Variation.

                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- FAQ Item End -->

                        
                         
                         
                        </div>

                    </div>
                    <!-- Service Single Content End -->
                </div>
            </div>
        </div>
    </div>

                    
<?= view('frontend/inc/footerLink') ?>

    
</body>

</html>