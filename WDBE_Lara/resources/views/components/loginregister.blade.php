<!-- Display error/success messages -->
@if(session('error'))
    <div class="alert alert-error" style="background: #fee; color: #c33; padding: 1rem; margin: 1rem; border-radius: 8px;">
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success" style="background: #efe; color: #3c3; padding: 1rem; margin: 1rem; border-radius: 8px;">
        {{ session('success') }}
    </div>
@endif

<!-- Login Modal -->
<div id="loginModal" class="modal-overlay">
    <div class="login-modal">
        <button class="modal-close" onclick="hideLoginModal()">&times;</button>
        <h2 class="login-modal__title">Welcome Back</h2>
        <p class="login-modal__subtitle">Please login to continue</p>
        
        <form class="login-form" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-input" 
                    placeholder="your@email.com" 
                    value="{{ old('email') }}"
                    required
                >
                @error('email')
                    <span style="color: red; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-input" 
                    placeholder="Enter your password" 
                    required
                >
                @error('password')
                    <span style="color: red; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-actions">
                <button type="submit" class="button button--login">Login</button>
            </div>
        </form>
        
        <div class="form-footer">
            <p>Don't have an account? <a href="#" onclick="showRegisterModal(event)">Sign up here</a></p>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div id="registerModal" class="modal-overlay">
    <div class="login-modal">
        <button class="modal-close" onclick="hideRegisterModal()">&times;</button>
        <h2 class="login-modal__title">Create Account</h2>
        <p class="login-modal__subtitle">Join the Vinyl Vibes community</p>
        
        <form class="login-form" action="{{ route('register') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="register-name" class="form-label">Full Name</label>
                <input 
                    type="text" 
                    id="register-name" 
                    name="name" 
                    class="form-input" 
                    placeholder="Your name" 
                    value="{{ old('name') }}"
                    required
                >
                @error('name')
                    <span style="color: red; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="register-email" class="form-label">Email Address</label>
                <input 
                    type="email" 
                    id="register-email" 
                    name="email" 
                    class="form-input" 
                    placeholder="your@email.com" 
                    value="{{ old('email') }}"
                    required
                >
                @error('email')
                    <span style="color: red; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="register-phone" class="form-label">Phone Number</label>
                <input 
                    type="tel" 
                    id="register-phone" 
                    name="phone" 
                    class="form-input" 
                    placeholder="+31 6 12345678" 
                    value="{{ old('phone') }}"
                    required
                >
                @error('phone')
                    <span style="color: red; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="register-password" class="form-label">Password</label>
                <input 
                    type="password" 
                    id="register-password" 
                    name="password" 
                    class="form-input" 
                    placeholder="Create a password" 
                    required
                >
                @error('password')
                    <span style="color: red; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="register-password-confirm" class="form-label">Confirm Password</label>
                <input 
                    type="password" 
                    id="register-password-confirm" 
                    name="password_confirmation" 
                    class="form-input" 
                    placeholder="Confirm your password" 
                    required
                >
                @error('password_confirmation')
                    <span style="color: red; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-actions">
                <button type="submit" class="button button--login">Create Account</button>
            </div>
        </form>
        
        <div class="form-footer">
            <p>Already have an account? <a href="#" onclick="showLoginModal(event)">Login here</a></p>
        </div>
    </div>
</div>

<script>
    function showLoginModal(e) {
        if (e) e.preventDefault();
        document.getElementById('loginModal').classList.add('active');
        document.getElementById('registerModal').classList.remove('active');
        document.body.style.overflow = 'hidden';
    }

    function hideLoginModal() {
        document.getElementById('loginModal').classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    function showRegisterModal(e) {
        if (e) e.preventDefault();
        document.getElementById('registerModal').classList.add('active');
        document.getElementById('loginModal').classList.remove('active');
        document.body.style.overflow = 'hidden';
    }

    function hideRegisterModal() {
        document.getElementById('registerModal').classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside of it
    document.getElementById('loginModal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideLoginModal();
        }
    });

    document.getElementById('registerModal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideRegisterModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideLoginModal();
            hideRegisterModal();
        }
    });

    // Show modals if there are errors (reopen after form submission)
    @if($errors->has('email') || $errors->has('password'))
        document.addEventListener('DOMContentLoaded', function() {
            showLoginModal();
        });
    @endif

    @if($errors->has('name') || $errors->has('phone') || $errors->has('password_confirmation'))
        document.addEventListener('DOMContentLoaded', function() {
            showRegisterModal();
        });
    @endif
</script>