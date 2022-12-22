<!-- {lat: 37.7685329, lng: -97.2113605} 67226
{lat: 37.6290008, lng: -97.49765359999999} 67227
{lat: 37.7500219, lng: -97.1682514} 67228 -->

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>RegistrationForm_v7 by Colorlib</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- MATERIAL DESIGN ICONIC FONT -->
    <link rel="stylesheet" href="{{ asset('fonts/material-design-iconic-font/css/material-design-iconic-font.min.css') }}">
    
    <!-- STYLE CSS -->
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <script src="{{ asset('js/sweetalert2.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  </head>

  <body>

    <div class="wrapper">
      <div class="inner">
        <div action="#">
          <h3>Find Doctor</h3>
          <p>Tell us about your needs and we'll help you find the perfect doctor for you.</p>
          <label class="form-group">
            <input type="text" class="form-control" id="fname"  name="fname" required>
            <span for="fname">First Name:</span>
            <span class="border"></span>
          </label>
          <label class="form-group">
            <input type="text" class="form-control" id="lname" name="lname" required>
            <span for="lname">Last Name:</span>
            <span class="border"></span>
          </label>
          <label class="form-group">
            <select class="form-control" id="category" required>
            </select>
            <span for="category">Category:</span>
            <span class="border"></span>
          </label>
          <label class="form-group">
            <input type="text" class="form-control" id="email" name="email" required>
            <span for="email">Email:</span>
            <span class="border"></span>
          </label>
          <label class="form-group">
            <input type="text" class="form-control" id="phone" name="phone" required>
            <span for="phone">Phone:</span>
            <span class="border"></span>
          </label>
          <label class="form-group">
            <input type="text" class="form-control" id="zipcode" name="zipcode" required>
            <span for="zipcode">Zip Code:</span>
            <span class="border"></span>
          </label>
          <button id="search">Search 
            <i class="zmdi zmdi-arrow-right"></i>
          </button>
        </div>
      </div>
    </div>
  </body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>