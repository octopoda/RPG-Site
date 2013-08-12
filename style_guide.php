<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php');

?>


<?php
    $title = "";
    $name = "";

    if (isset($_GET['title']))
        $title = $_GET['title'];
    if (isset($_GET['name']))
        $name = $_GET['name'];

    $display = new SiteDisplay($title, $name);
    $detect = new MobileDetect();
  $class = '';
  $class .= ($display->reject == true ? 'disabled' : '');
  $class .= ($detect->isMobile() ? ' mobile' : '') ;
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9 oldie" lang="en"> <![endif]-->
<html class="<?php echo $class;  ?> no-js "  lang="en"><head>

  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <meta charset="utf-8">
  <title><?php echo $site->siteName . $display->displayPageTitle(); ?></title>
  <meta name="description" content="<?php echo $display->displayPageDescription(); ?>">
  <meta name="author" content="Octopoda Media Inc. http://octopodamedia.com">
  <meta name="keywords" content="<?php echo $display->displayKeywords(); ?>"  />

   <meta name="viewport" content="width=device-width">
  <meta name="apple-mobile-web-app-capable" content="yes"/>


  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">

  <!-- CSS: implied media="all" -->
  <link href='http://fonts.googleapis.com/css?family=Roboto:400,100' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="/css/basic.css"  />


  <!-- Modernizr -->
  <script src="/js/libs/modernizr-2.5.2.min.js"></script>
  <style>
    body {width:90%; margin:auto;}
  </style>

  <!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->


</head>
<body>

<!-- Restricted Modal -->
<div id="restricted" class="modal hide fade"  tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-header">
    <h3 id="myModalLabel">No Access</h3>
  </div>
  <div class="modal-body">
    <p>You do not have access to this page.  Please click the back button or log in to get access.</p>

  <form class="modal-form">
    <fieldset class="form-horizontal">
        <legend>Member Log In</legend>
        <div class="control-group">
            <label class="control-label" for="focusedInput">AAND Number</label>
            <div class="controls">
                <input class="input-xlarge" id="focusedInput" type="text" >
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="focusedInput">Last Name</label>
            <div class="controls">
                <input class="input-xlarge" id="focusedInput" type="text" value="">
            </div>
        </div>

        <button class="btn" data-dismiss="modal" aria-hidden="true">Log In</button>



    </fieldset>
  </form>
  <div class="modal-footer span12">

  </div>
  </div>

</div>

<div id="main-preview">
   <div id="preview-target">
    <div class="row-fluid" id="bootswatch-preview">
        <div class="navbar">
            <div class="navbar-inner">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a class="brand" href="/">NAV BAR</a>
                <div class="nav-collapse">
                    <ul class="nav">
                        <li class="active"><a href="#">Active</a></li>
                        <li class=""><a href="#">Other</a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                                Dropdown <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Action 1</a></li>
                                <li><a href="#">Action 2</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Action 3</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>
        <div class="hero-unit">
            <h1>Renal Nutrition Style Guide</h1>
            <p>This is the Hero Unit.  <a href="#">A link</a>.</p>
        </div>
        <div class="span12" style="padding-bottom: 65px;">

            <div class="page-header">
                <h1>Buttons <small>Plain, All Sizes</small></h1>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Size</th>
                        <th>Default</th>
                        <th>Primary</th>
                        <th>Info</th>
                        <th>Success</th>
                        <th>Warning</th>
                        <th>Danger</th>
                        <th>Inverse</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Mini</td>
                        <td><a class="btn btn-mini">Default</a></td>
                        <td><a class="btn btn-primary btn-mini">Primary</a></td>
                        <td><a class="btn btn-info btn-mini">Info</a></td>
                        <td><a class="btn btn-success btn-mini">Success</a></td>
                        <td><a class="btn btn-warning btn-mini">Warning</a></td>
                        <td><a class="btn btn-danger btn-mini">Danger</a></td>
                        <td><a class="btn btn-inverse btn-mini">Inverse</a></td>
                    </tr>
                    <tr>
                        <td>Small</td>
                        <td><a class="btn btn-small">Default</a></td>
                        <td><a class="btn btn-primary btn-small">Primary</a></td>
                        <td><a class="btn btn-info btn-small">Info</a></td>
                        <td><a class="btn btn-success btn-small">Success</a></td>
                        <td><a class="btn btn-warning btn-small">Warning</a></td>
                        <td><a class="btn btn-danger btn-small">Danger</a></td>
                        <td><a class="btn btn-inverse btn-small">Inverse</a></td>
                    </tr>
                    <tr>
                        <td>Default</td>
                        <td><a class="btn">Default</a></td>
                        <td><a class="btn btn-primary">Primary</a></td>
                        <td><a class="btn btn-info">Info</a></td>
                        <td><a class="btn btn-success">Success</a></td>
                        <td><a class="btn btn-warning">Warning</a></td>
                        <td><a class="btn btn-danger">Danger</a></td>
                        <td><a class="btn btn-inverse">Inverse</a></td>
                    </tr>
                    <tr>
                        <td>Large</td>
                        <td><a class="btn btn-large">Large</a></td>
                        <td><a class="btn btn-primary btn-large">Primary</a></td>
                        <td><a class="btn btn-info btn-large">Info</a></td>
                        <td><a class="btn btn-success btn-large">Success</a></td>
                        <td><a class="btn btn-warning btn-large">Warning</a></td>
                        <td><a class="btn btn-danger btn-large">Danger</a></td>
                        <td><a class="btn btn-inverse btn-large">Inverse</a></td>
                    </tr>
                </tbody>
            </table>

            <div class="page-header" style="padding-top:30px;">
                <h1><small>Button Groups</small></h1>
            </div>


            <div class="btn-group">
              <button class="btn">Left</button>
              <button class="btn">Middle</button>
              <button class="btn">Right</button>
            </div>


            <div style="height:105px;"></div>

            <div class="page-header">
                <h1>Typography <small>Headings, paragraphs, lists, and other inline type elements</small></h1>
            </div>

            <div class="row-fluid">
                <div class="span6">
                    <p>
                        </p><h1>Heading H1</h1>
                        <h2>Heading H2</h2>
                        <h3>Heading H3</h3>
                        <h4>Heading H4</h4>
                        <h5>Heading H5</h5>
                        <h6>Heading H6</h6>
                    <p></p>
                </div>
                <div class="span5">
                    <h3>Example body text</h3>
                    <p>Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula.</p>
                    <h3>Lead body copy</h3>
                    <p>Make a paragraph stand out by adding <code>.lead</code>.</p>
                    <p class="lead">Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus.</p>
                </div>
            </div>

            <div class="row-fluid">
                <div class="span7">
                    <blockquote>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante venenatis.</p>
                        <small>Someone famous in <cite title="">Body of work</cite></small>
                    </blockquote>
                </div>
            </div>

            <div class="page-header">
                <h1>Labels, Badges, &amp; Alerts</h1>
            </div>

            <div class="row-fluid">
                <div class="span6">
                    <span class="label">Default</span>
                    <span class="label label-success">Success</span>
                    <span class="label label-warning">Warning</span>
                    <span class="label label-important">Important</span>
                    <span class="label label-info">Info</span>
                    <span class="label label-inverse">Inverse</span>
                </div>
                <div class="span5">
                    <span class="badge">1</span>
                    <span class="badge badge-success">2</span>
                    <span class="badge badge-warning">4</span>
                    <span class="badge badge-important">6</span>
                    <span class="badge badge-info">8</span>
                    <span class="badge badge-inverse">10</span>
            </div>

            <div class="row-fluid" style="clear:both">
                <div class="alert">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Warning!</strong> Best check yo self, you're not looking too good.
                </div>

                <div class="alert alert-error">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Oh Snap!</strong> Change a few things and try again.
                </div>

                <div class="alert alert-success">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Well Done!</strong> You successfully read this important message.
                </div>

                <div class="alert alert-info">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Heads Up!</strong> This needs your attention.
                </div>
            </div>

            <div class="page-header">
                <h1>Tables <small>Bordered table shown</small></h1>
            </div>

             <div class="row-fluid">
                <div class="span11">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Username</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td rowspan="2">1</td>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@TwBootstrap</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td colspan="2">Larry the Bird</td>
                                <td>@twitter</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="page-header">
                <h1>Forms</h1>
            </div>


            <div class="row-fluid">
                <div class="span11">
                    <form class="form-horizontal">
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="focusedInput">Focused input</label>
                                <div class="controls">
                                    <input class="input-xlarge focused" id="focusedInput" type="text" value="This is focused…">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Uneditable input</label>
                                <div class="controls">
                                    <span class="input-xlarge uneditable-input">Some value here</span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="disabledInput">Disabled input</label>
                                <div class="controls">
                                    <input class="input-xlarge disabled" id="disabledInput" type="text" placeholder="Disabled input here…" disabled="">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="optionsCheckbox3">Checkbox</label>
                                <div class="controls">
                                    <label class="checkbox">
                                        <input type="checkbox" id="optionsCheckbox3" value="option1">
                                        This is a checkbox
                                    </label>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="optionsCheckbox2">Disabled checkbox</label>
                                <div class="controls">
                                    <label class="checkbox">
                                        <input type="checkbox" id="optionsCheckbox2" value="option1" disabled="">
                                        This is a disabled checkbox
                                    </label>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="optionsCheckbox2">Radio Buttons</label>
                                <div class="controls">
                                    <label class="radio">
                                        <input type="radio" id="radio1" value="option1" >
                                        Radio 1
                                    </label>
                                    <label class="radio">
                                        <input type="radio" id="radio1" value="option2" >
                                        Radio 2
                                    </label>
                                    <label class="radio">
                                        <input type="radio" id="radio1" value="option3" >
                                        Radio 3
                                    </label>
                                </div>
                            </div>

                            <div class="control-group warning">
                                <label class="control-label" for="inputWarning">Input with warning</label>
                                <div class="controls">
                                    <input type="text" id="inputWarning">
                                    <span class="help-inline">Something may have gone wrong</span>
                                </div>
                            </div>
                            <div class="control-group error">
                                <label class="control-label" for="inputError">Input with error</label>
                                <div class="controls">
                                    <input type="text" id="inputError">
                                    <span class="help-inline">Please correct the error</span>
                                </div>
                            </div>
                            <div class="control-group success">
                                <label class="control-label" for="inputSuccess">Input with success</label>
                                <div class="controls">
                                    <input type="text" id="inputSuccess">
                                    <span class="help-inline">Woohoo!</span>
                                </div>
                            </div>
                            <div class="control-group success">
                                <label class="control-label" for="selectError">Select with success</label>
                                <div class="controls">
                                    <select id="selectError">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                    <span class="help-inline">Woohoo!</span>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Save changes</button>
                                <button class="btn">Cancel</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>


            <div class="page-header">
                <h1>Nav, tabs, and pills <small>Highly customizable list-style navigation</small></h1>
            </div>


            <div class="row-fluid">
            <div class="span6">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#">Profile</a></li>
                    <li><a href="#">Messages</a></li>
                </ul>
                <ul class="nav nav-pills">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#">Profile</a></li>
                    <li><a href="#">Messages</a></li>
                </ul>
                <ul class="nav nav-tabs nav-stacked">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#">Profile</a></li>
                    <li><a href="#">Messages</a></li>
                </ul>
                <ul class="nav nav-pills nav-stacked">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#">Profile</a></li>
                    <li><a href="#">Messages</a></li>
                </ul>

                <ul class="nav nav-tabs">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#">Help</a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Dropdown <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="nav nav-pills">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#">Help</a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Dropdown <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </li>
                </ul>

                <div class="tabbable"> <!-- Only required for left/right tabs -->
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1" data-toggle="tab">Section 1</a></li>
                    <li><a href="#tab2" data-toggle="tab">Section 2</a></li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="tab1"><p>I'm in Section 1.</p></div>
                    <div class="tab-pane" id="tab2"><p>Howdy, I'm in Section 2.</p></div>
                  </div>
                </div>
            </div>

            <div class="span5">
                <ul class="nav nav-list">
                    <li class="nav-header">List header</li>
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#">Library</a></li>
                    <li><a href="#">Applications</a></li>
                    <li class="nav-header">Another list header</li>
                    <li><a href="#">Profile</a></li>
                    <li><a href="#">Settings</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Help</a></li>
                </ul>
                <br><br><br>
                <ul class="nav nav-list">
                    <li class="nav-header">List header</li>
                    <li class="active"><a href="#"><i class="icon-white icon-home"></i> Home</a></li>
                    <li><a href="#"><i class="icon-book"></i> Library</a></li>
                    <li><a href="#"><i class="icon-pencil"></i> Applications</a></li>
                    <li class="nav-header">Another list header</li>
                    <li><a href="#"><i class="icon-user"></i> Profile</a></li>
                    <li><a href="#"><i class="icon-cog"></i> Settings</a></li>
                    <li class="divider"></li>
                    <li><a href="#"><i class="icon-flag"></i> Help</a></li>
                </ul>
            </div>
        </div> <!-- Span 5 -->

        <div style="height:100px;"></div>

        <div class="page-header">
            <h1>Front Page Slideshow</h1>
        </div>

       <div class="fpTabs">
    <article class="image hero-unit active">
        <div class="number">1</div>
        <div class="hero-wrapper">
          <h1>Hello World!</h1>
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing
              elit. Aenean commodo ligula eget dolor. Aenean massa</p>
            <button class="btn btn-large">Click Here</button>
        </div>
    </article>
    <article class="image hero-unit">
        <div class="number">2</div>
        <div class="hero-wrapper">
          <h1>Tab Numero Dos</h1>
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing
              elit. Aenean commodo ligula eget dolor. Aenean massa</p>
            <button class="btn btn-large">Click Here</button>
        </div>
    </article>
    <article class="image hero-unit">
        <div class="number">3</div>
        <div class="hero-wrapper">
          <h1>Third Time is the Charm</h1>
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing
              elit. Aenean commodo ligula eget dolor. Aenean massa</p>
            <button class="btn btn-large">Click Here</button>
        </div>
    </article>

</div>
        <div style="height:100px;"></div>

            <div class="page-header">
                Image Grid
            </div>

        <div class="image-grid">
            <div class="image">
                <a href="/e-library/professional-resource-center.html">
                    <img src="/files/images/prc_203x200.png" alt="">
                    <h4>Professional Resource Center</h4>
                </a>
            </div>
            <div class="image">
                <a href="/e-library/patient-education-handouts.html">
                    <img src="/files/images/patient_education_203x200.png" alt="" />
                    <h4>Patient Educational Handouts</h4>
                </a></div>
            <div class="image">
                <a href="/e-library/academy-product-marketplace.html">
                    <img src="/files/images/academy_library_204x200.png" alt="" />
                    <h4>Academy Product Marketplace</h4>
                </a></div>
            <div class="image">
                <a href="/e-library/consumer-renal-products.html">
                    <img src="/files/images/consumertools_199x200.png" alt="" />
                    <h4>Consumer Renal Products</h4>
                </a></div>
            <div class="image">
                <a href="/e-library/call-out-for-handouts-toolkits.html">
                    <img src="/files/images/callout_206x200.png" alt="" />
                    <h4>Call-Out for Handouts &amp; Toolkits</h4>
                </a></div>

        </div>

        <div style="height:100px;"></div>

        <div class="page-header">Well or Callout</div>
        <p class="well">This is a callout or a well. Just add the "well" class.</p>


         <div class="page-header">
            <h1>Product Price Tables</h1>
        </div>

             <section class="product-table">
                        <article>
                            <h4><a href="/store/eating-simply-with-renal-disease-download-english-version.html">Eating Simply with Renal Disease Download (English Version)</a></h4><p>Eating Simply with Renal Disease <br>Simple overview of the renal nutrition plan for patients with CKD Stage 5.</p><p><strong>Pricing:</strong><br>Member $5.00 <br>Non-Member $7.00 <br>Institution $10.00 <br>(Limit of 5 user access to file once purchased.)</p><p>Sample of brochure: <a href="../files/ESRD_brochure_sample.pdf" target="_blank">Click Here</a></p><p><strong>To print brochure download</strong>: Use 8 1/2 x 11 paper</p><p>For additional information about Eating Simply with Renal Disease, please email <a href="mailto:helpU@renalnutrition.org">helpU@renalnutrition.org</a>.<a href="mailto:di8tician@aol.com"></a></p></article>
                        <aside><div class="non-members price-cell">
                        <h3>non-members</h3>
                        <h5>$7.00</h5><a class="add-to-cart" href="#" data-price="7.00" data-id="6">Add to Cart</a></div><div class="members price-cell">
                        <h3>members</h3>
                        <h5>$5.00</h5><a class="add-to-cart" href="#" data-price="5.00" data-id="6">Add to Cart</a></div><div class="institutional price-cell">
                        <h3>institutional</h3>
                        <h5>$10.00</h5><a class="add-to-cart" href="#" data-price="10.00" data-id="6">Add to Cart</a></div></aside></section>


        <div style="height:100px;"></div>

         <div class="page-header">
            <h1>Modal <small>A simple way to get the attention of the viewer.</small></h1>

            <!-- Button to trigger modal -->
            <a href="#modal" role="button" class="btn" data-toggle="modal">Launch demo modal</a>

            <!-- Modal -->
            <div id="modal" class="modal hide slide"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Modal Header</h3>
              </div>
              <div class="modal-body">
                <p>The modal... Lorem ipsum dolor sit amet, consectetuer adipiscing
              elit. Aenean commodo ligula eget dolor. Aenean massa
              <strong>strong</strong>. Cum sociis natoque penatibus
              et magnis dis parturient montes, nascetur ridiculus
              mus. Donec quam felis, ultricies nec, pellentesque
              eu, pretium quis, sem. Nulla consequat massa quis
              enim. Donec pede justo, fringilla vel.</p>
              </div>
              <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                <button class="btn btn-primary">Save changes</button>
              </div>
            </div>
        </div>


        <div style="height:100px;"></div>

         <div class="page-header">
            <h1>Restricted Page <small>What happen when someone is not a member</small></h1>
        </div>

        <!-- Button to trigger modal -->
        <a href="#restricted" role="button" class="btn" data-toggle="modal">Launch demo restriction.</a>








        </div>
    </div>
</div>
</div>
</div>
<script>

</script>
<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>