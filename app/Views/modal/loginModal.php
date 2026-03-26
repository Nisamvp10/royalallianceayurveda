
    <!-- Modal -->
    <div class="modal fade"
        id="loginModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="loginModalLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-md p-3" role="document">
            <div class="modal-content">
                <div class="row step p-3" id="step1">
                <div class="modal-header">
                    <h2 class="modal-title w-100 text-center" id="loginModalLabel">Login</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <form action="#" id="loginForm" method="post">

                 
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="username" id="username" required>
                            <div id="usernameError" class="text-danger invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="pwd" id="pwd" required>
                            <div id="pwdError" class="text-danger invalid-feedback"></div>
                        </div>
                    

                        <div class="text-right">
                          
                            <button type="submit" class="btn btn-primary mt-2 mb-2">
                                Login
                            </button>
                            <div class="mt-2">
                                <p>Don't have an account? <a href="#" onclick="nextStep(2)">Create Account</a></p>
                            </div>
                        </div>

                    </form>

                </div>
                </div>
                <div class="row d-none step p-3" id="step2">
                    <div class="modal-header">
                    <h2 class="modal-title w-100 text-center" id="loginModalLabel">Create Account</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                       <form action="#" id="registerForm" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                            <div id="nameError" class="text-danger invalid-feedback"></div>
                        </div>

                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control" name="phone" id="phone" required>
                            <div id="phoneError" class="text-danger invalid-feedback"></div>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                            <div id="emailError" class="text-danger invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                            <div id="passwordError" class="text-danger invalid-feedback"></div>
                        </div>

                        <div class="form-group">
                            <div class="form-check m-0 pl-0">
                                            <div class="d-flex align-items-center justify-content-start gap-2 mt-2">
                                              <input id="reviewcheck" name="reviewcheck" type="checkbox" style="width: 30px;">
                                                <label class="form-check-label" for="reviewcheck">
                                                    I agree to the <span>terms & policy</span>
                                                </label>
                                                <div class="invalid-feedback" id="reviewcheckError"></div>
                                            </div>
                                        </div>
                        </div>
                    

                        <div class="text-right">
                          
                            <button type="submit" class="btn btn-primary">
                                Create Account
                            </button>
                            <div class="mt-2">
                                <p>Already have an account? <a href="#" onclick="nextStep(1)">Login</a></p>
                            </div>
                        </div>

                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>


