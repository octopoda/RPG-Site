<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/staff/includes/admin_require.php');

	if (!empty($_GET['arc'])) {
		$archive = new Archive($_GET['arc']);
		echo $archive->pushToForm();
	}

	if (!empty($_GET['sel'])) {
		$article = new Article($_GET['sel']);
		$action = "Edit Article";
	} else {
		$article = new Article();
		$action = "Insert Article";
	}

	echo $article->pushToForm();
	$infoKey = md5(time().rand());
    
?>
<script src="/js/libs/ajaxupload.js"></script>


<h3><?php echo $action; ?></h3>
<?php if (!isset($_GET['arc'])) : ?>
	<p>This article will not be attached to an Archive.  It will only be found by categories or searching the articles.</p>
<?php endif; ?>
<div class="header">
	<form id="formUpdate" method="POST">

		<fieldset>
        	<p>
            	<label>Article Title</label>
            	<input type="text" id="article_title" name="article_title" class="required" />
            </p>

            <p>
            	<label>Author</label>
            	<input type="text" id="author" name="author" class="" />
            </p>

            <p>
            	<label>File Location</label>
                <input type="hidden" name="article_link" id="article_link" />
                <span class="articleLink"><?php echo ($article->article_link != false) ? $article->article_link : 'There is no file associated with this article.' ?></span>
            	<a class="uploadFile">
                    <span class="ninjaSymbol ninjaSymbolPlus"></span>
                    <span class="text">Upload File</span>
				</a>

            </p>

            <p>
            	<label>Published</label>
                <select name="published" id="published">
                    <option value="0">Unpublished</option>
                    <option value="1">Published</option>
                </select>

            </p>


            <p class="textarea">
            	<label for="description">Description</label>
            	<textarea name="description" id="<?php echo $infoKey ?>" class="editorContent"><?php echo $article->description; ?></textarea>									 				<input type="hidden" id="description" />
            </p>

            <p>
            	<label for="categories">Topics</label>
                <input type="text" name="categories" id="categories" class="categoriesAutoComplete" value="<?php echo $article->listCategories(); ?>" />
            </p>

            <p>
            	<input type="hidden" name="article_id" id="article_id" />
                <input type="hidden" name="archive_id" id="archive_id" />
                <input type="hidden" name="class" id="class" value="article">
                <input type="hidden" name="create" id="create" value="forms/archives/info_archives.php?sel=<?php echo $_GET['arc']; ?>" />
                <button><?php echo $action; ?></button>
            </p>

        </fieldset>
    </form>


</div>


<div class="data">
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $("#categories").autocomplete( "/ajax/admin/admin_form_submit.php",
            {
                autofill: true,
                matchSubset: false,
                matchContains: false,
                formatItem: function(row, i, max) { return row[0]; },
                formatMatch: function(row, i, max) { return row[0]; },
                formatResult: function(row) { return row[0]; },
                multiple: true,
                extraParams: { 'categoriesAutoComplete': 1 }
          });
    });


	tinyMCE.init({
        // General options
        mode : "textareas",
        theme : "advanced",
		editor_selector: "editorContent",
        plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,preview,media,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking",

        // Theme options
        theme_advanced_buttons1 : "bold, italic, strikethrough, |, pasteword, |, bullist, numlist, blockquote, |, link, unlink, anchor |, code, |, spellchecker, | ,pagebreak ",
        theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "center",
        theme_advanced_resizing : true,

		width: "600",
		height: "400"
	});



	var btnUpload=$('.uploadFile');
	var button = $('.uploadFile').html();

	new AjaxUpload(btnUpload, {
		action: '/ajax/ajax_upload.php',
		name: 'file_name',
		data: {'content': 1, 'folder': 'archives'},
		onSubmit: function(file, ext){
			btnUpload.html('<img src="/images/forum_admin/ajax-loader.gif" alt="loading"/>');
			if (! (ext && /^(jpg|png|jpeg|gif|pdf|doc|docx)$/.test(ext))){
				// extension is not allowed
				alert('Only JPG, PNG, GIF, PDF, DOC, DOCX  files are allowed');
				return false;
			}

			if (file.length > 59) {
				alert('The file name is too long. Please keep the file name under 60 characters.');
				return false;
			}

		},
		onComplete: function(file, response){
			$('.articleLink').html(response);
			$('#article_link').val(response);
			btnUpload.remove();
		}
	});



</script>