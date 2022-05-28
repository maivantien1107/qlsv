<?php require "header.php"; ?>

<div class="group-box">
	<div align="center">
	<div class="title">Môn học</div>
	<div class="group-box-content">
		
	<?php 
		// kiểm tra xóa nhiều dòng
		/* if (isset($_POST["btnXoaTatCa"]) && isset($_POST["chkmasv"])){
			$in = "''"; 
			foreach($_POST["chkmasv"] as $val){				
				$in .= ",'".$val."'";			 
			}
			$sql = "DELETE FROM dbo_sinhvien WHERE MaSV IN(".$in.")";
			
			$result = $db->query($sql);
			if ($result && $db->affected_rows > 0){ 
				echo "<div class='success'>Đã xóa thành công</div>";
			}else{
				echo "<div class='error'>Có lỗi xảy ra khi xóa.</div>";
			}		
		} */
		
			
	?>
		<form method="post" name="frmSV" action="<?php echo $_SERVER["PHP_SELF"];?>">			
			<label>Chọn trường:</label>
			<select name="MaTruong" id="DSTruong" >
				<option value="">--Chọn--</option>
				<?php 
				// IN danh sách lớp
				$sql ="SELECT * FROM dbo_truong ";
				$result = $db->query($sql);
				if ($result){
					while($row = $result->fetch_array()){
						echo "<option value='".$row["MaTruong"]."' >".$row["TenTruong"]."</option>";
					}
				}
				$result->free();
				?>
				<script>
					jQuery(document).ready(function($){
						$("#DSTruong").change(function(event){
							idtruong=$("#DSTruong").val();
							$.post('ajax_monhoc.php',{"idtruong":idtruong},function(data){
								$("#divDSMH").html(data);
							})
						})
					})
				</script>						
			</select> &nbsp;&nbsp;		 
			<span id="divImgMH" ></span>
			<br />			
			<hr>
			 
			<div id="divDSMH" ></div>
			
			<div id="delDialogMH">
				<p> </p>
			</div>
			
			<div id="errDialogMH">
				<p> </p>
			</div>
			
			
		<!--  form này không có tác dụng gì, chỉ dùng để chỉ ra nút Sửa ở cột bên phải bảng
		thuộc về form này, mục đích là không cho post dữ liệu dư thừa khi nhấn nút Sửa, vì chỉ cần giá trị
		trong thuộc tính value của nút Sửa sử dụng tag <button>  -->	
		</form>
		<form id="frmNoAction1">
		</form>
		
		
		<div id="dialogUpdateSV">
				<p id="info"></p>
				
				<label for="txtMaLop">Mã Lớp:</label>
				<input type="text" id="txtMaLop" name="txtMaLop" disabled /> <br />
				
				<label for="txtMaSV">Mã SV:</label>
				<input type="text" id="txtMaSV" name="txtMaSV" disabled /> <br />
				
				<label for="txtHoLot">Họ Tên:</label>
				<input type="text" id="txtHoTen" name="txtHoTen" /> <br />
				
				<label for="txtNgaySinh">Ngày Sinh:</label>
				<input type="text" id="txtNgaySinh" name="txtNgaySinh" /> <br />
				
				<label for="rdoGioiTinh">Giới tính:</label>
				 
				<input type="radio" id="rdoNam" name="rdoGioiTinh[]" value="1" checked />
					<span>Nam</span>
				<input type="radio" id="rdoNu" name="rdoGioiTinh[]" value="0" /> 
					<span>Nữ</span>
				<p></p>  								   
				  
				  Quê Quán:
				<textarea id="txtQueQuan" name="txtQueQuan" cols="40" rows="4"></textarea> <br />
				
				<label for="txtMatKhau">Mật khẩu:</label>
				<input type="password" id="txtMatKhau" name="txtMatKhau" /> <br />
				
				<label for="txtEmail">Email:</label>				
				<input type="text" id="txtEmail" name="txtEmail" /> <br />
				
			</div>
	 <p> </p>
	 </div>
	 </div>
</div>		
<?php require "footer.php"; ?>