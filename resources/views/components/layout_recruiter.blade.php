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
  <a class="navbar-brand text-white fw-bold" href="#">JobPortal</a>
  <div> 
    <a href="/recruiter-dashboard" class="text-white me-3">Dashboard</a>
   <a href="/leaderboard" class="text-white me-3">Leaderboard</a>
    <a href="/logout" class="text-white">Logout</a>
  </div>
 </div>
</nav>

<div class="container mt-4">
{{$content}}
</div>

</body>
</html>
