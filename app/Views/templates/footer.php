<!-- Closes content div -->
</div>
<footer>
    <!-- Footer main -->
    <section class='footer-main'>
        <div class='footer-main-item'>
            <h3 class='footer-title'>About</h3>
            <ul>
                <li><a href='#'>Services</a></li>
                <li><a href='#'>Portfolio</a></li>
                <li><a href='#'>Customers</a></li>
                <li><a href='#'>Careers</a></li>
            </ul>
        </div>

        <div class='footer-main-item'>
            <h3 class='footer-title'>Resources</h3>
            <ul>
                <li><a href='#'>Docs</a></li>
                <li><a href='#'>Blog</a></li>
                <li><a href='#'>References</a></li>
            </ul>
        </div>

        <div class='footer-main-item'>
            <h3 class='footer-title'>Contact</h3>
            <ul>
                <li><a href='#'>Help</a></li>
                <li><a href='#'>Development</a></li>
                <li><a href='#'>Advertise</a></li>
            </ul>
        </div>

        <div class='footer-main-item'>
            <h3 class='footer-title'>Stay Updated</h3>
            <p> Subscribe to our newletter to get our latest news. </p>

            <form class='footer-form'>
                <input type='email' name='email' placeholder='Enter email address' style='font-size: 12px;'>
                <input type='submit' value='Subscribe'>
            </form> 
        </div>
    </section>

    <!-- Footer Legal -->
    <section class='footer-legal'>
        <ul class='footer-legal-list'>
            <li><a href="<?php echo route_to('pages', 'terms_use')?>">Terms of Use</a></li>
            <li><a href="<?= route_to('pages', 'privacy_policy'); ?>">Privacy Policy</a></li>
            <li>&copy; 2022 Copyright AgBRAT </li>
        </ul>
    </section>
</footer>
</article>

   <?php if (isset($scripts)) {
        foreach ($scripts as $script) {
            echo view($script);
        
   } }?>

</body>
</html>
