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
        <div id="search-page">
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
        <div id="congrate-page" style="display: none;">
          <h3>Congrats!</h3>
          <p>We found one listing that matches your needs and have notified the listing on your behalf. Please wait to be contacted by them.</p>
          <div style="padding: 0 100px;">
            <div style="text-align: center;">
              <span>Match ID:</span>
              <span id="match-id"></span>
            </div>
            <div style="text-align: center;">
              <span>Name:</span>
              <span id="match-name"></span>
            </div>
            <div style="text-align: center;">
              <span>Email:</span>
              <span id="match-email"></span>
            </div>
            <div style="text-align: center;">
              <span>Zipcode:</span>
              <span id="match-zipcode"></span>
            </div>
            
          </div>
          <a href="javascript:void(0)" id="list-view" style="text-decoration: none;"><button>Matched List</button></a> 
        </div>
        <div id="oops-page" style="display: none;">
          <h3>Oops!</h3>
          <p>We not find listing that matched your needs.</p>
          <!-- <button id="list-view">Matched List</button> -->
        </div>
      </div>
    </div>
  <script type="text/javascript">
    var prefix_api = 'http://localhost/directory/'
  	$(document).ready(function() {
  		$.get('/get-category').then(res => {
  			console.log(res);
  			if (res.success) {
  				let html = '<option value="" selected disabled></option>';
  				for (var i = 0; i < res.data.length; i++) {
  					html += `<option value="${res.data[i]['term']['term_id']}">${res.data[i]['term']['name']}</option>`;
  				}
  				$('#category').html(html);
  			}
  		})
  		$('#search').click(async function() {
  			const category = $('#category').val();
  			const zipcode = $('#zipcode').val();
  			const fname = $('#fname').val();
  			const lname = $('#lname').val();
  			const email = $('#email').val();
  			const phone = $('#phone').val();
  			if (!category) {
          Swal.fire({
            title: 'Error!',
            text: 'Please select the category.',
            icon: 'error',
            confirmButtonText: 'Close'
          })
  				return false;
  			}
  			if (!zipcode) {
          Swal.fire({
            title: 'Error!',
            text: 'Please enter zipcode.',
            icon: 'error',
            confirmButtonText: 'Close'
          })          
  				return false;
  			}
        const location = await $.post('https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyB2w8uO-1kgltGqGzOp9QZOW55a99tSw9E&address='+zipcode+'&sensor=false')
        .then(res => {
        		console.log(res);
        	if (res.status === "OK") {
              return res.results[0].geometry.location;
        	} else {
        		return null;
        	}
        })
        console.log(location);
        if (!location) {
          Swal.fire({
            title: 'Error!',
            text: 'Please enter valid zipcode.',
            icon: 'error',
            confirmButtonText: 'Close'
          })          
          return false;                
        }
        const data = {
        	'fname': fname,
        	'lname': lname,
        	'category': 11,
        	'phone': phone,
        	'email': email,
        	'zipcode': zipcode,
        	location: location,
        }
        $.post('/search-list', data).then(function(res) {
        	console.log(res);
          $('#search-page').css('display', 'none');
          if (res.success) {
            $("#list-view").attr('href', res.list.guid)
            $('#match-id').html(res.data);
            $('#match-name').html(res.list.post_name);
            $('#match-email').html(res.list.email);
            $('#match-zipcode').html(res.list.zipcode);
            $('#congrate-page').css('display', 'block');
          } else {
            $('#oops-page').css('display', 'block');
          }
        })
  		})
  	})
  </script>

  </body>
</html>