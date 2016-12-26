<meta charset="UTF-8">
<title>FlixNet</title>
<link href="{{ URL::to('/') }}/css/app.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
<link href="{{ URL::to('/') }}/css/style.css" rel="stylesheet" type="text/css">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Scripts -->
<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>