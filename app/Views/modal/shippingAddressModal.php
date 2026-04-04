
    <!-- Modal -->
    <div class="modal fade"
        id="addNewAddressModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="addNewAddressLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">

                <div class="modal-body">

                    <form action="#" method="post" id="addShippingAddressForm">

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="shipping_name" id="shipping_name" >
                            <input type="hidden" name="shipping_address_id" id="shipping_address_id" value="">
                            <div id="shipping_nameError" class="text-danger invalid-feedback"></div>
                        </div>
                           
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control w-100" id="shipping_phone" name="shipping_phone" >
                            <div id="shipping_phoneError" class="text-danger invalid-feedback"></div>
                        </div>
                        
                        <div class="form-group">
                            <label>Address Line 1</label>
                            <textarea class="form-control" name="shipping_address" id="shipping_address" rows="3" ></textarea>
                            <div id="shipping_addressError" class="text-danger invalid-feedback"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" class="form-control" name="shipping_city" id="shipping_city" >
                                    <div id="shipping_cityError" class="text-danger invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>State</label>
                                    <input type="text" class="form-control" name="shipping_state" id="shipping_state" >
                                    <div id="shipping_stateError" class="text-danger invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label>Pincode</label>
                                    <input type="text" class="form-control" name="shipping_pincode" id="shipping_pincode" >
                                    <div id="shipping_pincodeError" class="text-danger invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Country</label>
                                    <input type="text" class="form-control" name="shipping_country" id="shipping_country" >
                                    <div id="shipping_countryError" class="text-danger invalid-feedback"></div>
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary" id="loginBtn">
                                Save Address
                            </button>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>


