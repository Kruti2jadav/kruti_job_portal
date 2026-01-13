<x-layout>
    <x-slot name="content">
    <div class="row justify-content-center mt-5">
        <div class="col-md-5">
            <div class="login-card">
                <div class="login-title">Login to JobPortal</div>
@if(session('success'))
    <div id="flash-message" class="alert alert-success">
        {{ session('success') }}
    </div>
@endif 
@if(session('error'))
    <div id="flash-message" class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif 
<script> 
    setTimeout(function() {
        let flash = document.getElementById('flash-message');
        if(flash){ 
            setTimeout(() => flash.remove(), 1000);
        }
    }, 2000);
</script> 
<form method="POST" action="/login">
                    @csrf 
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Enter username">
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter password">
                    </div> 
                    <button class="btn btn-primary w-100">Login</button>
                </form>
                 <!-- Register link -->
                <div class="text-center mt-3">
                    <span class="text-muted">New to JobPortal?</span>
                    <a href="/register-form" class="register-link"> Register</a>
                </div>
            </div>
        </div>
    </div>
</x-slot>
</x-layout>
