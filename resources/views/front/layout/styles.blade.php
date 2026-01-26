<script>
        WebFontConfig = {
            google: {
                families: ['Open+Sans:300,400,600,700,800', 'Poppins:300,400,500,600,700,800', 'Oswald:300,400,500,600,700,800']
            }
        };
        (function(d) {
            var wf = d.createElement('script'),
                s = d.scripts[0];
            wf.src = 'front/js/webfont.js';
            wf.async = true;
            s.parentNode.insertBefore(wf, s);
        })(document);
    </script>

    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{ asset('front/css/bootstrap.min.css') }}">

    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{ asset('front/css/demo4.min.css') }}">
     <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('front/vendor/fontawesome-free/css/all.min.css') }}">
