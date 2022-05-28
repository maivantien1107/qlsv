<?php 
require "header.php";?>

<div class="group-box">
	
	<div class="title">Đăng nhập</div> 
	<div align="center">
	<?php 
	// nếu nút Logout được nhấn
	if (isset($_GET["logut"])){
		// hủy bỏ session
		unset($_SESSION["loggedin"]);
		unset($_SESSION["User"]);
		unset($_SESSION["HoTen"]);
		unset($_SESSION["Type"]);
		// xóa cookies
		setcookie("User","",time()-3600);
		setcookie("Password","",time()-3600);
		setcookie("Type","",time()-3600);
		// chuyển đến trang login 
		header("location: login.php");
		exit();
	}
	
	// trong trường hợp đã đăng nhập, chuyển đến trang index
	if(isset($_SESSION["loggedin"])){
		header("location: index.php");
		exit();
	} 
		// trường hợp đã nhớ mật khẩu trước đó
		// gọi hàm auto_login() trong thư viện libs/common.php
		// hàm này được gọi trong file header.php để đảm bảo khi truy cập vào
		// trang nào cũng tự đăng nhập, không nhất thiết là vào login.php mới tự đăng nhập
		
		//auto_login();
		 
	 
	
	
	
	
	// trường hợp chưa đăng nhập, không lưu cookie trước đó
	// nếu người dùng nhấn nút "Đăng nhập"
	if (isset($_POST["btnDangNhap"])){
		$user = $_POST["txtTenDangNhap"];
		$pass = $_POST["txtMatKhau"];
		$type = $_POST["rdodn"];
		
		if ($type == "sv"){
			$sql = "SELECT MaSV as User, HoTen, Password ".
				" FROM dbo_sinhvien WHERE MaSV='".$user."' ".
					" AND Password ='".md5($pass)."'";
		}else{
			$sql = "SELECT MaGV as User, HoTen, Password  ".
					" FROM dbo_giangvien WHERE MaGV='".$user."' ".
					" AND Password ='".md5($pass)."'";
		}
		 
		$result = $db->query($sql);
		// nếu xác thực thành công
		if($row = $result->fetch_array()){	
			// tạo session		 
			$_SESSION["loggedin"]= true;
			$_SESSION["User"] = $row["User"];
			$_SESSION["HoTen"] = $row["HoTen"];
			$_SESSION["Type"] = $type;
			
			// nếu người dùng chọn "Nhớ mật khẩu"
			if (isset($_POST["chkNhoMK"])){
				setcookie("User",$row["User"],time()+3600*24 );
				setcookie("Password",$row["MatKhau"],time()+3600*24);
				setcookie("Type",$type,time()+3600*24);
				 
			}
			header("location: index.php");
				
		}else{ // trường hợp nhập username và password không đúng
			
			// hiển thị thông báo lỗi, link đến trang đăng nhập lại
			echo "<div class='error'><br><div align='center'>Tên đăng nhập và mật khẩu không hợp lệ. <br>";
			echo " <a href='".$_SERVER["PHP_SELF"]."'> Thử lại </a> </div> </div><br>";
		}
	}else { // trong trường hợp lần đầu tiên mở form hoặc đã nhấn logout thì hiển thị form đăng nhập	
	?>	
	<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" name="frmLogin">
		<br>		 
		<table class=frm>
		<tr> 
			<td align="right"><label for="txtTenDangNhap"> Tên Đăng nhập: </label> </td>
			<td align="left"><input type="text" name="txtTenDangNhap" placeholder="tên đăng nhập"> </td>
		</tr>
		<tr>
			<td align="right"> <label for="txtMatKhau"> Mật khẩu: </label></td>
			 <td align="left"> <input type="password" name="txtMatKhau" placeholder="mật khẩu"> <br /> </td>
		</tr>		
		<tr>
			<td>  &nbsp; </td>				
			<td> <input type="radio" name="rdodn" value="sv" checked>Sinh Viên 
				 <input type="radio" name="rdodn" value="gv" >Giảng Viên 
			  </td>
		</tr>
		<tr>
			<td> &nbsp; </td> 
			<td><input type="checkbox" name="chkNhoMK" value=1> Nhớ mật khẩu?  </td>
		</tr>
		<tr>
			<td> &nbsp; </td> 
			<td> <button type="submit" name="btnDangNhap" class="btn" >Đăng nhập</button></td>
		</tr>
		</table>		 
		<br>
	</form>	
<?php 
	} // else 
	
?>
	</div>
</div>

<?php require "footer.php";?>