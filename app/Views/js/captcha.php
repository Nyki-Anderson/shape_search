<script>
    'use strict';
    var refreshButton = document.querySelector(".refresh-captcha");
    refreshButton.onclick = function() {
        document.querySelector(".captcha-image").src = "http://localhost:80/Shape_Search/app/function/captcha.php?" + Date.now();
    };
</script>