<?php
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');

	$comm = new Commerce();
  $site = new Site();


?>

<?php if ($users->access >= 4) : ?>

<ul class="quickMenu">
	<li><a href="forms/commerce/form_commerce.php" class="redirect">
    		<span class="ninjaSymbol ninjaSymbolEdit"></span>
        	<span class="text">Edit Information</span>
         </a></li>
</ul>
<?php endif; ?>


<h3 class="floatLeft"><?php echo $site->siteName; ?> Online Store Defaults</h3>

<div>
	<dl class="clearfix">
    <dt>E-commerce provider:</dt>
    <dd><?php  echo ($comm->type==0) ? 'PayPal': 'Authorize.net'; ?></dd>

      <!-- <dt>Sales Tax:</dt>
        	<dd><?php echo $comm->sales_tax; ?>%</dd>
       -->	 
       <?php if ($users->access >= 4) : ?>


        <?php if ($comm->type == 0) : ?>

        <dt>PayPal Client Id:</dt>
          <dd><?php echo $comm->pp_auth; ?></dd>
        <dt>PayPal Secret:</dt>
          <dd><?php echo $comm->trans_id; ?></dd>
      

      <?php else : ?>

       <dt>Authorize.net <br />Authorization Id:</dt>
        	<dd><?php echo $comm->auth_id; ?></dd>
        <dt>Authorize.net <br />Transaction Id:</dt>
        	<dd><?php echo $comm->trans_id; ?></dd>
      
       <?php endif; endif; ?>

	</dl>


</div>
<div class="data"></div>

