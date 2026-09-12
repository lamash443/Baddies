@php
    // /login is not a standalone page — login is handled via #authModal on the homepage.
    // Redirect any visitor that lands here back to the homepage.
    header('Location: ' . url('/'));
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="refresh" content="0;url={{ url('/') }}">
  <title>Redirecting…</title>
</head>
<body>
  <script>window.location.replace("{{ url('/') }}");</script>
</body>
</html>
