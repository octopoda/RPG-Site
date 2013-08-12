<?php
		require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php');
	require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php');
    $cal = new gCalendar(4);
?>


    <header class="row-fluid calendar-header site-header small-header">
        <article class="image hero-unit">
            <div class="hero-wrapper">
              <h1><?php echo $site->siteName; ?> Events</h1>
            </div>
        </article>'
    </header>

    <div id='loading' style='display:none'>loading...</div>
    <div id='calendar' class="hidden-smallPhone"></div>

    <div class="visible-smallPhone">
        <section class="fpEvents">
            <h2>Latest Events</h2>
            <?php $cal->displayEvents();
              foreach ($cal->events as $evt) {
            ?>
              <div class="front-event">
                  <hgroup>
                    <h1 class="front-event-title"><?php echo $evt->title; ?></h1>
                    <h4 class="front-event-date"><?php echo $evt->dateRange; ?> @ <?php echo $evt->location; ?></h4>
                  </hgroup>
                  <a class="btn btn-info" href="<?php echo $evt->link; ?>" target="_blank">More Info</a>

            </div>
            <?php } ?>
            <p>For a full listing of events please visit this page on a tablet or desktop computer. </p>
          </section>
    </div>



<?php

$script = 	"$(document).ready(function() {

				$('#calendar').fullCalendar({
					//Calendar Feed
					events: 'https://www.google.com/calendar/feeds/renalnutritionorg%40gmail.com/public/basic',

					eventClick: function(event) {
						// opens events in a popup window
						window.open(event.url, 'gcalevent', 'width=700,height=600');
						return false;
					},

					loading: function(bool) {
						if (bool) {
							$('#loading').show();
                            $('.calendar').hide();
                        }else{
							$('#loading').hide();
                            $('.calendar').fadeIn(1000);
                            _bodyCol = $('.bodyCol').outerHeight();
                            _navCol = $('.navCol').outerHeight();

                            if (_navCol < _bodyCol) {
                                $('.navCol').height(_bodyCol);
                            } else {
                                $('.bodyCol').height(_navCol);
                            }
                        }
                    }

				});

			});";

?>


<?php $display->addScript('/js/libs/fullcalendar.min.js'); ?>
<?php $display->addScript('/js/libs/gcal.js'); ?>
<?php $display->addScriptFunctions($script); ?>

<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>