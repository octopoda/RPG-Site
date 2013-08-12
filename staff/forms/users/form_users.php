<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/staff/includes/admin_require.php');

	if (!empty($_GET['sel'])) {
		$u = new users($_GET['sel']);
		$action = "Update User";
        $class = "updateUser";

	} else {
		$u = new users();
		$content = new Content();
		$action = "Add User";
        $class = "addUser";
	}

	$phones = new Phones($u->user_id);
	$address = new Address($u->address_id);


	echo $u->pushToForm();
	echo $address->pushToForm();

	$link = 'form/users/form_users.php';

?>


<h3><?php echo $action; ?></h3>

<form id="formUpdate" method="POST" class="usersForm">
    <fieldset>
        <legend>Personal Details</legend>
        <p>
            <label for="first">First Name:</label>
            <input name="first" id="first" type="text" class="required" />
        </p>
        <p>
            <label for="last">Last Name:</label>
            <input type="text" name="last" id="last" class="required" />
        </p>
        <p>
            <label for="email">Email:</label>
            <input type="text" name="email" id="email"  class="required email" />
        </p>
        <p>
            <label for="memberNumber">Member Number</label>
            <input type="text" name="memberNumber" id="memberNumber">
        </p>
         <?php if ($action == "Add User") : ?>
            <p class="new">
                <label for="access">User Access</label>
                <?php echo $u->accessDropDown($u->user_id) ?>
            </p>
            <p>
                <label for="password">Password:</label>
                <input type="password" name="password" class="required">
            </p>
            <p>
                <label for="confirm_password">Confirm Password:</label>
                <input type="confirm_password" name="confirm_password"  class="equalTo">
            </p>
        <?php endif; ?>



    </fieldset>

    <fieldset>
    	<button name="users"><?php echo $action; ?></button>
        <input type="hidden" name="user_id" id="user_id" />
        <input type="hidden" name="<?php echo $class; ?>" id="<?php echo $class; ?>" value="forms/users/info_users.php?sel=" />
    </fieldset>

</form>

<div class="data"></div>


