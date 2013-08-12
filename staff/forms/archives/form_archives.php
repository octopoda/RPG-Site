<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/staff/includes/admin_require.php');

	if (!empty($_GET['sel'])) {
		$archive = new Archive($_GET['sel']);
		$action = "Edit Issue";
		$month = date('m', strtotime($archive->datePublished));
		$year = date('Y', strtotime($archive->datePublished));
	} else {
		$archive = new Archive();
		$action = "Add an Issue";
		$month = 1;
		$year = date('Y');
	}

	echo $archive->pushToForm();


?>

<script>
$(document).ready(function () {
	$('#month').val(<?php echo $month; ?>);
	$('#year').val(<?php echo $year ?>);
});
</script>
<script src="/js/libs/ajaxupload.js"></script>


<h3><?php echo $action; ?></h3>

<div class="header">
	<form id="formUpdate" method="POST">
		<fieldset>
        	<p>
            	<label for="archive_title">Issue Title</label>
            	<input type="text" id="archive_title" name="archive_title" class="required" />
            </p>

            <p>
            	<label for="volume">Volume Number</label>
            	<input type="text" id="volume" name="volume" class="numeric" />
            </p>

            <p>
            	<label for="issue">Issue Number</label>
            	<input type="text" id="issue" name="issue" class="numeric" />
            </p>



            <p>
            	<label>File Location</label>
                <input type="text" name="archive_link" id="archive_link" value="<?php echo ($archive->archive_link != false) ? $archive->archive_link : 'There is no file associated with this article.' ?>" />

            	<a class="uploadFile">
                    <span class="ninjaSymbol ninjaSymbolPlus"></span>
                    <span class="text">Upload File</span>
				</a>
                <span class="archiveLink"></span>
            </p>


            <p>
            	<label for="published">Published</label>
                <select name="published" id="published">
                    <option value="0">Unpublished</option>
                    <option value="1">Published</option>
                </select>

            </p>

            <h4>Date Published</h4>
         	<div class="twoDropDowns clearfix">
                <p>
                    <label for="month">Seasons</label>
                    <select name="month" id="month">
                        <option value='1'>Winter</option>
                        <option value='3'>Spring</option>
                        <option value='6'>Summer</option>
                        <option value='9'>Fall</option>
                    </select>
                </p>
                <p>
                    <label for="year">Year</label>
                    <?php echo $archive->yearSelect(); ?>
                </p>
            </div>

          <p>
            	<input type="hidden" name="archive_id" id="archive_id" />
                <input type="hidden" name="class" id="class" value="archive">
                <input type="hidden" name="create" id="create" value="forms/archives/info_archives.php?sel=" />
                <button><?php echo $action; ?></button>
            </p>

        </fieldset>
    </form>

    <div class="data"></div>
</div>

<script type="text/javascript">
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
			$('.archiveLink').html(response);
			$('#archive_link').val(response);
			btnUpload.remove();
		}
	});

</script>



