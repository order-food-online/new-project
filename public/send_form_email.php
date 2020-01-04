<?php
if(isset($_POST['email'])) {
 
    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "james@optimizationmedia.niz";
    $email_subject = "Contact Form Submission Via OrderFoodOnline.ca";
 
    function died($error) {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }
 
 
    // validation expected data exists
    if(!isset($_POST['first_name']) ||
        !isset($_POST['last_name']) ||
        !isset($_POST['email']) ||
        !isset($_POST['business_name']) ||
        !isset($_POST['how_hear_about_us']) ||
        !isset($_POST['services_required']) ||
        !isset($_POST['telephone']) ||
        !isset($_POST['comments'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
    }
 
     
 
    $first_name = $_POST['first_name']; // required
    $last_name = $_POST['last_name']; // required
    $email_from = $_POST['email']; // required
    $business_name = $_POST['business_name']; //required
    $how_hear_about_us = $_POST['how_hear_about_us']; //required
    $services_required = $_POST['services_required']; //required
    $telephone = $_POST['telephone']; // required
    $comments = $_POST['comments']; // required
 
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }
 
    $string_exp = "/^[A-Za-z .'-]+$/";
 
  if(!preg_match($string_exp,$first_name)) {
    $error_message .= 'The First Name you entered does not appear to be valid.<br />';
  }
 
  if(!preg_match($string_exp,$last_name)) {
    $error_message .= 'The Last Name you entered does not appear to be valid.<br />';
  }
  
  if(!preg_match($string_exp,$business_name)) {
    $error_message .= 'The Business Name you entered does not appear to be valid.<br />';
  }
  
  if(!preg_match($string_exp,$how_hear_about_us)) {
    $error_message .= 'The How Hear About US you entered does not appear to be valid.<br />';
  }

  if(!preg_match($string_exp,$services_required)) {
    $error_message .= 'The Services Required you entered does not appear to be valid.<br />';
  }

  if(strlen($comments) < 2) {
    $error_message .= 'The Comments you entered do not appear to be valid.<br />';
  }
 
  if(strlen($error_message) > 0) {
    died($error_message);
  }
 
    $email_message = "Form Contact Details below.\n\n";
 
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
 
     $email_message .= "First Name: ".clean_string($first_name)."\n";
    $email_message .= "Last Name: ".clean_string($last_name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Business Name: ".clean_string($business_name)."\n";
    $email_message .= "How Your Hear About Us: ".clean_string($how_hear_about_us)."\n";
    $email_message .= "What Services You Interested in: ".clean_string($services_required)."\n";
    $email_message .= "Telephone: ".clean_string($telephone)."\n";
    $email_message .= "Comments: ".clean_string($comments)."\n";
 
// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);  
?>
 
<!-- include your own success html here -->
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="google-site-verification" content="BFrz_DSSSOPwXUk7KzRcMfQpOxKTsX3YW_OoA6qZirw" />
  <meta name="msvalidate.01" content="B22A1E34BCE00C9F45A66C7554EFB4A1" />
  <meta name="description" content="A LOT is 20 or more items (there's no maximum really) of toys, children's clothing, maternity clothing...
          you name it...anything to do with raising our little ones.">
  <meta name="author" content="">

  <title>Order Food Online - Online Food Ordering Systems for bars, restaurants</title>
  <!-- Bootstrap core CSS -->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
    crossorigin="anonymous">
  <link href="/stylesheets/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="https://aws-website-amp-bbq2v.s3.amazonaws.com/favicon-have-lots.png" type="image/gif" sizes="16x16">

  <!-- Custom fonts for this template -->
  <link href="/stylesheets/all.min.css" rel="stylesheet">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="/stylesheets/simple-line-icons.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template -->
  <link href="/stylesheets/landing-page.min.css" rel="stylesheet">
  <link href="/stylesheets/custom-landing.css" rel="stylesheet">
</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-default navbar-static-top" style="background-color: #e72525;">
    <div class="container">
      <a class="navbar-brand" href="#"><img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/order_food-online.png" height="100px"></a>
      <div class="container">
     <a class="btn btn-primary" style="float: right; margin: 2px;" href="/register"><i class="fa fa-pencil"></i> Sign Up!</a>&nbsp;&nbsp;&nbsp;
     <a class="btn btn-primary" style="float: right; margin: 2px;" href="/login"><i class="fa fa-lock"></i> Login</a>
        </div>
    </div>
  </nav>
  
  <!-- Masthead -->
  <header class="masthead text-white text-center">
      <div class="container">
    </div>
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-xl-9 mx-auto">
          <h1 class="mb-5">Who Delivers in Your Neighbourhood?
Order From Local Restaurants!</h1>
        </div>
        <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
          <form action="/restaurants" method="GET"  class="navbar-form navbar-right">
            <div class="form-row">
              <div class="col-12 col-md-9 mb-2 mb-md-0">
                <input type="text" name="search" class="form-control form-control-lg" placeholder="What City Are you Located In?">
              </div>
                <div class="col-12 col-md-3">
                <button type="submit" class="btn btn-block btn-lg btn-primary">
<i class="fa fa-search"></i> Search</button>
              </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </header>

  <!-- Icons Grid -->
  <section class="features-icons bg-light text-center">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
            <div class="features-icons-icon d-flex">
              <i class="fa fa-camera m-auto" style="color: #e72525;"></i>
            </div>
            <h3>Upload Pictures</h3>
            <p class="lead mb-0">Add Pictures to your Restaurant Location.</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-0 mb-lg-3">
            <div class="features-icons-icon d-flex">
              <i class="fa fa-user-plus m-auto" style="color: #e72525;"></i>
            </div>
            <h3>Review Ratings</h3>
            <p class="lead mb-0">Get more reviews/comments/likes for your Restaurant Location to Increase Sales.</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-0 mb-lg-3">
            <div class="features-icons-icon d-flex">
              <i class="fa fa-thumbs-o-up m-auto" style="color: #e72525;"></i>
            </div>
            <h3>New Like Feature for Restaurants</h3>
            <p class="lead mb-0">New Like Features/Follow Locations!</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-0 mb-lg-3">
            <div class="features-icons-icon d-flex">
              <i class="fa fa-lock m-auto" style="color: #e72525;"></i>
            </div>
            <h3>Security</h3>
            <p class="lead mb-0">Fully automated and tightly integrated 
            with PCI compliant payment gateway and merchant services makes 
            our Online Restaurant Ordering system a secure platform that 
            protects all online transactions.</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-0 mb-lg-3">
            <div class="features-icons-icon d-flex">
              <i class="fa fa-lightbulb m-auto" style="color: #e72525;"></i>
            </div>
            <h3>Marketing</h3>
            <p class="lead mb-0">Our service team will create your custom 
            marketing plan that suits your business and targets your customer 
            segments. Social Media Marketing, Internet Marketing, Email Marketing, 
            Print Media Marketing, and more</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-0 mb-lg-3">
            <div class="features-icons-icon d-flex">
              <i class="fa fa-cutlery m-auto" style="color: #e72525;"></i>
            </div>
            <h3>Online Ordering System</h3>
            <p class="lead mb-0">Make it easy for your customers to order food online, right 
            from your Website or Facebook Ordering application. Manage your orders through a feature
            rich portal.
            </p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-0 mb-lg-3">
            <div class="features-icons-icon d-flex">
              <i class="fa fa-chart-line m-auto" style="color: #e72525;"></i>
            </div>
            <h3>Analytics</h3>
            <p class="lead mb-0">We help our clients understand their business performance and 
            address areas of concerns. We help them understand their customers insights such 
            that they can improve their product and service.
            </p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-0 mb-lg-3">
            <div class="features-icons-icon d-flex">
              <i class="fa fa-mobile m-auto" style="color: #e72525;"></i>
            </div>
            <h3>Mobile Apps</h3>
            <p class="lead mb-0">Our mobile app and Facebook Ordering application help you add 
            more customs and increase sales. Our online food ordering applications work on all 
            major mobile OS , phones and tablets.
            </p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-0 mb-lg-3">
            <div class="features-icons-icon d-flex">
              <i class="fa fa-desktop m-auto" style="color: #e72525;"></i>
            </div>
            <h3>Websites</h3>
            <p class="lead mb-0">Website is essential for any online business and so we help our 
            clients get that going with various options templates to custom built with rich user 
            experience. Additionally we can host and maintain your website.
            </p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-0 mb-lg-3">
            <div class="features-icons-icon d-flex">
              <i class="fa fa-address-card m-auto" style="color: #e72525;"></i>
            </div>
            <h3>Restaurants</h3>
            <p class="lead mb-0">Tap the untapped revenues you can get with 
            online food ordering system and marketing services. We will empower 
            you with a platform for success through website, facebook ordering, 
            marketing, social media, branding.
            </p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-0 mb-lg-3">
            <div class="features-icons-icon d-flex">
              <i class="fa fa-car m-auto" style="color: #e72525;"></i>
            </div>
            <h3>Delivery Services</h3>
            <p class="lead mb-0">Through our online food delivery application, we will 
            set you up with all that you need to receive and manage orders for delivery 
            from your restaurant clients. We even provide marketing and sales support 
            to make you successful.
            </p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-0 mb-lg-3">
            <div class="features-icons-icon d-flex">
              <i class="fa fa-calculator m-auto" style="color: #e72525;"></i>
            </div>
            <h3>POS Support</h3>
            <p class="lead mb-0">Order Food Online is integrated with some 
            of the industry's popular POS systems, making your online 
            food ordering system work seamlessly.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
  
<!--city locations-->
  <section class="features-icons bg-light text-center">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/calgary_online-ordering.jpg" alt="Calgary Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Calgary<span class="span-text">&nbsp; Alberta</span></h2>
                <p class="description-text">Order Food in Calgary</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!-- city -->
  <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/toronto_food-ordering.jpg" alt="Toronto Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Toronto<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Toronto</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!-- city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/waterloo_food-ordering.jpg" alt="Waterloo Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Waterloo<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Waterloo</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!-- city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/kitchener_food-ordering.jpeg" alt="Kitchener Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Kitchener<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Kitchener</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!-- city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/edmonton_food-ordering.jpg" alt="Edmonton Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Edmonton<span class="span-text">&nbsp; Alberta</span></h2>
                <p class="description-text">Order Food in Edmonton</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!-- city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/halifax_food-ordering.jpg" alt="Halifax Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Halifax<span class="span-text">&nbsp; Nova Scotia</span></h2>
                <p class="description-text">Order Food in Halifax</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--  city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/mississauga_food-ordering.jpg" alt="Missisauga Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Mississauga<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Mississauuga</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!-- city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/guelph_food-ordering.jpg" alt="Guelph Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Guelph<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Guelph</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!-- city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/ottawa_food-ordering.jpg" alt="Ottawa Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Ottawa<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Ottawa</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!-- city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/london-food__ordering.jpg" alt="London Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">London<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in London</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!-- city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/vancouver_food-ordering.jpg" alt="Vancouver Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Vancouver<span class="span-text">&nbsp; BC</span></h2>
                <p class="description-text">Order Food in Vancouver</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/montreal_food-ordering.jpg" alt="Montreal Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Montreal<span class="span-text">&nbsp; Quebec</span></h2>
                <p class="description-text">Order Food in Montreal</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/saskatoon_food-ordering.jpeg" alt="Saskatoon Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Saskatoon<span class="span-text">&nbsp; SK</span></h2>
                <p class="description-text">Order Food in Saskatoon</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/Winnipeg_Food-Ordering.jpg" alt="Winnipeg Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Winnipeg<span class="span-text">&nbsp; Manitoba</span></h2>
                <p class="description-text">Order Food in Winnipeg</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/regina_food-ordering.jpg" alt="Regina Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Regina<span class="span-text">&nbsp; SK</span></h2>
                <p class="description-text">Order Food in Regina</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/hamilton_food-ordering.jpg" alt="Hamilton Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Hamilton<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Hamilton</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
   <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/oshawa_food-ordering.jpeg" alt="Oshawa Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Oshawa<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Oshawa</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/pickering_food-ordering.jpg" alt="Pickering Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Pickering<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Pickering</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/oakville-food_ordering.jpg" alt="Oakville Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Oakville<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Oakville</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
   <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/Niagara_Falls_Food-Ordering.jpg" alt="Niagara Falls Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Niagara Falls<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Niagara Falls</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
   <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/Kelowna_Food-Ordering.jpg" alt="Kelowna Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Kelowna<span class="span-text">&nbsp; BC</span></h2>
                <p class="description-text">Order Food in Kelowna</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/surrey-food_ordering.jpg" alt="Surrey Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Surrey<span class="span-text">&nbsp; BC</span></h2>
                <p class="description-text">Order Food in Surrey</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/North_York_Food-Ordering.jpg" alt="North York Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">North York<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in North York</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/Richmond_Hill_Food-Ordering.jpeg" alt="Richmond Hill Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Richmond Hill<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Richmond Hill</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
    <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/order_food_in-markham.jpg" alt="Markham Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Markham<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Markham</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
<!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/order_food_in-vaughan.jpg" alt="Vaughan Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Vaughan<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Vaughan</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/order_food_in-woodbridge.jpg" alt="Woodbridge Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Woodbridge<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Woodbridge</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/order_food_in-barrie.jpg" alt="Barrie Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Barrie<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Barrie</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/order_food_in_st-catharines.png" alt="St. Catharines Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">St. Catharines<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in St. Catharines</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/order_food_in-cambridge.png" alt="Cambridge Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Cambridge<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Cambridge</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
<!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/order_food-in-kingston.png" alt="Kingston Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Kingston<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Kingston</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/order_food_in-milton.png" alt="Milton Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Milton<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Milton</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/order-food-in-new_market.jpg" alt="New Market Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">New Market<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in New Market</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/order-food-in-thunder_bay.jpg" alt="Thunder Bay Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Thunder Bay<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Thunder Bay</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
<!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/order-food-in_sudbury.jpg" alt="Sudbury Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Sudbury<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Sudbury</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/order-food-in_sarnia.jpg" alt="Sarnia Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Sarnia<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Sarnia</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/order-food-in_scarborough.png" alt="Scarborough Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Scarborough<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Scarborough</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/order-food-in-stoney_creek.png" alt="Stoney Creek Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Stoney Creek<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Stoney Creek</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/order-food-in-quebec_city.png" alt="Quebec City Food Ordering"/>
              <figcaption>
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Quebec City<span class="span-text">&nbsp; Quebec</span></h2>
                <p class="description-text">Order Food in Quebec</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/order-food-in_richmond.png" alt="Richmond Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Richmond<span class="span-text">&nbsp; BC</span></h2>
                <p class="description-text">Order Food in Richmond</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/order-food-in_whitby.jpg" alt="Whitby Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Whitby<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Whitby</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/img/order-food-in_ajax.jpg" alt="Ajax Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Ajax<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Ajax</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/img/order-food-in-red_deer.jpg" alt="Red Deer Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Red Deer<span class="span-text">&nbsp; Alberta</span></h2>
                <p class="description-text">Order Food in Red Deer</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
    <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/img/order-food-in_lethbridge.jpg" alt="Lethbridge Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Lethbridge<span class="span-text">&nbsp; Alberta</span></h2>
                <p class="description-text">Order Food in Lethbridge</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
    <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/img/order-food-in_medicine-hat.jpg" alt="Medicine Hat Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Medicine Hat<span class="span-text">&nbsp; Alberta</span></h2>
                <p class="description-text">Order Food in Medicine Hat</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
      <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/img/order-food-in_chestermere.jpg" alt="Chestermere Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Chestermere<span class="span-text">&nbsp; Alberta</span></h2>
                <p class="description-text">Order Food in Chestermere</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
      <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/img/order-food-in_llyodminster.jpg" alt="Llyodminster Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Llyodminster<span class="span-text">&nbsp; Alberta</span></h2>
                <p class="description-text">Order Food in Llyodminster</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
     <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/order-food-in_medicine-hat.jpg" alt="Medicine Hat Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Medicine Hat<span class="span-text">&nbsp; Alberta</span></h2>
                <p class="description-text">Order Food in Medicine Hat</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
    <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/order-food-in-fort_mcmurray.jpg" alt="Fort McMurray Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Fort McMurray<span class="span-text">&nbsp; Alberta</span></h2>
                <p class="description-text">Order Food in Fort McMurray</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/order-food-in_victoria.jpg" alt="Victoria Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Victoria<span class="span-text">&nbsp; BC</span></h2>
                <p class="description-text">Order Food in Victoria</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/images/order-food-in_nanaimo.jpeg" alt="Nanaimo Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Nanaimo<span class="span-text">&nbsp; BC</span></h2>
                <p class="description-text">Order Food in Nanaimo</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/images/order-food-in_burnaby.jpg" alt="Burnaby Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Burnady<span class="span-text">&nbsp; BC</span></h2>
                <p class="description-text">Order Food in Burnady</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/images/Order-Food-in_Langley.jpg" alt="Langley Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Langley<span class="span-text">&nbsp; BC</span></h2>
                <p class="description-text">Order Food in Langley</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/images/Gatineau-Online_Ordering.jpg" alt="Gatineau Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Gatineau<span class="span-text">&nbsp; Quebec</span></h2>
                <p class="description-text">Order Food in Gatineau</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/images/Sherbrooke_Online-Ordering.jpg" alt="Sherbrooke Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Sherbrooke<span class="span-text">&nbsp; Quebec</span></h2>
                <p class="description-text">Order Food in Sherbrooke</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
   <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/images/Burlington_Online-Ordering.jpg" alt="Burlington Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Burlington<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Burlington</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/images/Trois-Rivie%CC%80res_food_ordering.jpeg" alt="Trois-Rivières Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Trois-Rivières<span class="span-text">&nbsp; Quebec</span></h2>
                <p class="description-text">Order Food in Trois-Rivières</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/images/Airdrie-Online_Ordering.png" alt="Airdrie Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Airdrie<span class="span-text">&nbsp; Alberta</span></h2>
                <p class="description-text">Order Food in Airdrie</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
    <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/images/Okotoks-Online_Ordering.png" alt="Okotoks Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Okotoks<span class="span-text">&nbsp; Alberta</span></h2>
                <p class="description-text">Order Food in Okotoks</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/images/Bragg_Creek_Online-Ordering.png" alt="Bragg Creek Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Bragg Creek<span class="span-text">&nbsp; Alberta</span></h2>
                <p class="description-text">Order Food in Bragg Creek</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/images/balzac-food_ordering.png" alt="Balzac Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Balzac<span class="span-text">&nbsp; Alberta</span></h2>
                <p class="description-text">Order Food in Balzac</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/images/st.johns-online_ordering.png" alt="St. John's Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">St. John's<span class="span-text">&nbsp; NL</span></h2>
                <p class="description-text">Order Food in St. John's</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/images/Brampton-Online_Ordering.png" alt="Brampton Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Brampton<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Brampton</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/images/high-river-online_ordering.png" alt="High River Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">High River<span class="span-text">&nbsp; Alberta</span></h2>
                <p class="description-text">Order Food in High River</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/images/kamloops-food_ordering.png" alt="Kamloops Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Kamloops<span class="span-text">&nbsp; BC</span></h2>
                <p class="description-text">Order Food in Kamloops</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
   <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/images/banff-food_ordering.png" alt="Banff Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Banff<span class="span-text">&nbsp; Alberta</span></h2>
                <p class="description-text">Order Food in Banff</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/images/canmore-food_ordering.png" alt="Canmore Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Canmore<span class="span-text">&nbsp; Alberta</span></h2>
                <p class="description-text">Order Food in Canmore</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
    <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/images/brantford-food_ordering.png" alt="Brantford Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Brantford<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Brantford</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
   <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/images/Timmins-food_ordering.png" alt="Timmins Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Timmins<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Timmins</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
   <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/images/georgetown-food_ordering.png" alt="Georgetown Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Georgetown<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Georgetown</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/images/woodstock_food-ordering.png" alt="Woodstock Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Woodstock<span class="span-text">&nbsp; Ontario</span></h2>
                <p class="description-text">Order Food in Woodstock</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  <!--city -->
   <div class="col-lg-4">
         <div class="features-icons-item mx-auto mb-0 mb-lg-3">
          <figure class="snip1190">
            <img src="https://aws-website-amp-bbq2v.s3.amazonaws.com/images/order-food-in-brandon.jpg" alt="Brandon Food Ordering">
                <div class="square">
                <div></div>
                </div>
              <h2 class="text-1" style="font-size: 24px;">Brandon<span class="span-text">&nbsp; Manitoba</span></h2>
                <p class="description-text">Order Food in Manitoba</p>
            </figcaption>
          <a href="#"></a>
        </figure>
    </div>
  </div>
  </div>
</div>
</section>
<!--/end city locations-->


  <!-- Testimonials -->
  <section class="testimonials text-center bg-light">
    <div class="container">
      <h2 class="mb-5">What people are saying...</h2>
      <div class="row">
        <div class="col-lg-4">
          <div class="testimonial-item mx-auto mb-5 mb-lg-0">
            <img class="img-fluid rounded-circle mb-3" src="https://aws-website-amp-bbq2v.s3.amazonaws.com/testimonial-image-1.png" alt="">
            <h5>Margaret E.</h5>
            <p class="font-weight-light mb-0">"Lots of Great features for Food Ordering Platform."</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="testimonial-item mx-auto mb-5 mb-lg-0">
            <img class="img-fluid rounded-circle mb-3" src="https://aws-website-amp-bbq2v.s3.amazonaws.com/testimonial-image-2.png" alt="">
            <h5>Fred S.</h5>
            <p class="font-weight-light mb-0">"I used Order Food Online, and the service was amazing."</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="testimonial-item mx-auto mb-5 mb-lg-0">
            <img class="img-fluid rounded-circle mb-3" src="https://aws-website-amp-bbq2v.s3.amazonaws.com/testimonial-image-3.png" alt="">
            <h5>Sarah W.</h5>
            <p class="font-weight-light mb-0">"I'm a small restaurant in Milton signed up for services! Great Features."</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Call to Action -->
  <section class="call-to-action text-white text-center">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-xl-9 mx-auto">
          <h2 class="mb-4">Ready to get started? Sign up now!</h2>
        </div>
        <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
            <div class="form-row">
              <div class="col-12 col-md-3">
                  <a href="/register">
                <button type="submit" class="btn btn-block btn-lg btn-primary">Sign up!</button>
                </a>
              </div>
            </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer bg-light">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
          <ul class="list-inline mb-2">
            <li class="list-inline-item">
              <a href="about">About</a>
            </li>
            <li class="list-inline-item">&sdot;</li>
            <li class="list-inline-item">
              <a href="contact">Contact</a>
            </li>
            <li class="list-inline-item">&sdot;</li>
            <li class="list-inline-item">
              <a href="terms-of-use">Terms of Use</a>
            </li>
            <li class="list-inline-item">&sdot;</li>
            <li class="list-inline-item">
              <a href="privacy-policy">Privacy Policy</a>
            </li>
          </ul>
          <p class="text-muted small mb-4 mb-lg-0">&copy; Order Food Online <script>document.write(new Date().getFullYear());</script>. All Rights Reserved.<a href="sitemap">Sitemap</a></p>
        </div>
        <div class="col-lg-6 h-100 text-center text-lg-right my-auto">
          <ul class="list-inline mb-0">
            <li class="list-inline-item mr-3">
              <a href="#">
                <i class="fa fa-facebook fa-2x fa-fw"></i>
              </a>
            </li>
            <li class="list-inline-item mr-3">
              <a href="#">
                <i class="fa fa-twitter-square fa-2x fa-fw"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="#">
                <i class="fa fa-instagram fa-2x fa-fw"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="/stylesheets/jquery.min.js"></script>
  <script src="/stylesheets/bootstrap.bundle.min.js"></script>

</body>

</html>

<?php
 
}
?>
