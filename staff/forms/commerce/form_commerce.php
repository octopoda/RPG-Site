<?php
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');

	$comm = new Commerce();
	echo $comm->pushToForm();



    if ($users->access < 4) {
        redirect('/staff');
    }

?>

<form id="formUpdate" method="POST">
	<fieldset>
         <p>Please be careful changing the next two inputs.  Any changes to these input will cause your e-commerce system to go down.

      <!--   <p>
            <label for="sales_tax">Sales Tax (%)</label>
            <input type="text" name="sales_tax" id="sales_tax" autofocus class="required" />
            <input type="hidden" name="site_id" id="site_id" value="1" />
        </p> -->
    
        <p>
        <label for="type">E-commerce Provider:</label>   
        <select name="type" id="type">
            <option value="0">PayPal</option>
            <option value="1">Authorize.net</option>
        </select>
        </p>
        <div class="paypal">
            <p>
                <label for="pp_auth">PayPal Client Id:</label>
               <input type="text" name="pp_auth" id="pp_auth"  />
            </p>

            <p>
                <label for="pp_secret">PayPal Secret</label>
                <input type="text" name="pp_secret" id="pp_secret" />
            </p>
        </div>

        <div class="authorize">
            <p>
                <label for="auth_id">Authorization Id</label>
               <input type="text" name="auth_id" id="auth_id" />
            </p>

            <p>
                <label for="trans_id">Transaction Id</label>
                <input type="text" name="trans_id" id="trans_id" />
            </p>
       </div>

        <p>
            <button name="siteSettings" id="siteSettings">Submit</button>
            <input type="hidden" name="class" id="class" value="commerce">
            <input type="hidden" name="create" id="create" value="forms/commerce/info_commerce.php?sel=" />
        </p>

    </fieldset>
</form>
<script>
    $(document).ready(function () {
        _initVal = $('#type').val();

        
        var hideShow = function (val) {
            if (val == 0) {
                $('.paypal').show();
                $('.authorize').hide();
            } else {
                $('.paypal').hide();
                $('.authorize').show();
            }
        }


        hideShow(_initVal);

        $('#type').live('change', function () {
            hideShow($(this).val());
        });

        }); 

</script>
<div class="data"></div>

