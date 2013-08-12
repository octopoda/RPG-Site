<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/staff/includes/admin_require.php');

	if (!empty($_GET['sel'])) {
		$ads = new Ads($_GET['sel']);
		$action = "Update Advertisment";
        $u = new Users($ads->user_id);
	} else {
		$ads = new Ads();
		$action = "Insert Advertisment";
		$u = new Users($users->user_id);
	}



	echo $ads->pushToForm();
	echo $u->pushToForm();

?>
<script src="/js/libs/ajaxupload.js"></script>
<h3><?php echo $action; ?></h3>

<div class="header">
	<form id="formUpdate" method="POST">
		<fieldset>
        	<p>
            	<label>Advertisement Title</label>
            	<input type="text" id="title" name="title" class="required" />
            </p>
            <div class="twoDropDowns clearfix">
            <p>
            	<label>Published</label>
                <select name="published" id="published">
                    <option value="0">Unpublished</option>
                    <option value="1">Published</option>
                </select>

            </p>

            <p class="new">
            	<label for="placement">Placement:</label>
				<select name="placement" id="placement">
                	<option value="0" selected>Sidebar 1</option>
                    <option value="1">Sidebar 2</option>
                    <option value="2">Navigation</option>
                </select>
            </p>
            </div>
			<p>
                <label for="image">Ad Image: </label>
                <input type="text" name="image" id="image">
            	<a class="uploadImageContent">
                    <span class="ninjaSymbol ninjaSymbolPlus"></span>
                    <span class="text">Upload Image</span>
				</a>
            </p>

            <p>
                <label for="link">Link:</label>
                <input type="text" name="link" id="link">
            </p>

            <p>
            	<input type="hidden" name="ad_id" id="ad_id" />
                <input type="hidden" name="user_id" id="user_id" />
                <input type="hidden" name="class" id="class" value="ads" />
                <input type="hidden" name="create" id="create" value="forms/content/info_ads.php?sel=" />
                <button><?php echo $action; ?></button>
            </p>

        </fieldset>
    </form>

</div>


<div class="data">
</div>


<script type="text/javascript">

	var btnUpload=$('.uploadImageContent');
	var button = $('.uploadImageContent').html();
	var content;

	new AjaxUpload(btnUpload, {
		action: '/ajax/ajax_upload.php',
		name: 'file_name',
		data: {'content': 1, 'folder': 'ads'},
		onSubmit: function(file, ext){
			btnUpload.html('<img src="/images/admin/ajax-loader.gif" alt="loading"/>');
			content = $('.editor').val();
			if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
				// extension is not allowed
				alert('Only JPG, PNG, GIF,  files are allowed');
				return false;
			}

			if (file.length > 59) {
				alert('The file name is too long.  Please keep file names under 60 characters.');
				btnUpload.html(button);
				return false;
			}

			if (file.indexOf(' ') > 0) {
				alert('Please remove the spaces from the file name.');
				btnUpload.html(button);
				return false;
			}

		},
		onComplete: function(file, response){
			$('#image').val(response);
            btnUpload.html(button);
		}
	});


</script>