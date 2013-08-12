<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php');
	require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php');

  $cal = new gCalendar(4);
?>
  <header class="fpTabs">
    <?php $display->displayFrontPage(); ?>
  </header>

  <section class="row-fluid main-body">
     <article class="span8">
          <section class="homeContent">

            <p class="lead">RPG's purpose is to offer leadership, legislative direction and educational resources to help members provide quality renal nutrition therapy. </p>
            </p> RPG promotes continuing education programs for renal dietitians and is an information resource for those who specialize and work in renal nutrition. The practice group includes renal dietitians working with AKI (acute kidney injury), chronic kidney disease (stages 1-5), adult, adolescent and pediatric dialysis, as well as kidney transplant patients.</p>
          </section>
          <section>
            <h3><?php $display->displayTitle(); ?></h3>
            <?php $display->displayContent(); ?>

        </section>
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

          </section>
      </article>


      <aside class="span4 sidebar">
          <section class="memberBenefit">
              <a href=""><h3 class="h3-highlight">Member Benefits</h3></a>
             <a class="sprites-member_benefits"></a>
          </section>


        <sectiom class="front-page-ad">
          <?php
            $display->displayAds(0);
            $display->displayAds(1);
          ?>

        </sectiom>
      </aside>
</section>



<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>
