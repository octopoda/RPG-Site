<?php
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
	$users = new Users();

	if (!empty($_GET['sel'])) {
		$u = new users($_GET['sel']);
		$action = "Update User";
        $group = UserGroups::initFromPosition($u->access);


	} else {
		echo '<p>You have not picked a user. Please go back to search users and click a user to view.</p>';
		return;
	}


	//$phones = new Phones($u->user_id);
	//$address = new Address($u->address_id);


?>

<ul class="quickMenu">
	<li><a href="forms/users/form_users.php?sel=<?php echo $u->user_id; ?>" class="redirect">
    		<span class="ninjaSymbol ninjaSymbolEdit"></span>
        	<span class="text">Edit Information</span>
         </a></li>
    <li><a href="forms/users/change_password.php?sel=<?php echo $u->user_id ?>" class="redirect">
   			<span class="ninjaSymbol ninjaSymbolLock"></span>
            <span class="text">Change Password</span>
        </a></li>
</ul>

<h3 class="floatLeft"><?php echo $u->printName(); ?></h3>

<div>
	<h4>Personal Information</h4>
	<dl class="clearfix">
        <dt>Member Number</dt>
            <dd><?php echo $u->memberNumber; ?></dd>

        <dt>Email:</dt>
        	<dd><a href="mailto:<?php echo $u->email; ?>"><?php echo $u->email; ?></a></dd>

        <dt>Access:</dt>
        <dd ><?php echo $group->groupname;  ?></dd>

    </dl>

    <h4>Login Information</h4>

    <dl>
        <dt>Created On:</dt>
        <dd><?php echo ($u->created_on != '0000-00-00 00:00:00') ? date("d/m/Y H:i:s", strtotime($u->created_on)) : 'Before Site was created'; ?></dd>
        <dt>Last Login:</dt>
        <dd><?php echo ($u->last_login != '0000-00-00 00:00:00') ? date('d/m/Y H:i:s', strtotime($u->last_login)) : 'Never Logged In'; ?></dd>
    </dl>

</div>

<div class="data"></div>

