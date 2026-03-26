<?php
$userData = session()->get('user_data');
if (!empty($userData)){
    $userRole = $userData['role'];
    $sessionData = session()->get('user_permissions') ?? [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= getappdata('company_name') ?? '' ?></title>
    <link rel="stylesheet" href="<?=base_url('public/assets/src/bootstrap.min.css');?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.40.0/dist/apexcharts.css">
    <!-- select -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="<?=base_url('public/assets/js/fullcalendar.js');?>"></script>
<style>
:root {
  --color-primary-600:37 99 235 ;
  --color-secondary: blue;/*--esc($clientColorSecondary) */;
}
.wrapModal{
    z-index:9999!important;
}
</style>

    <link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('public/assets/src/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/src/daterangepicker.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/src/output.css') ?>">
    


    
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <a href="<?= base_url('dashboard') ?>">
                <?= (getappdata('applogo') ? '<img class="rounded-full border border-1 border-solid shadow mr-2 w-10 h-10" src="'.base_url(getappdata('applogo')).'">' :  '<i class="">'.substr(getappdata('company_name'), 0, 1) ).'</i>'; ?>
                <span><?= getappdata('company_name') ?></span>
            </a>
        </div>
        <div class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == 'dashboard' ? 'active' : '' ?>" href="<?= base_url('dashboard') ?>">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <?php
                if(haspermission('','view_banner')) {  ?>
                <li class="nav-item">
                    <a class="nav-link <?= strpos(uri_string(), 'admin/banner') === 0 ? 'active' : '' ?>" href="<?= base_url('admin/banner') ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"     viewBox="0 0 24 24" fill="none" stroke="currentColor"     stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-banner">  <rect x="3" y="6" width="18" height="12" rx="2" ry="2"></rect></svg>
                    <span>Banner </span>
                    </a>
                </li>
                
                <?php 
                }
                //expertise
                if(haspermission('','view_expertise')) {  ?>
                <li class="nav-item">
                    <a class="nav-link <?= strpos(uri_string(), 'admin/'.slugify(getappdata('expertise'))) === 0  ? 'active' : '' ?>" href="<?= base_url('admin/'.slugify(getappdata('expertise'))) ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-award">  <circle cx="12" cy="8" r="7"></circle>  <path d="M8.21 13.89 7 23l5-3 5 3-1.21-9.11"></path></svg>
                    <span class="capitalize"><?= getappdata('expertise') ?></span>
                    </a>
                </li>
                <?php 
                }

                if(haspermission('','view_partnership')) {  ?>
                <li class="nav-item">
                    <a class="nav-link <?= strpos(uri_string(), 'admin/'.slugify(getappdata('partnership'))) === 0  ? 'active' : '' ?>" href="<?= base_url('admin/'.slugify(getappdata('partnership'))) ?>">
                    <svg fill="#000000" viewBox="0 0 32 32" id="icon" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><defs><style>.cls-1{fill:none;}</style></defs><title>partnership</title><path d="M8,9a4,4,0,1,1,4-4A4,4,0,0,1,8,9ZM8,3a2,2,0,1,0,2,2A2,2,0,0,0,8,3Z" transform="translate(0)"></path><path d="M24,9a4,4,0,1,1,4-4A4,4,0,0,1,24,9Zm0-6a2,2,0,1,0,2,2A2,2,0,0,0,24,3Z" transform="translate(0)"></path><path d="M26,30H22a2,2,0,0,1-2-2V21h2v7h4V19h2V13a1,1,0,0,0-1-1H20.58L16,20l-4.58-8H5a1,1,0,0,0-1,1v6H6v9h4V21h2v7a2,2,0,0,1-2,2H6a2,2,0,0,1-2-2V21a2,2,0,0,1-2-2V13a3,3,0,0,1,3-3h7.58L16,16l3.42-6H27a3,3,0,0,1,3,3v6a2,2,0,0,1-2,2v7A2,2,0,0,1,26,30Z" transform="translate(0)"></path><rect id="_Transparent_Rectangle_" data-name="&lt;Transparent Rectangle&gt;" class="cls-1" width="32" height="32"></rect></g></svg>
                    <span class="capitalize"><?= getappdata('partnership') ?></span>
                    </a>
                </li>
                <?php 
                 }
                 if(haspermission('','feedback')) {  ?>
                <li class="nav-item">
                    <a class="nav-link <?= strpos(uri_string(), 'admin/feedback') === 0  ? 'active' : '' ?>" href="<?= base_url(relativePath: 'admin/feedback') ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square-text">   <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>  <line x1="8" y1="9" x2="16" y2="9"/>  <line x1="8" y1="13" x2="14" y2="13"/></svg>
                    <span>Feedback</span>
                    </a>
                </li>
                <?php 
                }
                
                 if(haspermission('','supperadmin')) { ?>
                <li class="nav-item disp">
                    <a class="nav-link <?= strpos(uri_string(), 'appointments') === 0 && strpos(uri_string(), 'appointments') === false ? 'active' : '' ?>" href="<?= base_url('appointments') ?>">
                      <svg xmlns="https://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar "><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>
                        <span>Appoinments</span>
                    </a>
                </li>
                <?php }

                if(haspermission('','achievements')) { ?>
                    <li class="nav-item disp">
                        <a class="nav-link <?= strpos(uri_string(), 'admin/'.slugify(getappdata('achievements'))) === 0  ? 'active' : '' ?>" href="<?= base_url('admin/'.slugify(getappdata('achievements'))) ?>">
                        <svg xmlns="https://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar "><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>
                            <span class="capitalize"><?= getappdata('achievements') ?></span>
                        </a>
                    </li>
                <?php }
                  if(haspermission('','industries')) { ?>
                    <li class="nav-item disp">
                        <a class="nav-link <?= strpos(uri_string(), 'admin/'.slugify(getappdata('industries'))) === 0  ? 'active' : '' ?>" href="<?= base_url('admin/').slugify(getappdata('industries')) ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-factory">    <path d="M2 20a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2 3h10a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2h-4v-4h-8v4H2z"></path><path d="M10 6h4"></path><path d="M12 2v4"></path></svg>
                            <span><?= getappdata('industries') ?></span>
                        </a>
                    </li>
                <?php }
                  if(haspermission('','careers')) { ?>
                    <li class="nav-item disp">
                        <a class="nav-link <?= strpos(uri_string(), 'admin/careers') === 0  ? 'active' : '' ?>" href="<?= base_url('admin/careers') ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-factory">    <path d="M2 20a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2 3h10a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2h-4v-4h-8v4H2z"></path><path d="M10 6h4"></path><path d="M12 2v4"></path></svg>
                            <span>Careers</span>
                        </a>
                    </li>
                <?php }

                if(haspermission('','view_clients')) { ?>
                    <li class="nav-item disp">
                        <a class="nav-link <?= strpos(uri_string(), 'admin/clients') === 0  ? 'active' : '' ?>" href="<?= base_url('admin/'.slugify(getappdata('clients'))) ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"   class="lucide lucide-newspaper" aria-hidden="true">  <path d="M4 19h16a2 2 0 0 0 2-2V5H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z"></path>  <path d="M22 5v14a2 2 0 0 1-2 2H4"></path>  <path d="M16 8h2"></path>  <path d="M16 12h2"></path>  <path d="M16 16h2"></path>  <path d="M8 8h6v8H8z"></path></svg>
                            <span><?=ucwords(getappdata('clients'))?></span>
                        </a>
                    </li>
                <?php }
                   if(haspermission('','news')) { ?>
                    <li class="nav-item disp">
                        <a class="nav-link <?= strpos(uri_string(), 'admin/news') === 0  ? 'active' : '' ?>" href="<?= base_url('admin/news') ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"   class="lucide lucide-newspaper" aria-hidden="true">  <path d="M4 19h16a2 2 0 0 0 2-2V5H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z"></path>  <path d="M22 5v14a2 2 0 0 1-2 2H4"></path>  <path d="M16 8h2"></path>  <path d="M16 12h2"></path>  <path d="M16 16h2"></path>  <path d="M8 8h6v8H8z"></path></svg>
                            <span>News</span>
                        </a>
                    </li>
                <?php }
                if(haspermission('','blog')) { ?>
                    <li class="nav-item disp">
                        <a class="nav-link capitalize <?= strpos(uri_string(), 'admin/'.slugify(getappdata('blog'))) === 0  ? 'active' : '' ?>" href="<?= base_url('admin/'.slugify(getappdata('blog'))) ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"   class="lucide lucide-newspaper" aria-hidden="true">  <path d="M4 19h16a2 2 0 0 0 2-2V5H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z"></path>  <path d="M22 5v14a2 2 0 0 1-2 2H4"></path>  <path d="M16 8h2"></path>  <path d="M16 12h2"></path>  <path d="M16 16h2"></path>  <path d="M8 8h6v8H8z"></path></svg>
                            <span><?= getappdata('blog') ?></span>
                        </a>
                    </li>
                    <?php
                } 
                
                if(haspermission('','category')) { ?>
                    <li class="nav-item disp">
                        <a class="nav-link capitalize <?= strpos(uri_string(), 'admin/'.slugify(getappdata('category'))) === 0  ? 'active' : '' ?>" href="<?= base_url('admin/'.slugify(getappdata('category'))) ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-tags me-2" aria-hidden="true">  <path d="M2 10V2h8l12 12-8 8L2 10z"/>   <path d="M7 7h.01"/> </svg>

                            <span><?= getappdata('category') ?></span>
                        </a>
                    </li>
                    <?php
                } 
                if(haspermission('','service')) { ?>
                    <li class="nav-item disp">
                        <a class="nav-link capitalize <?= strpos(uri_string(), 'admin/'.slugify(getappdata('services'))) === 0  ? 'active' : '' ?>" href="<?= base_url('admin/'.slugify(getappdata('services'))) ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"     viewBox="0 0 24 24" fill="none" stroke="currentColor"     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"     class="lucide lucide-grid me-2" aria-hidden="true">  <rect x="3" y="3" width="7" height="7"/>  <rect x="14" y="3" width="7" height="7"/>  <rect x="14" y="14" width="7" height="7"/>  <rect x="3" y="14" width="7" height="7"/></svg>
                            <span><?= getappdata('services') ?></span>
                        </a>
                    </li>
                    <?php
                } 
                
                if(haspermission('','view_staff')) {  ?>
                <li class="nav-item">
                    <a class="nav-link <?= strpos(uri_string(), 'admin/staff') === 0 && strpos(uri_string(), 'appointments') === false ? 'active' : '' ?>" href="<?= base_url('admin/staff') ?>">
                    <span class="flex-shrink-0"><svg xmlns="https://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-user "><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="10" r="3"></circle><path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662"></path></svg></span>
                        <span>Staff</span>
                    </a>
                </li>
                
                <?php 
                }?>
                <li class="nav-item">
                    <a class="nav-link <?= strpos(uri_string(), 'admin/coupen-code') === 0 && strpos(uri_string(), 'coupen-codes') === false ? 'active' : '' ?>" href="<?= base_url('admin/coupen-code') ?>">
                    <span class="flex-shrink-0">
                         <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"     viewBox="0 0 24 24" fill="none" stroke="currentColor"     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">        <path d="M2 9a3 3 0 0 1 0 6v1a2 2 0 0 0 2 2h3"></path>        <path d="M22 9a3 3 0 0 0 0 6v1a2 2 0 0 1-2 2h-3"></path>        <rect x="6" y="4" width="12" height="16" rx="2"></rect>        <path d="M9 15l6-6"></path>        <circle cx="9.5" cy="9.5" r=".5"></circle>        <circle cx="14.5" cy="14.5" r=".5"></circle>    </svg>
                    </span>
                        <span>Coupen Code</span>
                    </a>
                </li>
                <?php
                if(haspermission('','investments')) { ?>
                <li class="nav-item hidden">
                    <a class="nav-link <?= strpos(uri_string(), 'admin/products') === 0  ? 'active' : '' ?>" href="<?= base_url('admin/products') ?>">
                    <span class="flex-shrink-0"><svg xmlns="https://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles "><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"></path><path d="M5 3v4"></path><path d="M19 17v4"></path><path d="M3 5h4"></path><path d="M17 19h4"></path></svg></span>
                        <span>Inventory Stock</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= strpos(uri_string(), 'admin/all-products') === 0  ? 'active' : '' ?>" href="<?= base_url('admin/all-products') ?>">
                    <span class="flex-shrink-0"><svg xmlns="https://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles "><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"></path><path d="M5 3v4"></path><path d="M19 17v4"></path><path d="M3 5h4"></path><path d="M17 19h4"></path></svg></span>
                        <span>Add Product</span>
                    </a>
                </li>
                <?php  
                }
                 if(haspermission('','purchase')) { ?>
                <li class="nav-item">
                    <a class="nav-link cursor-pointer <?= strpos(uri_string(), 'admin/inventory') === 0 ? 'active' : '' ?>" href="<?=base_url('admin/inventory');?>" >
                    <span class="flex-shrink-0">
                        <svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package h-4 w-4 mr-3" data-lov-id="src/components/DashboardLayout.tsx:99:16" data-lov-name="item.icon" data-component-path="src/components/DashboardLayout.tsx" data-component-line="99" data-component-file="DashboardLayout.tsx" data-component-name="item.icon" data-component-content="%7B%22className%22%3A%22h-4%20w-4%20mr-3%22%7D"><path d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z"></path><path d="M12 22V12"></path><path d="m3.3 7 7.703 4.734a2 2 0 0 0 1.994 0L20.7 7"></path><path d="m7.5 4.27 9 5.15"></path></svg></span>
                        <span>Product Purchase</span>
                    </a>
                </li>
                <?php 
                 }
                  if(haspermission('','product_management')) { 
                ?>
                 <li class="nav-item">
                    <a class="nav-link <?= strpos(uri_string(), 'admin/'.slugify(getappdata('product_management'))) === 0  ? 'active' : '' ?>" href="<?= base_url('admin/'.slugify(getappdata('product_management'))) ?>">
                    <span class="flex-shrink-0"><svg xmlns="https://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles "><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"></path><path d="M5 3v4"></path><path d="M19 17v4"></path><path d="M3 5h4"></path><path d="M17 19h4"></path></svg></span>
                        <span><?=ucwords(getappdata('product_management'))?></span>
                    </a>
                </li>
                <?php
                }
                if(haspermission('','sales')) { ?>
                <li class="nav-item">
                    <a class="nav-link cursor-pointer <?= strpos(uri_string(), 'admin/sales') === 0 ? 'active' : '' ?>" href="<?=base_url('admin/sales');?>" >
                    <span class="flex-shrink-0">
                        <svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chart-column h-4 w-4 mr-3" data-lov-id="src/components/DashboardLayout.tsx:99:16" data-lov-name="item.icon" data-component-path="src/components/DashboardLayout.tsx" data-component-line="99" data-component-file="DashboardLayout.tsx" data-component-name="item.icon" data-component-content="%7B%22className%22%3A%22h-4%20w-4%20mr-3%22%7D"><path d="M3 3v16a2 2 0 0 0 2 2h16"></path><path d="M18 17V9"></path><path d="M13 17V5"></path><path d="M8 17v-3"></path></svg>
                    </span>
                        <span>Sales</span>
                    </a>
                </li>
                <?php 
                 }
                if(haspermission('','view_supplier')) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= strpos(uri_string(), 'admin/supplier') === 0 ? 'active' : '' ?>" href="<?= base_url('admin/supplier') ?>">
                    <span class="flex-shrink-0"><svg xmlns="https://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users "><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg></span>
                        <span>Supplier</span>
                    </a>
                </li>
                <?php
                 } if(haspermission('','reports')) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= strpos(uri_string(), 'admin/reports') === 0 ? 'active' : '' ?>" href="<?= base_url('admin/reports') ?>">
                    <span class="flex-shrink-0"><svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text h-4 w-4 mr-3" data-lov-id="src/components/DashboardLayout.tsx:99:16" data-lov-name="item.icon" data-component-path="src/components/DashboardLayout.tsx" data-component-line="99" data-component-file="DashboardLayout.tsx" data-component-name="item.icon" data-component-content="%7B%22className%22%3A%22h-4%20w-4%20mr-3%22%7D"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path><path d="M10 9H8"></path><path d="M16 13H8"></path><path d="M16 17H8"></path></svg></span>
                        <span>Reports</span>
                    </a>
                </li>
                <?php } ?>
                
                <?php if (hasPermission('','view_branches')): ?>
                <li class="nav-item">
                    <a class="nav-link <?= strpos(uri_string(), 'dashboard/branches') === 0 ? 'active' : '' ?>" href="<?= base_url('dashboard/branches') ?>">
                        <i class="bi bi-shop"></i>
                        <span>Branches</span>
                    </a>
                </li>
                <?php endif; ?>
                
             
                <!-- <li class="nav-item">
                    <a class="nav-link <?= strpos(uri_string(), 'dashboard/notifications') === 0 ? 'active' : '' ?>" href="<?= base_url('notifications') ?>">
                        <i class="bi bi-bell"></i>
                        <span>Notifications</span>
                        <span class="notification-count badge bg-danger rounded-pill ms-auto" id="sidebar-notification-count"></span>
                    </a>
                </li> -->

                 <?php if ($userRole !=1 && hasPermission('','settings') ){  ?>
                    <li class="nav-item">
                    <a class="nav-link <?= strpos(uri_string(), 'settings') === 0 ? 'active' : '' ?>" href="<?= base_url('settings') ?>">
                        <i class="bi bi-gear"></i>
                        <span>Settings</span>
                        <span class="notification-count badge bg-danger rounded-pill ms-auto" id="sidebar-notification-count"></span>
                    </a>
                </li>
                <?php } ?>

                

              
               
                <?php if ($userRole ==1): ?>
                    <!-- nav -->
                     <div class="relative mb-0 nav-item  <?= strpos(uri_string(), 'settings') ||  strpos(uri_string(), 'admin/categories')  === 0 ? 'side-active' : '' ?>" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center w-full   rounded-lg transition-all duration-200 
                                text-gray-700 hover:bg-gray-100">
                            <div class="flex items-center justify-between w-full nav-link ">
                            <div class="flex items-center">
                                <div class="mr-3">
                                  <i class="bi bi-gear"></i>
                                </div>
                                <span class="font-medium">Settings</span>
                            </div>
                            <div :class="{ 'rotate-180': open }" class="transition-transform duration-200">
                                <svg xmlns="https://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-chevron-down text-gray-500">
                                <path d="m6 9 6 6 6-6"></path>
                                </svg>
                            </div>
                            </div>
                        </button>

                        <div class="ml-4 mt-1 space-y-1" x-show="open" x-transition>
                            <a class="flex items-center w-full px-3 py-2 rounded-lg transition-all duration-200 text-sm text-gray-700 hover:bg-gray-100" href="<?= base_url('settings') ?>">
                            Settings
                            </a>
                            <?php endif;
                            if(haspermission('','view_category')) : ?>
                                <a class="flex items-center w-full px-3 py-2 rounded-lg transition-all duration-200 text-sm text-gray-700 hover:bg-gray-100 <?= strpos(uri_string(), 'admin/categories') === 0 ? 'active' : '' ?>" href="<?= base_url('admin/categories') ?>">
                                    <!-- <i class="bi bi-diagram-3"></i> -->
                                    <span>Categories</span>
                                </a>
                            <?php endif;
                            if(haspermission('','view_projects')) : ?>
                                <a class="flex items-center w-full px-3 py-2 rounded-lg transition-all duration-200 text-sm text-gray-700 hover:bg-gray-100 <?= strpos(uri_string(), 'settings/projects') === 0 ? 'active' : '' ?>" href="<?= base_url('settings/projects') ?>">
                                    <!-- <i class="bi bi-diagram-3"></i> -->
                                    <span>Projects</span>
                                </a>
                            <?php endif; ?>

                             <?php
                        if(haspermission('','permissions_view')) { ?>
                            <a class="flex items-center w-full px-3 py-2 rounded-lg transition-all duration-200 text-sm text-gray-700 hover:bg-gray-100 <?= strpos(uri_string(), 'permisions') === 0 ? 'active' : '' ?>" href="<?= base_url('permisions') ?>">
                                <!-- <i class="bi bi-building-lock"></i> -->
                                <span>Permissions</span>
                            </a>
                        <?php } ?>
                        
                        </div>
                        </div>

                     <!-- close nav -->
             
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <div class="toggle-sidebar">
                <i class="bi bi-list"></i>
            </div>
            
            <div class="user-profile ms-auto">
                <div class="dropdown">
                    <a href="#" class="notification-icon dropdown-toggle" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell"></i>
                        <span class="badge" id="notification-badge"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end notification-dropdown" aria-labelledby="notificationDropdown">
                        <div class="notification-header">
                            <span>Notifications</span>
                            <a href="<?= base_url('dashboard/notifications/mark-all-as-read') ?>" class="text-white small">Mark all as read</a>
                        </div>
                        <div class="notification-items" id="notification-items">
                            <div class="text-center py-3">
                                <div class="spinner-border spinner-border-sm text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mb-0 mt-2 small">Loading notifications...</p>
                            </div>
                        </div>
                        <div class="notification-footer">
                            <a href="<?= base_url('notifications') ?>">View all notifications</a>
                        </div>
                    </div>
                </div>
                
                <div class="dropdown profile-dropdown">
                    <a class="dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="avatar me-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: var(--primary-light); color: white; font-weight: 600;">
                            <?= substr(session('user_data')['username'], 0, 1) ?>
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500"><?= session()->get('user_data')['username'] ?></div>
                            <div class="small text-muted"><?= ucfirst(str_replace('_', ' ', session()->get('user_data')['type'])) ?></div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <!-- <li><a class="dropdown-item" href="<?= base_url('/settings/profile') ?>"><i class="bi bi-person me-2"></i> Profile</a></li> -->
                         <?php
                           if(haspermission('','settings')) : ?>
                        <li><a class="dropdown-item" href="<?= base_url('settings') ?>"><i class="bi bi-gear me-2"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <?php endif; ?>
                        <li><a class="dropdown-item" href="<?= base_url('logout') ?>"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-4 md:p-6">
            <div class="space-y-6">
            <?php if (session()->has('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?php if (session()->has('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?= $this->renderSection('content') ?>
            </div>
        </main>
    </div>
    
    <?= view('template/layout/footer_link') ?>
   
    <?= $this->renderSection('scripts') ?>
</body>
</html>