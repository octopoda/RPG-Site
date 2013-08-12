<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . '/staff/includes/admin_require.php');

	if (!empty($_GET['sel'])) {
		$product = new Products($_GET['sel']);
        $action = "Edit " . $product->product_name;
        echo $product->pushToForm();
    } else {
        $product = new Products();
        $action = "Create Product";
    }

    $categories = ProductCategories::listCategories();
    $infoKey = md5(time().rand());

?>
<script src="/js/libs/ajaxupload.js"></script>
<style>
    .externalHide {display:none;}

</style>

<h3><?php echo $action; ?></h3>

<div class="header">
	<form id="formUpdate" method="POST">
        <h4>Product Information</h4>
		<fieldset>
            <p>
                <label for="product_name">Product Name</label>
                <input type="text" id="product_name" name="product_name" class="required" />
            </p>
            <p class="textarea">
                <label for="content">Content</label>
                <textarea name="content" id="<?php echo $infoKey ?>" class="editorContent required"><?php echo $product->content; ?></textarea>
                <input type="hidden" id="content" />
            </p>
         </fieldset>
        <fieldset>
            <h4>Pricing and Organization</h4>
              <p>
            	<label>Non Member Price</label>
            	<input type="text" id="NM_price" name="NM_price" class="number"  />
            </p>
            <p>
                <label>Member Price</label>
                <input type="text" id="M_price" name="M_price" class="number"  />
            </p>
            <p>
                <label>Institutional Price</label>
                <input type="text" id="I_price" name="I_price" class="number"  />
            </p>


            <p>
                <label for="category_id">Product Category</label>
                <select name="category_id" id="category_id">


                    <?php foreach ($categories as $id=>$name) {
                        echo '<option value="'.$id.'">'.$name.'</option>';
                    } ?>

                </select>
            </p>

        </fieldset>

        <fieldset>
            <h4>Product Options</h4>

            <p>
                <label>Show Quantity Field</label>
                <select name="quantity" id="quantity">
                    <option value="0" selected>Off</option>
                    <option value="1">On</option>
                </select>
            </p>
            <p>
                <label>Product In Stock</label>
                <select name="out-of-stock" id="out-of-stock">
                    <option value="0" selected>No</option>
                    <option value="1">Yes</option>
                </select>
            </p>

            <p class="radio">
                <label>Type of Product</label>
                <select name="type" id="type">
                    <option value="0">Download</option>
                    <option value="1">Audio/Video</option>
                    <option value="2">Shipped</option>
                </select>
            </p>
            <!-- <p class="hideShipping">
                <label for="shipping">Shipping Cost</label>
                <input type="text" name="shipping" id="shipping" />
            </p> -->
            <p class="externalHide">
                <label>Audio/Video Link</label>
                <input type="text" name="external" id="external" />
            </p>
            <p class="downloadHide">
                <label>Download Link</label>
                <input type="text" name="download" id="download" />
                <a class="uploadImageContent">
                    <span class="ninjaSymbol ninjaSymbolPlus"></span>
                    <span class="text">Upload Image</span>
                </a>
            </p>

        </fieldset>


        <fieldset>
            <p>
            	<input type="hidden" name="product_id" id="product_id" />
                <input type="hidden" name="class" id="class" value="products" />
                <input type="hidden" name="create" id="create" value="forms/products/info_product.php?sel=" />
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

    $('#type').change(function () {
        _val = $(this).val();
        if (_val == 0) {
            $('.downloadHide').show();
            $('.externalHide').hide();
        } else if (_val == 1) {
            $('.downloadHide').hide();
            $('.externalHide').show();
        } else if (_val == 2) {
            $('.downloadHide').hide();
            $('.externalHide').hide();
        }
    });

    var btnUpload=$('.uploadImageContent');
    var button = $('.uploadImageContent').html();
    var content;

    new AjaxUpload(btnUpload, {
        action: '/ajax/ajax_upload.php',
        name: 'file_name',
        data: {'content': 1, 'folder': 'products'},
        onSubmit: function(file, ext){
            btnUpload.html('<img src="/images/admin/ajax-loader.gif" alt="loading"/>');
            content = $('.editor').val();
            if (! (ext && /^(jpg|png|jpeg|gif|pdf|doc|docx)$/.test(ext))){
                // extension is not allowed
                alert('Only JPG, PNG, GIF, pdf, doc, docx files are allowed');
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
            $('#download').val(response);
            btnUpload.html(button);
        }
    });




</script>