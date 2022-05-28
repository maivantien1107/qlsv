<?php session_start();?>
<!doctype html>
<html>
<head>
	
	<?php require_once("config.php");?>
		
	<?php 
		if (!isset($_SESSION["loggedin"])){
			auto_login();
		}
	
	?>
	
	<title><?php echo $page_title; ?></title>
	<meta charset="utf-8"> 
	<meta name="keywords" content="<?php echo $page_keywords; ?>" />
	<meta name="description" content="<?php echo $page_description; ?>" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />	
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.10.2.custom.js"></script>
	<link rel="stylesheet" 	href="css/ui-lightness/jquery-ui-1.10.2.custom.css" />
<!-- 	<link rel="stylesheet" 	href="css/jmetro/jquery-ui-1.10.2.custom.css" /> -->
    
</head>
<body>
	<div id="pageWrapper">
		<div id="header">
			<!-- <img id="logo" src="<?php echo IMAGES_DIR;?>/logo.png" alt="Trường CNTT&TT" /> -->
			<h1 id="siteTitle"> Trường đai học Bách Khoa Hà Nội</h1>
				
		</div> <!-- End of header -->
		
		<div id="nav"> 
		<div  id="menu" > 
			<a href="index.php">Trang chủ</a> |  
			<a href="timkiem.php">Tìm kiếm</a>	|
			<a href="gioithieu.php">Giới thiệu</a>		 
		</div>		 
		<div  id="login" > 
			<?php 
				// lấy cookie đăng nhập tự động
				 
				if (isset($_SESSION["loggedin"])){
					echo "Xin chào ". $_SESSION["HoTen"];
					echo " | <a href='login.php?logut' id='aLogout'>Thoát</a>";	
				}else {
					
					echo "<a href='login.php'>Đăng nhập</a>";
				}
			?>
		</div>
		</div> <!-- End of Navigation menu --> 
		
		<div id="contentWrapper" > 
			<div id="leftSide" > 
				<div class="group-box" id="danhmuc"> 
						<div class="title">DANH MỤC</div>  
						<div class="group-box-content">
							<ul>								
								<li> <a href="khoa.php"> Khoa - Viện</a> </li>
								<li> <a href="giangvien.php">Giảng Viên</a> </li>
								<li> <a href="sinhvien.php">Sinh Viên</a> </li>
								<li> <a href="nganh.php">Ngành Đào Tạo</a> </li>
								<li> <a href="lopchuyennganh.php">Lớp Chuyên Ngành</a> </li>
								<li> <a href="lophocphan.php">Lớp Học Phần</a> </li>
								<li> <a href="monhoc.php">Môn Học</a> </li>
							</ul>						
						</div>						
				</div>
				<div class="group-box"> 
						<div class="title">Menu</div> 
						<div class="group-box-content">
						<ul>							
							<li> <a href="index.php">Chức năng 1</a> </li>
							<li> <a href="index.php">Chức năng 2</a> </li>
							<li> <a href="index.php">Chức năng 3</a> </li>
							<li> <a href="index.php">Chức năng 4</a> </li>
							<li> <a href="index.php">Chức năng 5</a> </li>
							<li> <a href="index.php">Chức năng 6</a> </li>
							<li> <a href="index.php">Chức năng 7</a> </li>
						</ul>						
						</div>						
				</div>				 
			</div> <!-- End of Left Side -->
		<div id="mainContent">
				
