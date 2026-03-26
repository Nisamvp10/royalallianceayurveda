
<div class="body-overlay"></div>

  <!-- Preloader Start -->
  <div class="tj-preloader is-loading">
    <div class="tj-preloader-inner">
      <div class="tj-preloader-ball-wrap">
        <div class="tj-preloader-ball-inner-wrap">
          <div class="tj-preloader-ball-inner">
            <div class="tj-preloader-ball"></div>
          </div>
          <div class="tj-preloader-ball-shadow"></div>
        </div>
        <div id="tj-weave-anim" class="tj-preloader-text">Loading...</div>
      </div>
    </div>
    <div class="tj-preloader-overlay"></div>
  </div>
  <!-- Preloader end -->
   
<!-- back to top start -->
  <div id="tj-back-to-top"><span id="tj-back-to-top-percentage"></span></div>
<!-- back to top end -->

<!-- start: Offcanvas Menu -->
  <div class="tj-offcanvas-area d-none d-lg-block">
    <div class="hamburger_bg"></div>
    <div class="hamburger_wrapper">
      <div class="hamburger_inner">
        <div class="hamburger_top d-flex align-items-center justify-content-between">
          <div class="hamburger_logo">
            <a href="<?=base_url();?>" class="mobile_logo">
              <img src="<?=base_url('public/assets/template/assets/images/logos/techens-logo-2.svg');?>" alt="Logo">
            </a>
          </div>
          <div class="hamburger_close">
            <button class="hamburger_close_btn"><i class="fa-thin fa-times"></i></button>
          </div>
        </div>
        <div class="offcanvas-text">
          <p>Developing personalize our customer journeys to increase satisfaction & loyalty of our expansion
            recognized
            by industry leaders.</p>
        </div>
        <div class="hamburger-infos">
          <h5 class="hamburger-title">Contact Info</h5>
          <div class="contact-info">
            <div class="contact-item">
              <span class="subtitle">Phone</span>
              <a class="contact-link" href="tel:<?=str_replace(' ','',getappdata('phone'));?>"><?=getappdata('phone');?></a>
            </div>
            <div class="contact-item">
              <span class="subtitle">Email</span>
              <a class="contact-link" href="mailto:<?=getappdata('email');?>"><?=getappdata('email');?></a>
            </div>
            <div class="contact-item">
              <span class="subtitle">Location</span>
              <span class="contact-link">2nd Floor, #108, 27th Main Road,Sector 2, HSR Layout, Bengaluru-560102 Karnataka, India</span>
            </div>
          </div>
        </div>
      </div>
      <div class="hamburger-socials">
        <h5 class="hamburger-title">Follow Us</h5>
        <div class="social-links style-3">
          <ul>
            <li><a href="https://www.facebook.com/" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
            </li>
            <li><a href="https://www.instagram.com/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
            </li>
            <li><a href="https://x.com/" target="_blank"><i class="fa-brands fa-x-twitter"></i></a></li>
            <li><a href="https://www.linkedin.com/" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- end: Offcanvas Menu -->
<!-- start: Hamburger Menu -->
  <div class="hamburger-area d-lg-none">
    <div class="hamburger_bg"></div>
    <div class="hamburger_wrapper">
      <div class="hamburger_inner">
        <div class="hamburger_top d-flex align-items-center justify-content-between">
          <div class="hamburger_logo">
            <a href="<?=base_url();?>" class="mobile_logo">
              <img src="<?=base_url('public/assets/template/assets/images/logos/techens-logo-2.svg');?>" alt="Logo">
            </a>
          </div>
          <div class="hamburger_close">
            <button class="hamburger_close_btn"><i class="fa-thin fa-times"></i></button>
          </div>
        </div>
        <div class="hamburger_menu">
          <div class="mobile_menu"></div>
        </div>
        <div class="hamburger-infos">
          <h5 class="hamburger-title">Contact Info</h5>
          <div class="contact-info">
            <div class="contact-item">
              <span class="subtitle">Phone</span>
              <a class="contact-link" href="tel:<?=str_replace(' ','',getappdata('phone'));?>"><?=getappdata('phone');?></a>
            </div>
            <div class="contact-item">
              <span class="subtitle">Email</span>
              <a class="contact-link" href="mailto:<?=getappdata('email');?>"><?=getappdata('email');?></a>
            </div>
            <div class="contact-item">
              <span class="subtitle">Location</span>
              <span class="contact-link">
                <?=getappdata('address');?> <?=getappdata('city');?>-<?=getappdata('zip_code');?> <?=getappdata('zip_code');?>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="hamburger-socials">
        <h5 class="hamburger-title">Follow Us</h5>
        <div class="social-links style-3">
          <ul>
            <li><a href="https://www.facebook.com/" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
            </li>
            <li><a href="https://www.instagram.com/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
            </li>
            <li><a href="https://x.com/" target="_blank"><i class="fa-brands fa-x-twitter"></i></a></li>
            <li><a href="https://www.linkedin.com/" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- end: Hamburger Menu -->


  

  <!-- new Header -->
    <header class="header-area header-1 header-absolute">
    <!-- start: Top Header Area -->
        <div class="top-header-container container-fluid">
      <div class="row">
        <div class="col-md-8 col-8">
          <div class="top-header-contact">
            <a class="contact-link" href="mailto:<?=getappdata('email');?>">
            <h3> <i class="tji-envelop"></i><span><?=getappdata('email');?></span></h3>
          </a>

          <a class="contact-link" href="tel:<?=str_replace(' ','',getappdata('phone'));?>">
            <h3> <i class="tji-phone"></i><span><?=getappdata('phone');?></span></h3>
          </a>
          </div>
        </div>

          <div class="col-md-4 col-4">
          <div class="top-header-right-sec">
            <div class="language-selecter">
              <div class="form-input">
                <div class="tj-nice-select-box language-selector">
                  <div class="tj-select gtranslate_wrapper" >
                    <select name="cfSubject2" class=" d-none">
                      <option value="0">English</option>
                      <option value="1">Arabic</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="dark-light-toogle-container">
              <input class="checkbox" type="checkbox" id="toggle" />
              <label class="toggle" for="toggle">
                <ion-icon class="icon icon--light" name="sunny-outline"></ion-icon>
                <ion-icon class="icon icon--dark" name="moon-outline"></ion-icon>
                <span class="ball"></span>
              </label>
            </div>
          </div>
        </div>
    </div>
  </div>
    <!-- end: Top Header Area -->
    <div class="container-fluid" id="myHeader">
      <div class="row">
        <div class="col-12 no-padding">
          <div class="header-wrapper">
           <!-- site logo -->
            <div class="site_logo">
              <a href="<?=base_url();?>">
              <img src="<?=base_url('public/assets/template/assets/images/logos/techens-logo.svg');?>" alt="Logo Light" class="logo logo-light">
              <img src="<?=base_url('public/assets/template/assets/images/logos/techens-logo-2.svg');?>" alt="Logo Dark" class="logo logo-dark">
              </a>
              </div>
            <!-- header right info -->
            <div class="header-right-item d-none d-lg-inline-flex">
                <!-- navigation -->
                 <!-- navigation -->
                 <div class="menu-area d-none d-lg-inline-flex align-items-center">
                    <nav id="mobile-menu" class="mainmenu">
                        <ul>
                            <li><a href="<?=base_url();?>">Home</a></li>
                            <li><a href="<?=base_url('about-us');?>">About Us</a></li>
                            <li class="has-dropdown"><a href="<?=base_url('service-us');?>">What We Do</a>
                              <ul class="sub-menu header__mega-menu mega-menu mega-menu-pages">
                                <!-- open mega menu -->
                                <li>
                                  <div class="mega-menu-wrapper">

                                    
                                        <?php 
                                        $nav = navigationMenu();
                                        if(!empty($nav)) {
                                          foreach($nav as $cat) {
                                          ?>
                                            <div class="mega-menu-pages-single">
                                              <div class="mega-menu-pages-single-inner">
                                                 <h6 class="mega-menu-title text-capitalize"><?=($cat['category'] ? esc($cat['category']) : '' );?></h6>
                                                <?php
                                                if(!empty($cat['submenu'])) { ?>
                                                <div class="mega-menu-list">
                                                  <?php
                                                  foreach($cat['submenu'] as $srv) {
                                                    ?>
                                                      <a href="<?=($cat['category'] ? base_url('service/'.$srv['slug']) : '' );?>"><?=$srv['title'];?></a>
                                                    <?php
                                                  }?>
                                                </div>
                                                <?php
                                                }?>
                                              </div>
                                            </div>

                                            <?php
                                          }
                                        }
                                        ?>
                                        
                                  </div>
                                </li>
                                <!-- close megamenu -->
                                
                              </ul>
                            </li>
                            <li><a href="<?=base_url('industries');?>">Industries</a></li>
                             <li class="has-dropdown"><a href="#">Resources</a>
                              <ul class="sub-menu">
                                <li><a href="<?=base_url('case-studies');?>">Case Studies</a></li>
                                <li><a href="<?=base_url('news');?>">Press & Media</a></li>
                                <li><a href="<?=base_url('career');?>">Careers</a></li>
                              </ul>
                            </li>
                            <li><a href="<?=base_url('contact-us');?>">Contact Us</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="header-button">
                    <a class="tj-primary-btn" href="#">
                    <span class="btn-text"><span>Log In</span></span>
                    </a>
                </div>
            </div>
            <!-- menu bar -->
            <div class="menu_bar mobile_menu_bar d-lg-none">
              <span></span>
              <span></span>
              <span></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- close new header -->