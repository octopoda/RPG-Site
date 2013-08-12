<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php');
	require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php');

    $new = false;
	if (isset($_GET['id'])) {
        $u_id = Users::getUsersFromGuid($_GET['id']);
        $u = new Users($u_id);
    } else {
        $new = true;
    }
?>

<div class="container">

<section class="fluid-row calendar-header site-header small-header">
    <article class="image hero-unit">
        <div class="hero-wrapper">
          <h1>First Time?</h1>
        </div>
    </article>'
</section>


<section class="row">
    <article class="span8">
    <!--<a class="fillJoin">Fill Form</a> -->

        <form id="formSubmit" method="POST">
            <?php if ($new) : ?>
                <h1>First Time Logging In.</h1>
                <p>Have you joined the Academy website but haven't logged into ours.   We will need to set a couple things up first so go ahead and enter your member number and we'll send you an email with more detail.</p>
                <fieldset>
                    <p>
                        <label for="member_number">Member Number:</label>
                        <input name="member_number" id="member_number" type="text" class="required" />
                        <input type="hidden" name="firstTime" value="1" />
                    </p>
                </fieldset>
            <?php else: ?>
                <fieldset>
                    <h1>Welcome, <?php echo $u->printName(); ?><br/> <small>Let's setup your password.</small></h1>
                    <p>
                        <label for ="newPass">New Password</label>
                        <input id="newPass" name="newPass" type="password" class="required" />

                    </p>
                    <p>
                        <label for ="verifyPass">Verify Password</label>
                        <input id="verifyPass" name="verifyPass" type="password" class="equalTo" />
                    </p>
                    <input type="hidden" name="user_id" value="<?php echo $u->user_id ?>">
                    <input type="hidden" name="changePassword" value="/index.html"  />
                </fieldset>



            <?php endif; ?>

                <fieldset>
                    <p>
                        <button id="submit" name="submit">Submit</button>

                    </p>
                    <p class="data"></p>
                </fieldset>


        </form>
    </article>


</section>


</div>

<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>
