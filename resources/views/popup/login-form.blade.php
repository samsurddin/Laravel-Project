<div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="login-main p-3 rounded-bottom mx-0 my-auto bg-white shadow-lg">
                <form class="brand-form theme-form p-3" method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <h4 class="fw-bold">Sign in to account</h4>
                    <p>Enter your email & password to login</p>
                    <div class="form-group mb-2">
                        <label class="col-form-label">Email Address</label>
                        <input class="form-control bg-ash" type="email" name="email" :value="old('email')" required autofocus>
                    </div>
                    <div class="form-input position-relative mb-2">
                        <label class="col-form-label">Password</label>
                        <input class="form-control bg-ash" type="password" name="password" required autocomplete="current-password">
                    </div>
                    <div class="form-group mb-2 d-flex justify-content-between">
                        <div class="checkbox py-2">
                            <input id="remember_me" type="checkbox" name="remember">
                            <label class="text-muted" for="remember_me">Remember password</label>
                        </div>
                        @if (Route::has('password.request'))
                        <div class="forgot-link py-2 ">
                            <a class="underline text-sm" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="form-group mb-2 d-grid">
                        <button class="btn btn-block btn-brand" type="submit">Sign in</button>
                    </div>
                    <p class="mt-4 mb-0">Don't have account?<a class="ms-2 fw-bold" href="{{ route('register') }}">Create Account</a></p>
                </form>
            </div>
        </div>
    </div>
</div>