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
                        <rect x="-0.757324" y="19.2427" width="28" height="4" rx="2" transform="rotate(-45 -0.757324 19.2427)" fill="currentColor"/>
                        <rect x="7.72803" y="27.728" width="28" height="4" rx="2" transform="rotate(-45 7.72803 27.728)" fill="currentColor"/>
                        <rect x="10.5366" y="16.3945" width="16" height="4" rx="2" transform="rotate(45 10.5366 16.3945)" fill="currentColor"/>
                        <rect x="10.5562" y="-0.556152" width="28" height="4" rx="2" transform="rotate(45 10.5562 -0.556152)" fill="currentColor"/>
                     </svg>
                     <h4 class="logo-title ms-3">{{env('APP_NAME')}}</h4>
                  </a><br>
                  <h2 class="mb-2">Reset Password</h2><br>

                  <p>Enter your email address and we'll send you an email with instructions to reset your password.</p>
               <x-auth-session-status class="mb-4" :status="session('status')" />

               <!-- Validation Errors -->
               <x-auth-validation-errors class="mb-4" :errors="$errors" />
                  <form action="{{ route('reset_password_check') }}" method="POST" name="new_entry_form" id="new_entry_form" onsubmit="" enctype="multipart/form-data">
                     @csrf
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="floating-label form-group">
                              <label for="email" class="form-label">Email</label>
                              <input type="email" name ="email" class="form-control" id="email" aria-describedby="email" placeholder="Enter Your Mail" required><br>
                              <label for="" class="form-label">OTP</label>
                              <div class="input-group">
                <input id="otp" class="form-control" type="text" placeholder="Enter OTP" name="otp" minlength="6" maxlength="6" required>
                <div class="input-group-append">
                    <span class="input-group-text" id="togglePassword" style="height:45px;">
                        <i class="fa fa-eye"></i>
                    </span>
                </div>
            </div>
            
                           </div>
                           <div id="otp-sent-message" style="display:none; color:green;">
                              <span></span>
                           </div>
                           <div id="otp-error-message" style="display:none; color:red;">
                              <span></span>
                           </div>
                           <br>
                        </div>
                     </div>
                     <button id="submitBtn" class="btn btn-primary" type="submit" disabled>Submit</button>
                     <a href="{{ url('login') }}">
                                <button type="button" class="btn btn-danger">Cancel</button>
                     </a>
                  </form>
               </div>
            </div>               
            <div class="sign-bg sign-bg-right">
               <svg width="280" height="230" viewBox="0 0 431 398" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <g opacity="0.05">
                  <rect x="-157.085" y="193.773" width="543" height="77.5714" rx="38.7857" transform="rotate(-45 -157.085 193.773)" fill="#3B8AFF"/>
                  <rect x="7.46875" y="358.327" width="543" height="77.5714" rx="38.7857" transform="rotate(-45 7.46875 358.327)" fill="#3B8AFF"/>
                  <rect x="61.9355" y="138.545" width="310.286" height="77.5714" rx="38.7857" transform="rotate(45 61.9355 138.545)" fill="#3B8AFF"/>
                  <rect x="62.3154" y="-190.173" width="543" height="77.5714" rx="38.7857" transform="rotate(45 62.3154 -190.173)" fill="#3B8AFF"/>
                  </g>
               </svg>
            </div>
         </div>
      </div>
   </section>



   <script>
        document.getElementById('otp').addEventListener('input', function() {
            var otpInput = document.getElementById('otp');
            var submitBtn = document.getElementById('submitBtn');
            if (otpInput.value.length === 6) {
                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = true;
            }
        });
    </script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#email').on('blur', function () {
                var email = $(this).val();
	
                // Make an AJAX request to send the OTP when the email field is filled
                $.ajax({
                    type: 'POST',
                    url: 'send-otp',
                    data: {
                        _token: '{{ csrf_token() }}',
                        email: email,
                    },
                    success: function(data) {
                        // Assuming your response has 'error' key for error messages
                        if (data.error) {
                           $('#otp-sent-message').hide();
                              $('#otp-error-message').show();
                              $('#otp-error-message').find('span').text(data.error);
                        } else {
                           $('#otp-error-message').hide();
                              $('#otp-sent-message').show();
                              $('#otp-sent-message').find('span').text(data.message);
                        }
                     },
                     error: function(jqXHR, textStatus, errorThrown) {
                        // Handle any unexpected errors
                        $('#otp-error-message').show();
                        $('#otp-error-message').find('span').text('An unexpected error occurred. Please try again.');
                     }
        });
    });
});
</script>

</x-guest-layout>
