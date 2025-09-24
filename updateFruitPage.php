<?php
	session_start();
	// Redirect the user to login page if he is not logged in.
	if(!isset($_SESSION['login'])){
		header('Location: login.php');
		exit();
	}
	
	require_once('api/constants.php');
	require_once('api/db.php');
	require_once('header.html');
?>
<body class="g-sidenav-show bg-gray-100">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="index.php">
        <span class="ms-1 font-weight-bold">100% Fruity Inventory System</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="v-pills-tab" role="tablist" aria-orientation="vertical">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" id="v-pills-dashboard-tab" href="index.php">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-heart-fill" viewBox="0 0 16 16">
            <path d="M7.293 1.5a1 1 0 0 1 1.414 0L11 3.793V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v3.293l2.354 2.353a.5.5 0 0 1-.708.707L8 2.207 1.354 8.853a.5.5 0 1 1-.708-.707L7.293 1.5Z"/>
            <path d="m14 9.293-6-6-6 6V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9.293Zm-6-.811c1.664-1.673 5.825 1.254 0 5.018-5.825-3.764-1.664-6.691 0-5.018Z"/>
            </svg>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item" >
          <a class="nav-link" id="v-pills-customer-tab" href="customerPage.php">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-heart" viewBox="0 0 16 16">
            <path d="M9 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h10s1 0 1-1-1-4-6-4-6 3-6 4Zm13.5-8.09c1.387-1.425 4.855 1.07 0 4.277-4.854-3.207-1.387-5.702 0-4.276Z"/>
            </svg>
            </div>
            <span class="nav-link-text ms-1">Customer</span>
          </a>
        </li>
        <li class="nav-item">
		  <a class="nav-link" id="v-pills-sale-tab" href="salePage.php">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus-fill" viewBox="0 0 16 16">
            <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zM9 5.5V7h1.5a.5.5 0 0 1 0 1H9v1.5a.5.5 0 0 1-1 0V8H6.5a.5.5 0 0 1 0-1H8V5.5a.5.5 0 0 1 1 0z"/>
            </svg> 
            </div>
            <span class="nav-link-text ms-1">Sale</span>
          </a>
        </li>
        <li class="nav-item" >
          <a class="nav-link active" id="v-pills-fruits-tab" href="fruitPage.php">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
            <path d="M336 128c-32 0-80.02 16.03-112 32.03c-32.01-16-79.1-32.02-111.1-32.03C32 128 .4134 210.5 .0033 288c-.5313 99.97 63.99 224 159.1 224c32 0 48-16 64-16c16 0 32 16 64 16c96 0 160.4-122.8 159.1-224C447.7 211.6 416 128 336 128zM320 32V0h-32C243.8 0 208 35.82 208 80v32h32C284.2 112 320 76.18 320 32z"/>
            </svg>
            </div>
            <span class="nav-link-text ms-1">Fruit</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account</h6>
        </li>  
        <li class="nav-item">
          <a class="nav-link" href="profile.php">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-square" viewBox="0 0 16 16"> 
            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/> <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12z"/> 
            </svg>
            </div>
            <span class="nav-link-text ms-1">Profile</span>
          </a>
        </li>
      </ul>
    </div>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Update Fruit</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Update Fruit</h6>
        </nav>
          <ul class="navbar-nav  justify-content-end">
            <li class="nav-item d-flex align-items-center">
              <a href="profile.php" class="nav-link text-body font-weight-bold px-0">
                <i class="fa fa-user fa-lg me-sm-2"></i>
                <span class="d-sm-inline d-none"><?php echo $_SESSION['username']?></span>
              </a>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="logout.php" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-sign-out fa-lg cursor-pointer"></i>
              </a>
          </li>
          </ul>
      </div>
    </nav>
    <!-- Page Content -->
    <div class="container-fluid">
	  <div class="row">
		 <div class="col-lg-10">
			<div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="v-pills-item" role="tabpanel" aria-labelledby="v-pills-item-tab">
				<div class="card card-outline-secondary my-4">
				  <div class="card-header">Update Fruit Details</div>
				  <div class="card-body">
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#fruitDetailsTab">Fruit</a>
						</li>
					</ul>				
					<div class="tab-content">
						<div id="fruitDetailsTab" class="container-fluid tab-pane active">
							<br>
							<div id="fruitDetailsMessage"></div>
								<div class="form-row">
                                <form id="updateFruit"> 
                                <div class="form-group col-md-3">
								  <label for="fruitDetailsItemNumber">Fruit ID<span class="requiredIcon">*</span></label>
								  <input type="text" class="form-control" name="fruitDetailsItemNumber" id="fruitDetailsItemNumber" autocomplete="off">
								  <div id="fruitDetailsItemNumberSuggestionsDiv" class="customListDivWidth"></div>
								</div>
							  </div>
							  <div class="form-row">
								  <div class="form-group col-md-6">
									<label for="fruitDetailsItemName">Fruit Name<span class="requiredIcon">*</span></label>
									<input type="text" class="form-control" name="fruitDetailsItemName" id="fruitDetailsItemName" autocomplete="off">
									<div id="fruitDetailsItemNameSuggestionsDiv" class="customListDivWidth"></div>
								  </div>
							  </div>
							  <div class="form-row">
                              <div class="form-group col-md-3">
                                <label for="fruitDetailsAmount">Amount</label>
                                <input type="text" class="form-control invTooltip" id="fruitDetailsAmount" name="fruitDetailsAmount" title="This will be auto-generated when you add a new vendor" autocomplete="off">
                                </div>
								<div class="form-group col-md-3">
									<label for="fruitDetailsPrice">Price<span class="requiredIcon">*</span></label>
									<input type="text" class="form-control invTooltip" id="fruitDetailsPrice" name="fruitDetailsPrice" title="Do not enter leading 0">
								</div>	
								<div class="form-group col-md-3">
									<div id="imageContainer"></div>
								</div>
							  </div>
							  <input type="submit" id="updateButton" class="btn btn-primary" value="Update Fruit">
							<button type="button" id="deleteFruitButton" class="btn btn-danger">Delete</button>
							<button type="reset" class="btn">Clear</button>
							</form>
						</div>
					</div>
				  </div> 
				</div>
			  </div>
		</div>
		</div>
		<footer class="footer pt-">
        <div class="container-fluid">
            <div class="col-lg-6 mb-lg-10 mb-10">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script>,
                made with <i class="fa fa-heart"></i> by Full House
                for <a class="font-weight-bold" href="index.php">100% Fruity Inventory System</a>
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </main>
<script src="api/assets/js/fruit.js"></script>
<script>
    $("#updateFruit").submit(function (event) {
        event.preventDefault();
        var formData = $(this).serialize();
        var id = document.getElementById('fruitDetailsItemNumber').value;
        $.ajax({
            type: "PUT",
            url: "http://localhost/100Fruity/api/fruit/" + id,
            data: formData,
            dataType: "json",
            success: function (data) {
				var result = $.parseJSON(data);
			$('#fruitDetailsMessage').fadeIn();
			$('#fruitDetailsMessage').html(result.alertMessage);

                if (data > 0) {
                    window.location.href = "fruitPage.php";
                } 
            },
            error: function (xhr, resp, text) {
				$('#fruitDetailsMessage').fadeIn();
				$('#fruitDetailsMessage').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>');
            },
        });
    });

	$('#deleteFruitButton').on('click', function () {
		// Confirm before deleting
		bootbox.confirm('Are you sure you want to delete?', function (result) {
			if (result) {
				deleteFruit();
			}
		});
	});

	// Function to deelte item from db
	function deleteFruit() {
		// Get the item number entered by the user
		var itemDetailsItemNumber = $('#fruitDetailsItemNumber').val();
		if (itemDetailsItemNumber != '') {
		$.ajax({
			url: "http://localhost/100Fruity/api/fruit/" + itemDetailsItemNumber,
			method: 'DELETE',
			success: function (data) {
				
				$('#fruitDetailsMessage').fadeIn();
				$('#fruitDetailsMessage').html(data);
			},error: function (xhr, resp, text) {
                $('#fruitDetailsMessage').fadeIn();
				$('#fruitDetailsMessage').html( xhr.responseText);
            },
			complete: function () {
			}
		});
	}
}
</script>
  </body>
</html>