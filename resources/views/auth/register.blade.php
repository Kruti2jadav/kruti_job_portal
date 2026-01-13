<x-layout>
<x-slot name="content">
<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="login-card">

            <h4 class="login-title">Create Account</h4>

            <form method="POST" action="/register">
                @csrf  
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter name" value={{old('name')}}><span class="text-danger">@error('name'){{$message}}@enderror</span>
                </div> 

                <div class="mb-3">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control" placeholder="Enter email" value={{old('email')}}>
                     <span class="text-danger">@error('email'){{$message}}@enderror</span>
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter password" value={{old('password')}}>
                    <span class="text-danger">@error('password'){{$message}}@enderror</span>
                </div> 

                <div class="mb-3">
                    <label>Role</label>
                    <select name="role" class="form-control" value={{old('role')}}>
                        <option value="">Select Role</option>
                        <option value="candidate">Candidate</option>
                        <option value="recruiter">Recruiter</option>
                        <option value="hrreviewer">HR Reviewer</option>
                         <option value="techreviewer">Tech Reviewer</option>
                    </select>
                    <span class="text-danger">@error('role'){{$message}}@enderror</span>
                </div> 

                <button class="btn btn-primary w-100">Register</button>
            </form>

        </div>
    </div>
</div>
</x-slot>
</x-layout>
