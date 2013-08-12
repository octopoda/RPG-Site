<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php'); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php'); ?>
<?php
	$site = new Site();
?>

<section class="mainContent">
  <div class="row-fluid main-body">
  <article class="span8">
    <h2>Contact Us</h2>

    <form id="formContact" method="POST">
      <fieldset>
        <p>
          <label for="name">Name:</label>
          <input type="text" name="name" id="name" class="required" autocomplete="off" />
        </p>
        <p>
          <label for="email">Email:</label>
          <input type="email" name="email" id="email" class="email" autocomplete="off" />
        </p>
        <p>
          <label for="subject">Subject:</label>
          <input type="text" name="subject" id="subject" class="required" autocomplete="off" />
        </p>
        <p>
          <label for="message">Message:</label>
          <textarea name="message" id="message" class="required textarea" ></textarea>
        </p>
        <p class="honeyPot"></p>

        <p class="submitArea">
          <input type="hidden" name="sendEmail" value="1" />
          <button name="sendEmail" id="sendEmail" class="btn btn-primary" >E-Mail Us.</button>
        </p>
        <p class="message"></p>
      </fieldset>
    </form>
  </article>
  <aside class="span4 sidebar">
  	<?php include(MODULES.'sidebar.php'); ?>
  </aside>
  </div>

</section>


<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>
