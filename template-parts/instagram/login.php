<div class="card-features" id="before_submit">
    <form id="new-login-form" data-id="followers">
        <div class="title mb-4">
            <h3>Login Instagram</h3>
            <div class="sub-title">Login dengan akun Instagram kamu</div>
        </div>
        <div class="form-group">
            <label class="form-label" for="username_ig">Username</label>
            <input type="text" class="form-control" id="username_ig" aria-describedby="username_ig" autocomplete="on"
                placeholder="isi dengan username ig kamu" required>
        </div>
        <div class="form-group">
            <label class="form-label" for="password_ig">Password</label>
            <input type="password" class="form-control" id="password_ig" aria-describedby="password_ig"
                placeholder="isi dengan password ig kamu" required>
        </div>
        <div class="cf-turnstile" data-sitekey="<?php echo get_turnstile()['site_key']; ?>"></div>
        <div class="mt-3 small">By clicking the button below, you agree to the Terms
            conditions.
        </div>
        <div class="button_wrap">
            <button type="submit" id="ig_login_btn" class="primary_btn">
                Login
            </button>
            <a class="secondary_btn" href="http://wa.link/jsk7qt">
                Beli Followers
            </a>
        </div>
    </form>
</div>