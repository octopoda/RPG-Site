<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/staff/includes/admin_require.php');

	if (!empty($_GET['sel'])) {
		$front = new FrontPage($_GET['sel']);
        $action = "Edit Front Page Tab";
	} else {
		echo 'You need to select a front page tab in order to edit.';
        return;
	}



	echo $front->pushToForm();
    $infoKey = md5(time().rand());


?>
<script src="/js/libs/ajaxupload.js"></script>
<h3><?php echo $action; ?></h3>

<div class="header">
	<form id="formUpdate" method="POST">
		<fieldset>
        	<p>
            	<label>Title</label>
            	<input type="text" id="title" name="title" class="required" />
            </p>

            <p class="textarea">
                <label for="content">Content (Keep to 200-500 words)</label>
                <textarea name="content" id="<?php echo $infoKey ?>" class="editorContent required"><?php echo $front->content; ?></textarea>
                <input type="hidden" id="content" />
            </p>

            <div class="twoDropDowns clearfix">
            <p>
            	<label>Published</label>
                <select name="published" id="published">
                    <option value="0">Unpublished</option>
                    <option value="1">Published</option>
                </select>

            </p>

            </div>
			<p>
                <label for="image_url">Tab Image: </label>
                <input type="text" name="image_url" id="image_url">
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
            	<input type="hidden" name="front_id" id="front_id" />
                <input type="hidden" name="class" id="class" value="frontpage" />
                <input type="hidden" name="create" id="create" value="forms/frontpage/info_frontpage.php?sel=" />
                <button><?php echo $action; ?></button>
            </p>

        </fieldset>
    </form>

</div>


<div class="data">
</div>


<script type="text/javascript">

    tinyMCE.init({
        // General options
        mode : "textareas",
        theme : "advanced",
        editor_selector: "editorContent",
        plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,preview,media,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking",

        // Theme options
        theme_advanced_buttons1 : "bold, italic, strikethrough, |, styleselect, formatselect, |, pasteword, |, bullist, numlist, blockquote, |, link, unlink, anchor, image, |, code, |, spellchecker, | ,pagebreak ",
        theme_advanced_buttons2 : "",
        theme_advanced_buttons3 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "center",
        theme_advanced_resizing : true,

        content_css : "/css/tiny_styles.css",

        width: "600",
        height: "400"
    });

    tinyMCE.triggerSave();

	var btnUpload=$('.uploadImageContent');
	var button = $('.uploadImageContent').html();
	var content;

	new AjaxUpload(btnUpload, {
		action: '/ajax/ajax_upload.php',
		name: 'file_name',
		data: {'content': 1, 'folder': 'frontpage'},
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
			$('#image_url').val(response);
            btnUpload.html(button);
		}
	});


</script>