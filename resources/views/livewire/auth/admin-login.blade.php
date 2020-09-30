<div>
    <div class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
            <a href="/"><b>{{env('APP_NAME')}}</b></a>
            </div>
            <!-- /.login-logo -->
            <div class="card">
              <div class="card-body login-card-body">
                <p class="login-box-msg">Admin Sign in</p>

                <form wire:submit.prevent='submit'>
                  <div class="input-group mb-3">
                    <input type="text" class="form-control @error('form.username') is-invalid @enderror" wire:model='form.username'
                    placeholder="Username" autocomplete="form.username" autofocus>
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-user"></span>
                      </div>
                    </div>
                    @error('form.username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>

                  <div class="input-group mb-3">
                    <input type="password" class="form-control @error('form.password') is-invalid @enderror" wire:model='form.password'
                    placeholder="Password" required>
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                      </div>
                    </div>
                    @error('form.password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                  <div class="row">
                    <div class="col-8">
                      <div class="icheck-primary">
                        <input type="checkbox" {{ old('remember') ? 'checked' : '' }} wire:model='remember'>
                        <label for="remember">
                          Remember Me
                        </label>
                      </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                      <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                    <!-- /.col -->
                  </div>
                </form>

                {{-- <div class="social-auth-links text-center mb-3">
                  <p>- OR -</p>
                  <a href="#" class="btn btn-block btn-primary">
                    <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                  </a>
                  <a href="#" class="btn btn-block btn-danger">
                    <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                  </a>
                </div> --}}
                <!-- /.social-auth-links -->

                <p class="mb-1">
                    <a class="btn btn-link" href="{{ route('login') }}">
                        {{ __('Login as User') }}
                    </a>
                </p>
                {{-- <p class="mb-0">
                  <a href="register.html" class="text-center">Register a new membership</a>
                </p> --}}
              </div>
              <!-- /.login-card-body -->
            </div>
          </div>
        </div>
</div>
