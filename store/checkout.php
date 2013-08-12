<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php'); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php'); ?>
<?php
	$site = new Site();
  $comm = new Commerce();
  $cart = new ShoppingCart();

  $shipping = false;

  if (in_array(2, $cart->itemTypes())) {
    $shipping = true;
  }



?>

<section class="row-fluid main-body">
	 <form id="orderSubmit" method="POST" >

      <a class="fillCheckout dev-button" href="#">Fill Checkout</a>

      <div class="row-fluid">
      	<h1>Your Order</h1>
        <fieldset class="span12">
          <?php echo $cart->fullCart(false, true); ?>
      	</fieldset>
      </div>

      <!-- Row 2 -->
       <div class="row-fluid">

          <div class="span6">
          <h3>Your Information</h3>
          <fieldset>
            <p>
              <label for="first_name">First Name:</label>
              <input type="text" name="first_name" id="first_name" class="required" autocomplete="off"/>
            </p>
            <p>
              <label for="last_name">Last Name</label>
              <input type="text" name="last_name" id="last_name" class="required" autocomplete="off"  />
            </p>
          	<p>
              <label for="email">Email:</label>
              <input type="email" name="email" id="email" class="email"  autocomplete="off"  />
            </p>
            <p>
              <label for="phone">Phone:</label>
              <input type="tel" name="phone" id="phone" autocomplete="off" class="usPhone"  />
            </p>
            <?php if ($display->user->user_id == false) : ?>
            <p>
              <label for="password">Password:</label>
              <input type="password" name="password" id="password" >
            </p>
            <p>
              <label for="confirm_password">Confirm Password:</label>
              <input type="password" name="confirm_password" id="confirm_password" class="equalTo" >
            </p>
            <?php endif; ?>
          </fieldset>

        	</div>

          <div class="span6">
         	  <h3>Payment Information</h3>
            <fieldset>
          	<p>
                <select name="cc_type" id="cc_type">
                  <option value="visa">Visa</option>
                  <option value="master card">MasterCard</option>
                  <option value="american express">American Express</option>
                  <option value="discover">Discover</option>
                </select>
            </p>
            <p>
              <label for="cardName">Name on Card</label>
                <input type="text" name="cardName" id="cardName" class="required" />
            </p>
            <p>
            	<label for="ccnumber">Card Number</label>
                <input type="text" name="ccnumber" id="ccnumber" class="required"  />
            </p>
            <p>
            	<label for="expire">Expiration Date</label>

                <select name="expireMonth" class="expire-select">
                     <?php
                      for ($i = 1; $i <= 12; $i++) {
                        $month = ($i < 10) ? '0'.$i : $i;
                        echo '<option value="'.$month.'"';
                        if ($i == date("n")) echo ' selected="selected"';
                        echo '>'.$month.'</option>';
                      }
                     ?>
                </select>
                <select name="expireYear" class="expire-select">
                    <?php
                      $yr = date("Y");
                      for ($i=$yr; $i < $yr+15; $i++) {
                        echo '<option value="'.$i.'">'.$i.'</option>';
                      }
                    ?>
                </select>
            </p>
            <p>
            	<label for="ccv">CCV</label>
            	<input type="text" name="ccv" id="ccv" class="required"   />
            </p>

          </fieldset>
          <fieldset>

          	<ul class="cards">
                <li class="visa">Visa</li>
                <li class="mastercard">MasterCard</li>
                <li class="amex">American Express</li>
                <li class="discover">Discover</li>
            </ul>
          </fieldset>
         </div>
        </div>


      <div class="row-fluid">
          <h3>Billing Address</h3>
          <fieldset class="span6">
          	<p>
              <label for="address">Address</label>
              <input id="address" name="address" type="text"  class="required"   />
            </p>
            <p>
              <label for="address2">Address 2</label>
              <input id="address2" name="address2" type="text"   />
            </p>
            <p>
              <label for="city">City</label>
              <input type="text" name="city" id="city"  class="required"  />
            </p>
            <p>
              <label for="state">State</label>
              <?php echo Address::stateSelect('state_id'); ?> </p>
            <p>
              <label for="zip">Zip Code</label>
              <input name="zip" id="zip" type="text" class="zip"  />
            </p>
            <?php if ($shipping) : ?>
            <p>
              <label>
                <input type="checkbox" name="differentShipping" id="differentShipping" />
                I have a different shipping address
              </label>
            </p>
            <?php endif; ?>
          </fieldset>
          <?php if ($shipping) : ?>
          <fieldset class="span5">

            <div class="shipping">
            <p>
                <label for="shipping_address">Shipping Address</label>
                <input id="shipping_address" name="shipping_address" type="text"  class="required"   />
              </p>
              <p>
                <label for="shipping_address2">Shipping Address 2</label>
                <input id="shipping_address2" name="shipping_address2" type="text"   />
              </p>
              <p>
                <label for="city">City</label>
                <input type="text" name="shipping_city" id="shipping_city"  class="required"  />
              </p>
              <p>
                <label for="state">State</label>
                <?php echo Address::stateSelect('shipping_state_id'); ?> </p>
              <p>
                <label for="shipping_zip">Zip Code</label>
                <input name="shipping_zip" id="shipping_zip" type="text" class="zip"  />
              </p>
              </div>
            </fieldset>
          <?php endif; ?>
        </div>

         <div class="row-fluid">
         	<fieldset class="span12">
            <p>
            	<input type="hidden" name="completeOrder" id="completeOrder" value="1" />
              <input type="hidden" name="uid" id="uid" value="<?php echo $display->user->user_id; ?>" />
              <button type="submit" name="checkout" id="checkout" class="btn btn-primary btn-large checkout-button">Finalize My Order</button>
            </p>
            <p class="orderMessage">
            </p>
          </fieldset>
        </div>
        <div class="data"></div>
      </form>
</section>

<?php
$script = "$(document).ready(function() {

          $('#differentShipping').change(function() {
            $('.shipping').fadeIn(500);
          });


          //Validate Cards
          function validateCards(inputName) {
              $('.cards li').addClass('off');
              inputName.validateCreditCard(function(result) {
                   console.log('validating');
                if ((result.card_type === null)) {
                  $('.cards li').removeClass('off');
                  return;
                }

                if (result.length_valid && result.luhn_valid) {
                  $('.cards').addClass('correct');
                }

                $('.cards li').addClass('off');
                $('.cards .' + result.card_type.name).removeClass('off');

              });
          }

          $('#ccnumber').focusout(function() {
            if (!$('.cards').hasClass('correct')) $('#ccnumber').addClass('hasError');
            validateCards($('#ccnumber'));
          });

          $('#ccnumber').focus(function() {
            $(this).removeClass('hasError');
            $('.cards').removeClass('correct');
            validateCards($('#ccnumber'));
          });

  });";



$display->addScript('/js/libs/cc_validator.js');
$display->addScriptFunctions($script);

require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>
