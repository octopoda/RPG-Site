
<?php $contactInformation = new ContactInformation(); ?>
    <footer>
        <section class="row-fluid">
              <?php echo $contactInformation->summary; ?>
        </section>
        <section class="dark-footer row-fluid">

            <article>
                <div class="span6">
                  <dl>
                    <dt>Office</dt>
                    <dd class="footer-address"><?php echo $contactInformation->address->printAddress(); ?></dd>
                  </dl>
                  <dl class="footer-double">
                    <dt>Email</dt>
                    <dd><a href="/contact_us.html">Click here to send an email.</a></dd>
                  </dl>
                  <dl>
                    <dt>Phone</dt>
                    <dd class="phone"><?php echo $contactInformation->printPhones(); ?></dd>
                  </dl>
                  <dl>
                    <p class="copyright">&copy; <?php echo date("Y") ?> Renal Dietitians (RPG), All Rights Reserved.</p>
                  </dl>
                </div>
                <div class="span5 socialButtons">
                  <?php $display->socialIcons(); ?>
                </div>
            </article>

            </section>
      </footer>
 </section> <!-- Body Col -->



</div><!-- inner  wrapper -->
</div> <!-- Outer Wrapper -->

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>
  <script src="/js/plugins.js"></script>
  <script src="/js/libs/bootstrap.js" ></script>
  <?php $display->printScripts(); ?>
  <script src="/js/script-bi.js"></script>
  <!-- end scripts-->



  <!-- mathiasbynens.be/notes/async-analytics-snippet Change UA-XXXXX-X to be your site's ID -->
 <?php if ((!empty($site->googleCode)) && (SERVER == 'live')) : ?>
  <script>
   var _gaq=[['_setAccount','<?php echo $site->googleCode; ?>'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
  </script>
  <?php endif; ?>


  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->

</body>
</html>



