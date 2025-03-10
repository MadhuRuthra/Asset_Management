<x-guest-layout>
    <section class="login-content">
        <div class="row m-0 align-items-center bg-white vh-100">
            <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
                <img src="{{asset('images/auth/02.png')}}" class="img-fluid gradient-main animated-scaleX" alt="images">
            </div>
            <div class="col-md-6 p-0">
                <div class="card card-transparent auth-card shadow-none d-flex justify-content-center mb-0">
                    <div class="card-body">
                        <a href="{{route('dashboard')}}" class="navbar-brand d-flex align-items-center mb-3">
                            <svg width="30" class="text-primary" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="-0.757324" y="19.2427" width="28" height="4" rx="2" transform="rotate(-45 -0.757324 19.2427)" fill="currentColor" />
                                <rect x="7.72803" y="27.728" width="28" height="4" rx="2" transform="rotate(-45 7.72803 27.728)" fill="currentColor" />
                                <rect x="10.5366" y="16.3945" width="16" height="4" rx="2" transform="rotate(45 10.5366 16.3945)" fill="currentColor" />
                                <rect x="10.5562" y="-0.556152" width="28" height="4" rx="2" transform="rotate(45 10.5562 -0.556152)" fill="currentColor" />
                            </svg>
                            <h4 class="logo-title ms-3">{{env('APP_NAME')}}</h4>
                        </a><br>
                        <h2 class="mb-2">Forget Password</h2><br>

                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        <form action="{{ route('forgetpasswordsave') }}" method="POST" name="new_entry_form" id="new_entry_form" onsubmit="" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="floating-label form-group">

                                        <label for="newPassword" class="form-label">New Password</label>
                                        <div class="input-group">
                                            <input id="newPassword" class="form-control" type="password" placeholder="Enter Your New Password" name="new_password" required autocomplete="current-password" minlength="8" maxlength="15">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="toggleNewPassword" style="height:45px;">
                                                    <i class="fa fa-eye"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <span id="newPasswordError" class="text-danger"></span><br>

                                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                                        <div class="input-group">
                                            <input id="confirmPassword" class="form-control" type="password" placeholder="Enter Your Confirm Password" name="confirm_password" required autocomplete="current-password" minlength="8" maxlength="15">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="toggleConfirmPassword" style="height:45px;">
                                                    <i class="fa fa-eye"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <span id="confirmPasswordError" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <button id="submitButton" type="submit" class="btn btn-primary" disabled>Submit</button>
                            <a href="{{ url('/auth/recoverpw') }}">
                                <button type="button" class="btn btn-danger">Cancel</button>
                            </a>
                        </form>
                    </div>
                </div>
                <div class="sign-bg sign-bg-right">
                    <svg width="280" height="230" viewBox="0 0 431 398" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g opacity="0.05">
                            <rect x="-157.085" y="193.773" width="543" height="77.5714" rx="38.7857" transform="rotate(-45 -157.085 193.773)" fill="#3B8AFF" />
                            <rect x="7.46875" y="358.327" width="543" height="77.5714" rx="38.7857" transform="rotate(-45 7.46875 358.327)" fill="#3B8AFF" />
                            <rect x="61.9355" y="138.545" width="310.286" height="77.5714" rx="38.7857" transform="rotate(45 61.9355 138.545)" fill="#3B8AFF" />
                            <rect x="62.3154" y="-190.173" width="543" height="77.5714" rx="38.7857" transform="rotate(45 62.3154 -190.173)" fill="#3B8AFF" />
                        </g>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script>
        const newPasswordInput = document.getElementById('newPassword');
        const confirmPasswordInput = document.getElementById('confirmPassword');
        const newPasswordError = document.getElementById('newPasswordError');
        const confirmPasswordError = document.getElementById('confirmPasswordError');
        const submitButton = document.getElementById('submitButton');

        function validatePassword(input) {
            let valid = true;

            if (input.id === 'newPassword' || input.id === 'confirmPassword') {
                const newPassword = newPasswordInput.value;
                const confirmPassword = confirmPasswordInput.value;

                if (newPassword.length < 8) {
                    newPasswordError.textContent = 'Password strength is low';
                    valid = false;
                } else {
                    newPasswordError.textContent = '';
                }

                if (confirmPassword.length < 8) {
                    confirmPasswordError.textContent = 'Password strength is low';
                    valid = false;
                } else {
                    confirmPasswordError.textContent = '';
                }

                if (newPassword !== confirmPassword) {
                    confirmPasswordError.textContent = 'Passwords do not match';
                    valid = false;
                } else {
                    confirmPasswordError.textContent = '';
                }
            }

            if (newPasswordInput.value.length === 0) {
                newPasswordError.textContent = '';
            }
            if (confirmPasswordInput.value.length === 0) {
                confirmPasswordError.textContent = '';
            }

            submitButton.disabled = !valid || newPasswordInput.value.length === 0 || confirmPasswordInput.value.length === 0;
        }


        newPasswordInput.addEventListener('input', function() {
            validatePassword(newPasswordInput);
        });

        confirmPasswordInput.addEventListener('input', function() {
            validatePassword(confirmPasswordInput);
        });

        document.getElementById('toggleNewPassword').addEventListener('click', function() {
            const password = document.getElementById('newPassword');
            const icon = this.querySelector('i');
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const password = document.getElementById('confirmPassword');
            const icon = this.querySelector('i');
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>

</x-guest-layout>