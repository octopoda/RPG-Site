<?php
	require_once($_SERVER['DOCUMENT_ROOT']. '/includes/require.php');
	require_once(PLUGIN_AJAX.DS. '/plugin_form_submit.php');


if (isset($_POST['create'])) {
	$classname  =  $_POST['class'];
	$classId = $classname . "_id";
	$id = null;

	if (isset($_POST[$classId])) $id = $_POST[$classId];

	$class = new $classname($id);
	$created = $class->createFromForm($_POST);

	echo $_POST['create'].$created;
}


if (isset($_POST['addUser'])) {
	global $error;

	if (isset($_POST['user_id']))  $id = $_POST['user_id'];
	$user = new Users($id);

	if(!$user->checkUsername($_POST['email'])) {
		$error->addError('That email is already registered');
	}

	$newUser_id = $user->createUserFromForm($_POST);

	echo $_POST['addUser']. $newUser_id;
}

if (isset($_POST['updateUser'])) {
	global $error;

	if (isset($_POST['user_id']))  $id = $_POST['user_id'];
	$user = new Users($id);

	$newUser = $user->updateUser($_POST);

	echo $_POST['updateUser'];
}

if (isset($_GET['categoriesAutoComplete'])) {
	$category = new SubCats();

	$result = $category->titleSearch($_GET['q']);
	foreach($result as $row) {
		 echo $row['sub_name']."\n";
	}
}


if (isset($_POST['changePassword'])) {
	global $error;

	$u = new Users($_POST['user_id']);

	if ($u->changePassword($_POST['newPass'])) {
		echo $_POST['changePassword'];
	}

}



if (isset($_POST['reportError'])) {

	$site = new Site();
	$site->reportError($_POST['error'], $_POST['errorId']);

	echo 'forms/site/error_reported.php';
}

if (isset($_POST['userGroups'])) {

	if (isset($_POST['group_id'])) $id = $_POST['group_id'];
	$ug = new userGroups($id);

	$created = $ug->createFromForm($_POST);

	echo $_POST['userGroups'].$created;
}



?>


