@if (session()->has('status'))
    <div class="status" id="login-success">
        <p>{{ session('status') }}</p>
    </div>
@endif

<script>
    //status animation
    $('.status').animate({bottom: '50px'});

    if ($('.status').is(":visible")) {
        setTimeout(function() {
            $('.status').fadeOut('fast');
        }, 5000);
    }
</script>
