   <!DOCTYPE html>
<html>
<head>
 <title>Job Portal</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
 <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg">
 <div class="container">
  <a class="navbar-brand text-white fw-bold" href="/">JobPortal</a>
  <div>
   <a href="/view-jobs" class="text-white me-3">Job</a> 
   <a href="/candidate/profile" class="text-white me-3">Profile</a> 
    <a href="/logout" class="text-white">Logout</a>
   @if(session('user'))
     <span class="text-white">{{ session('user')['name'] }}</span>
   @else
     <a href="/login" class="text-white">Login</a>
   @endif
  </div>
 </div>
</nav>

<div class="container mt-4">
{{$content}}
</div>

</body>
</html>
