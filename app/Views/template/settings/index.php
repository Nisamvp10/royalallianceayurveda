<?= $this->extend('template/layout/main') ?>

<?= $this->section('content') ?>



<div class="flex items-center justify-between">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between align-items-center mb-0">
            <h1 class="h3 mb-0">Settings</h1>
            <!-- <div>
                        <a href="<?= base_url('dashboard/tasks/create') ?>" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i> New Client
                        </a>
                    </div> -->
        </div>
    </div>
</div><!-- closee titilebar -->

<!-- Tabs on the Left -->
<div class="bg-white rounded-lg shadow-sm overflow-hidden ">
    <div class="d-flex">
        <div class="w-64 border-r border-gray-200 p-4 bg-gray-50">
            <nav class="space-y-1" id="settingsTabs" role="tablist" aria-orientation="vertical">

                <button class="w-full flex items-center space-x-3 px-3 py-2 rounded-md transition-colors  text-primary-700 active" id="general-tab" data-bs-toggle="pill" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true">
                    <span class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building ">
                            <rect width="16" height="20" x="4" y="2" rx="2" ry="2"></rect>
                            <path d="M9 22v-4h6v4"></path>
                            <path d="M8 6h.01"></path>
                            <path d="M16 6h.01"></path>
                            <path d="M12 6h.01"></path>
                            <path d="M12 10h.01"></path>
                            <path d="M12 14h.01"></path>
                            <path d="M16 10h.01"></path>
                            <path d="M16 14h.01"></path>
                            <path d="M8 10h.01"></path>
                            <path d="M8 14h.01"></path>
                        </svg>
                    </span>
                    <span>General</span>
                </button>
                <button class="w-full flex items-center space-x-3 px-3 py-2 rounded-md transition-colors  text-primary-700 " id="terms-tab" data-bs-toggle="pill" data-bs-target="#terms" type="button" role="tab" aria-controls="terms" aria-selected="true">
                    <span class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building ">
                            <rect width="16" height="20" x="4" y="2" rx="2" ry="2"></rect>
                            <path d="M9 22v-4h6v4"></path>
                            <path d="M8 6h.01"></path>
                            <path d="M16 6h.01"></path>
                            <path d="M12 6h.01"></path>
                            <path d="M12 10h.01"></path>
                            <path d="M12 14h.01"></path>
                            <path d="M16 10h.01"></path>
                            <path d="M16 14h.01"></path>
                            <path d="M8 10h.01"></path>
                            <path d="M8 14h.01"></path>
                        </svg>
                    </span>
                    <span>Terms & Condition</span>
                </button>
                 <button class="w-full flex items-center space-x-3 px-3 py-2 rounded-md transition-colors  text-primary-700 " id="refound-tab" data-bs-toggle="pill" data-bs-target="#refound" type="button" role="tab" aria-controls="terms" aria-selected="true">
                    <span class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building ">
                            <rect width="16" height="20" x="4" y="2" rx="2" ry="2"></rect>
                            <path d="M9 22v-4h6v4"></path>
                            <path d="M8 6h.01"></path>
                            <path d="M16 6h.01"></path>
                            <path d="M12 6h.01"></path>
                            <path d="M12 10h.01"></path>
                            <path d="M12 14h.01"></path>
                            <path d="M16 10h.01"></path>
                            <path d="M16 14h.01"></path>
                            <path d="M8 10h.01"></path>
                            <path d="M8 14h.01"></path>
                        </svg>
                    </span>
                    <span>Refound & Cancell</span>
                </button>
                 <button class="w-full flex items-center space-x-3 px-3 py-2 rounded-md transition-colors  text-primary-700 " id="shipping-tab" data-bs-toggle="pill" data-bs-target="#shipping" type="button" role="tab" aria-controls="terms" aria-selected="true">
                    <span class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building ">
                            <rect width="16" height="20" x="4" y="2" rx="2" ry="2"></rect>
                            <path d="M9 22v-4h6v4"></path>
                            <path d="M8 6h.01"></path>
                            <path d="M16 6h.01"></path>
                            <path d="M12 6h.01"></path>
                            <path d="M12 10h.01"></path>
                            <path d="M12 14h.01"></path>
                            <path d="M16 10h.01"></path>
                            <path d="M16 14h.01"></path>
                            <path d="M8 10h.01"></path>
                            <path d="M8 14h.01"></path>
                        </svg>
                    </span>
                    <span>Shipping Policy</span>
                </button>

                <!-- privacy -->
                 <button class="w-full flex items-center space-x-3 px-3 py-2 rounded-md transition-colors  text-primary-700 " id="privacy-tab" data-bs-toggle="pill" data-bs-target="#privacy" type="button" role="tab" aria-controls="terms" aria-selected="true">
                    <span class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building ">
                            <rect width="16" height="20" x="4" y="2" rx="2" ry="2"></rect>
                            <path d="M9 22v-4h6v4"></path>
                            <path d="M8 6h.01"></path>
                            <path d="M16 6h.01"></path>
                            <path d="M12 6h.01"></path>
                            <path d="M12 10h.01"></path>
                            <path d="M12 14h.01"></path>
                            <path d="M16 10h.01"></path>
                            <path d="M16 14h.01"></path>
                            <path d="M8 10h.01"></path>
                            <path d="M8 14h.01"></path>
                        </svg>
                    </span>
                    <span>Privacy Policy</span>
                </button>

                <?php if ($userRole == 1) { ?>
                    <!-- Email Config Tab -->
                    <button class="w-full flex items-center space-x-3 px-3 py-2 rounded-md transition-colors hover:bg-primary-50 hover:text-primary-700" id="titileConfig-tab" data-bs-toggle="pill" data-bs-target="#titileConfig" type="button" role="tab" aria-controls="titileConfig" aria-selected="false">
                        <span class="flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-type">
                                <polyline points="4 7 4 4 20 4 20 7" />
                                <line x1="9" y1="20" x2="15" y2="20" />
                                <line x1="12" y1="4" x2="12" y2="20" />
                            </svg>

                        </span>
                        <span>Titiles Config</span>
                    </button>

                    <!-- Email Config Tab -->
                    <button class="w-full flex items-center space-x-3 px-3 py-2 rounded-md transition-colors hover:bg-primary-50 hover:text-primary-700" id="email-tab" data-bs-toggle="pill" data-bs-target="#emailtab" type="button" role="tab" aria-controls="titileConfig" aria-selected="false">
                        <span class="flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail ">
                                <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                            </svg>
                        </span>
                        <span>Email Config</span>
                    </button>
                <?php } ?>
            </nav>
        </div>
        <!-- Content -->
        <div class="flex-1 p-6">
            <div class="space-y-6 tab-content">

                <div class="tab-pane fade fade show active mt-0" id="general" role="tabpanel" aria-labelledby="general-tab">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">General Settings</h2>
                    <form class="space-y-4" id="settingsForm" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Business Name</label>
                            <input type="text" name="company_name" value="<?= getappdata('company_name') ?>" id="company_name" class="border rounded px-3 py-2 w-full" placeholder="Enter business name">
                            <div class="invalid-feedback" id="company_name_error"></div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <input type="text" name="address" value="<?= getappdata('address') ?>" id="address" class="border rounded px-3 py-2 w-full" placeholder="Enter address">
                            <div class="invalid-feedback" id="address_error"></div>
                            <div class="grid grid-cols-2 mt-2 gap-4">
                                <div>
                                    <input type="text" value="<?= getappdata('city') ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-300" placeholder="City" name="city">
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <input type="text" value="<?= getappdata('state') ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:right:2 focus:ring-primary-300" placeholder="State" name="state">
                                    <input type="text" value="<?= getappdata('zip_code') ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:right:2 focus:ring-primary-300" placeholder="Zip Code" name="zip_code">

                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="text" value="<?= getappdata('phone') ?>" name="phone" id="phone" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-300" placeholder="Country code with Number">
                            <div class="invalid-feedback" id="phone_error"></div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" value="<?= getappdata('email') ?>" class="border rounded px-3 py-2 w-full" name="email" id="email" placeholder="Enter email">
                            <div class="invalid-feedback" id="email_error"></div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Change Logo</label>
                            <div class="flex">
                                <input type="file" name="file" class="border rounded px-3 py-2 w-full">
                                <img src="<?= base_url(getappdata('applogo')) ?>" class="ml-2 w-10 h-10 rounded-full">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tax</label>
                            <input type="text" value="<?= getappdata('tax') ?>" name="tax" id="tax" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-300" placeholder="Country code with Number">
                            <div class="invalid-feedback" id="tax_error"></div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Minimum Order Amount</label>
                            <input type="number" min="0" value="<?= getappdata('minimum_order_amount') ?>" name="minimum_order_amount" id="minimum_order_amount" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-300" placeholder="Enter Minimum Order Amount">
                            <div class="invalid-feedback" id="minimum_order_amount_error"></div>
                        </div>

                        <div class="grid grid-cols-4 mt-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Counter Title 1</label>
                                <input type="text" value="<?= getappdata('ct1') ?>" class="border rounded px-3 py-2 w-full" name="ct1" id="ct1" placeholder="Counter Title">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Counter 1</label>
                                <input type="number" value="<?= getappdata('c1') ?>" class="border rounded px-3 py-2 w-full" name="c1" id="c1" placeholder="Enter Count Number">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Counter Title 2</label>
                                <input type="text" value="<?= getappdata('ct2') ?>" class="border rounded px-3 py-2 w-full" name="ct2" id="ct2" placeholder="Counter Title 2 ">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Counter 2</label>
                                <input type="number" value="<?= getappdata('c2') ?>" class="border rounded px-3 py-2 w-full" name="c2" id="c2" placeholder="Enter Count Number 2">
                            </div>
                        </div>
                        <!--  -->
                        <div class="grid grid-cols-4 mt-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Counter Title 3</label>
                                <input type="text" value="<?= getappdata('ct3') ?>" class="border rounded px-3 py-2 w-full" name="ct3" id="ct3" placeholder="Counter Title 3">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Counter 3</label>
                                <input type="number" value="<?= getappdata('c3') ?>" class="border rounded px-3 py-2 w-full" name="c3" id="c3" placeholder="Enter Count Number 3">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Counter Title 4</label>
                                <input type="text" value="<?= getappdata('ct4') ?>" class="border rounded px-3 py-2 w-full" name="ct4" id="ct4" placeholder="Counter Title 4 ">
                                <div class="invalid-feedback" id="email_error"></div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Counter 4</label>
                                <input type="number" value="<?= getappdata('c4') ?>" class="border rounded px-3 py-2 w-full" name="c4" id="c4" placeholder="Enter Count Number 4">
                                <div class="invalid-feedback" id="email_error"></div>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 mt-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Mission</label>
                                <textarea class="border rounded px-3 py-2 w-full" name="mission" id="mission" placeholder="Mission"><?= getappdata('mission') ?></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Vision</label>
                                <textarea class="border rounded px-3 py-2 w-full" name="vision" id="vision" placeholder="Vision"><?= getappdata('vision') ?></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Values</label>
                                <textarea class="border rounded px-3 py-2 w-full" name="values" id="values" placeholder="Values"><?= getappdata('values') ?></textarea>
                            </div>

                        </div>
                        <div class="grid grid-cols-2 mt-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Meta Keywords</label>
                                <textarea class="border rounded px-3 py-2 w-full" name="meta_keywords" id="meta_keywords" placeholder="Mission"><?= getappdata('meta_keywords') ?></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                                <textarea class="border rounded px-3 py-2 w-full" name="meta_description" id="meta_description" placeholder="Vision"><?= getappdata('meta_description') ?></textarea>
                            </div>
                        </div>

                        <!--  -->
                        <div class="flex items-center justify-between">
                        <div class="form-check form-switch">
                            <input class="form-check-input" <?= (getappdata('site_mode') == 'on' ? 'checked' : ''); ?> name="site_mode" type="checkbox" id="flexSwitchCheckChecked">
                            <label class="form-check-label" for="flexSwitchCheckChecked">Site Mode</label>
                        </div>
                         <div class="form-check form-switch">
                            <input class="form-check-input" <?= (getappdata('order_status_mail_notification') == 'on' ? 'checked' : ''); ?> name="order_status_mail_notification" type="checkbox" id="order_status_mail_notification">
                            <label class="form-check-label" for="order_status_mail_notification">Order Status Mail Notification</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" <?= (getappdata('invoice_type') == 'on' ? 'checked' : ''); ?> name="invoice_type" type="checkbox" id="invoice_type">
                            <label class="form-check-label" for="invoice_type">Invoice Auto Download</label>
                        </div>
                        </div>

                        <div class="flex justify-end"><button id="submitBtn" class="bg-primary-600 rounded hover:bg-primary-700 text-white px-4 py-2 rounded-md flex items-center transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-save mr-1">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                    <polyline points="7 3 7 8 15 8"></polyline>
                                </svg>Save Changes</button></div>
                    </form>
                </div>
                  <div class="tab-pane fade fade  mt-0" id="terms" role="tabpanel" aria-labelledby="terms-tab">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Terms & Conditions</h2>
                    <form class="space-y-4" id="refoundForm" enctype="multipart/form-data">
                        <div>
                            <div class="form-group ">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2"> Terms & Conditions</label>
                                <textarea id="termsInput" rows="10" cols="15" name="termsInput" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter Description...."><?= getappdata('termsInput') ?></textarea>
                                <div class="invalid-feedback" id="terms_error"></div>
                            </div>

                        </div>
                           <div class="flex justify-end">
                            <button id="submitBtn" class="bg-primary-600 rounded hover:bg-primary-700 text-white px-4 py-2 rounded-md flex items-center transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-save mr-1">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                    <polyline points="7 3 7 8 15 8"></polyline>
                                </svg>Save Changes</button></div>
                    </form>
                </div>
                <div class="tab-pane fade fade  mt-0" id="privacy" role="tabpanel" aria-labelledby="privacy-tab">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Privacy Policy</h2>
                    <form class="space-y-4" id="privacyForm" enctype="multipart/form-data">
                        <div>
                            <div class="form-group ">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2"> Privacy Policy </label>
                                <textarea id="privacyInput" rows="10" cols="15" name="privacyInput" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter Description...."><?= getappdata('privacyInput') ?></textarea>
                                <div class="invalid-feedback" id="terms_error"></div>
                            </div>

                        </div>
                           <div class="flex justify-end">
                            <button id="submitBtn" class="bg-primary-600 rounded hover:bg-primary-700 text-white px-4 py-2 rounded-md flex items-center transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-save mr-1">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                    <polyline points="7 3 7 8 15 8"></polyline>
                                </svg>Save Changes</button></div>
                    </form>
                </div>
                <!-- Refound -->
                    <div class="tab-pane fade fade  mt-0" id="refound" role="tabpanel" aria-labelledby="refound-tab">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Refound & Cancellation</h2>
                    <form class="space-y-4" id="refoundForm" enctype="multipart/form-data">
                        <div>
                            <div class="form-group ">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2"> Refound & Cancellation </label>
                                <textarea id="refoundInput" rows="10" cols="15" name="refoundInput" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter Description...."><?= getappdata('refoundInput') ?></textarea>
                                <div class="invalid-feedback" id="terms_error"></div>
                            </div>

                        </div>
                           <div class="flex justify-end">
                            <button id="submitBtn" class="bg-primary-600 rounded hover:bg-primary-700 text-white px-4 py-2 rounded-md flex items-center transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-save mr-1">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                    <polyline points="7 3 7 8 15 8"></polyline>
                                </svg>Save Changes</button></div>
                    </form>
                </div>
                 <!-- Refound -->
                    <div class="tab-pane fade fade  mt-0" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Shipping Policy</h2>
                    <form class="space-y-4" id="shippingForm" enctype="multipart/form-data">
                        <div>
                            <div class="form-group ">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2"> Shipping Policy </label>
                                <textarea id="shippingInput" rows="10" cols="15" name="shippingInput" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter Description...."><?= getappdata('shippingInput') ?></textarea>
                                <div class="invalid-feedback" id="terms_error"></div>
                            </div>

                        </div>
                           <div class="flex justify-end">
                            <button id="submitBtn" class="bg-primary-600 rounded hover:bg-primary-700 text-white px-4 py-2 rounded-md flex items-center transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-save mr-1">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                    <polyline points="7 3 7 8 15 8"></polyline>
                                </svg>Save Changes</button></div>
                    </form>
                </div>


                <?php if ($userRole == 1) { ?>

                    <!-- Email Config Tab Content -->
                    <div class="tab-pane fade mt-0" id="emailtab" role="tabpanel" aria-labelledby="email-tab">

                        <h2 class="text-lg font-medium text-gray-800 mb-4 ">Email Configuration</h2>
                        <form class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">SMTP Host</label>
                                <input type="text" class="border rounded px-3 py-2 w-full" placeholder="smtp.example.com">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">SMTP Port</label>
                                <input type="text" class="border rounded px-3 py-2 w-full" placeholder="587">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">SMTP Username</label>
                                <input type="text" class="border rounded px-3 py-2 w-full" placeholder="user@example.com">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">SMTP Password</label>
                                <input type="password" class="border rounded px-3 py-2 w-full" placeholder="Password">
                            </div>
                            <button class="bg-primary-600 text-white px-4 py-2 rounded hover:bg-primary-800">Save</button>
                        </form>
                    </div>
                    <!-- title tab -->
                    <!-- Email Config Tab Content -->
                    <div class="tab-pane fade mt-0" id="titileConfig" role="tabpanel" aria-labelledby="titileConfig-tab">

                        <h2 class="text-lg font-medium text-gray-800 mb-4 ">Title Configuration</h2>
                        <form class="space-y-4" id="labelForm" method="post" action="<?= base_url('settings/save_titles') ?>">
                            <?= csrf_field(); ?>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Industries</label>
                                <input class="border rounded px-3 py-2 w-full" type="text" name="industries" value="<?= getappdata('industries') ?>" placeholder="Industries">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Blog</label>
                                <input class="border rounded px-3 py-2 w-full" type="text" name="blog" value="<?= getappdata('blog') ?>" placeholder="Blog">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">category</label>
                                <input class="border rounded px-3 py-2 w-full" type="text" name="category" value="<?= getappdata('category') ?>" placeholder="Category">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Services / Products</label>
                                <input class="border rounded px-3 py-2 w-full" type="text" name="services" value="<?= getappdata('services') ?>" placeholder="Services">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Achievements</label>
                                <input class="border rounded px-3 py-2 w-full" type="text" name="achievements" value="<?= getappdata('achievements') ?>" placeholder="Achievements">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Expertise</label>
                                <input class="border rounded px-3 py-2 w-full" type="text" name="expertise" value="<?= getappdata('expertise') ?>" placeholder="Expertise">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Partnership</label>
                                <input class="border rounded px-3 py-2 w-full" type="text" name="partnership" value="<?= getappdata('partnership') ?>" placeholder="Partnership">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Product Management</label>
                                <input class="border rounded px-3 py-2 w-full" type="text" name="product_management" value="<?= getappdata('product_management') ?>" placeholder="Product Management">
                            </div>
                             <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Clients</label>
                                <input class="border rounded px-3 py-2 w-full" type="text" name="clients" value="<?= getappdata('clients') ?>" placeholder="Clients">
                            </div>

                            <div class="dark-light-toogle-container">
                                <button class="bg-primary-600 text-white px-4 py-2 rounded hover:bg-primary-800">Save</button>
                        </form>
                    </div>

            </div>
        <?php } ?>
        </div>
        <!-- close content -->
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts'); ?>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.js"></script> -->

<script>
    $(document).ready(function() {
        // Configure toastr


        $('#settingsForm').on('submit', function(e) {
            e.preventDefault();

            // Reset previous error states
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').empty();

            // Disable submit button
            $('#submitBtn').prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
            );
            var formData = new FormData(this);
            $.ajax({
                url: '<?= base_url('settings/save') ?>',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#settingsForm')[0].reset();
                    } else {
                        if (response.errors) {
                            // Display validation errors
                            $.each(response.errors, function(field, message) {
                                $('#' + field).addClass('is-invalid');
                                $('#' + field + '_error').text(message);
                                toastr.error(message);
                            });
                        } else {
                            toastr.error(response.message);
                        }
                    }
                },
                error: function() {
                    toastr.error('An error occurred while saving settings');
                },
                complete: function() {
                    // Re-enable submit button
                    $('#submitBtn').prop('disabled', false).text('Save Settings');
                }
            });
        });
    });

     $(document).ready(function() {
        // Configure toastr


        $('#termsForm,#privacyForm,#refoundForm,#shippingForm').on('submit', function(e) {
            e.preventDefault();

            // Reset previous error states
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').empty();

            // Disable submit button
            $('#submitBtn').prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
            );
            var formData = new FormData(this);
            $.ajax({
                url: '<?= base_url('settings/termssave') ?>',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#termsForm')[0].reset();
                    }
                },
                error: function() {
                    toastr.error('An error occurred while saving settings');
                },
                complete: function() {
                    // Re-enable submit button
                    $('#submitBtn').prop('disabled', false).text('Save Settings');
                }
            });
        });
    });

    $('#labelForm').on('submit', function(e) {
        e.preventDefault();

        // Reset previous error states
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').empty();

        // Disable submit button
        $('#submitBtn').prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
        );
        var formData = new FormData(this);
        $.ajax({
            url: '<?= base_url('settings/titles-save') ?>',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    $('#labelForm')[0].reset();
                } else {
                    if (response.errors) {
                        // Display validation errors
                        $.each(response.errors, function(field, message) {
                            $('#' + field).addClass('is-invalid');
                            $('#' + field + '_error').text(message);
                            toastr.error(message);
                        });

                    } else {
                        toastr.error(response.message);
                    }
                }
            },
            error: function() {
                toastr.error('An error occurred while saving settings');
            },
            complete: function() {
                // Re-enable submit button
                $('#submitBtn').prop('disabled', false).text('Save Settings');
            }
        });
    });

    function clientTitle(select) {
        const clientId = select.value;
        if (!clientId) return;

        $.ajax({
            url: '<?= base_url('settings/get_titles_by_client') ?>',
            type: "POST",
            data: {
                client_id: clientId
            },
            dataType: "json",
            success: function(response) {
                $('input[name="titles[about]"]').val(response.about ?? '');
                $('input[name="titles[menu]"]').val(response.menu ?? '');
                $('input[name="titles[products]"]').val(response.products ?? '');
                $('input[name="titles[contact]"]').val(response.contact ?? '');
            },
            error: function() {
                alert("Failed to load labels for the selected client.");
            }
        });
    }

    tinymce.init({
        selector: '#termsInput, #privacyInput,#refoundInput,#shippingInput',
        plugins: 'lists link image table code',
        toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image | code',
        height: 300,
        menubar: false,
        branding: false,

        style_formats: [{
                title: 'Paragraph',
                block: 'p'
            },
            {
                title: 'Heading 3',
                block: 'h3'
            },
            {
                title: 'Heading 4',
                block: 'h4'
            },
            {
                title: 'Heading 5',
                block: 'h5'
            },
            {
                title: 'Heading 6',
                block: 'h6'
            }
        ],

        toolbar_mode: 'wrap',
        menubar: 'format',
    })
</script>


<?= $this->endSection() ?>