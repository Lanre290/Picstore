@if (session('user') == null)
    <script>
        window.location.replace('/signup');
    </script>
@endif