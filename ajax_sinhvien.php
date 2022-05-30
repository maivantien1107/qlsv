<?php 
	require_once("config.php");
	
	// kiểm tra trường hợp lấy thông tin SV
	
	if (isset($_REQUEST["Type"])){
		if ($_REQUEST["Type"]== "getInfo"){
			$masv = $_REQUEST["MaSV"];
			$sql = "SELECT * FROM dbo_sinhvien WHERE MaSV='".$masv."'";
			$result = $db->query($sql);
			if ($result){
				echo  json_encode($result->fetch_array( ));
			}else{
				echo  json_encode(null);
			}
			
			exit();
		}
		
		if ($_REQUEST["Type"]== "Update"){
			$masv = $_REQUEST["MaSV"];
			$hoten = $_REQUEST["HoTen"];
			$ngaysinh = $_REQUEST["NgaySinh"];
			$kihoc= $_REQUEST["KiHoc"];
			$gioitinh = $_REQUEST["GioiTinh"];
			$quequan = $_REQUEST["QueQuan"];
			$password = md5($_REQUEST["Password"]);
			$email = $_REQUEST["Email"];
			
			
			$sql = "UPDATE dbo_sinhvien SET Hoten='".$hoten."', 
					 	 NgaySinh='".$ngaysinh."', GioiTinh=".$gioitinh.",
					 	QueQuan='".$quequan."', Password='".$password."', Email='".$email."' 
					 WHERE MaSV='".$masv."'";
			 
			$result = $db->query($sql);
			
			if ($result && $db->affected_rows > 0){
				echo "OK";
			}else{
				echo "ERROR";
			}
			
			exit();
		}
		
	}
	
	//kiểm tra trường hợp xóa 1 dòng
	if (isset($_REQUEST["MaSV"])){
		$masv = $_REQUEST["MaSV"];
		$sql = "DELETE FROM dbo_sinhvien WHERE MaSV='".$masv."'";
		$result = $db->query($sql);
		if ($result && $db->affected_rows > 0){
			echo "OK";
		}else{
			echo "ERROR";
		}
		
		exit();
	}
	
	$maLop="";
	// lấy mã lớp chọn từ DropDownList
	if (isset($_REQUEST["MaLop"])){
		  $maLop= $_REQUEST["MaLop"];
	
	}
	$limit = 10;
	$last = $limit;
	if (isset($_POST["Last"])){
		$last= $_POST["Last"]+$limit;
	}
	
	 
	$sql = "SELECT COUNT(*) FROM dbo_sinhvien WHERE MaLop='".$maLop."'";
	$result = $db->query($sql);
	$total_row = 0;
	if ($result){
		$row = $result->fetch_array();
		$total_row = $row[0];
	}
	
	
	$sql = "SELECT * FROM dbo_sinhvien WHERE MaLop='".$maLop."' LIMIT 0, $last";
	$result = $db->query($sql);
	// nếu có dữ liệu thì hiển thị danh sách
		
	if ($result && $result->num_rows>0){
	?>
	
	<table class="ds">
			<!-- in tiêu đề danh sách -->
			<thead>
				<tr class="ui-widget-header">
					<th><input type="checkbox" id="checkAll"/></th>
					<th>STT</th>
					<th>MSSV</th>
					<th>Họ tên</th>
					<th>Kỳ học</th>
					<th>Ngày Sinh</th>
					<th>Quê quán</th>
					<th>Email</th>
					<th></th>
				</tr>
			</thead>
			<!-- end in tiêu đề-->
			<!-- inh danh dánh -->
			<tbody>
				<?php
				$i = 0;
				while ( $row = $result->fetch_array () ) {
					echo "<tr class='trsv' >";
					echo "<td><input name='chkmasv[]'  value='" . $row ["MaSV"] . "' class='chkmasv' type='checkbox'/> </td>";
					echo "<td class='stt'>" . ++ $i . "</td>";
					echo "<td>" . $row ["MaSV"] . "</td>";
					echo "<td>" . $row ["HoTen"] . "</td>";
					echo "<td>" . $row ["KiHoc"] . "</td>";
					echo "<td>";
					$d = strtotime ( $row ["NgaySinh"] );
					echo date ( "d-m-Y", $d );
					echo "</td>";
					echo "<td>" . $row ["QueQuan"] . "</td>";
					echo "<td>" . $row ["Email"] . "</td>";
					echo "<td>";
					echo "<button  class='btnSua' name='MaSV' value='" . $row ["MaSV"] . "'><span class='ui-icon ui-icon-pencil' ></span></button>";
					echo "<button name='btnXoa' class='btnXoa' value='" . $row ["MaSV"] . "' ><span class='ui-icon ui-icon-trash'  ></span> </button>";
					echo "</td>";
					echo "</tr>";
				}
				$result->free ();
				?>
			</tbody>
			<!--  end in danh sách-->
		
			<!-- in footer của danh sách -->
			<tfoot>
				<tr>
					<td colspan="8"  >
						<div id="divThemImg" align="center" >
							<button id="btnLast"  style="display: none;" data-finish="
										<?php
											if ($last >= $total_row) {
												echo 1;
											}else{
												echo 0;
											}							
										?>
										"  value="<?php echo $last;?>" >
							</button>
						</div>
		
		
					</td>
				</tr>
			</tfoot>
			<!--  end in footer của danh sách -->
		</table>

<?php 
  }else{
  	echo "<div class='success'> Không có sv nào. </div>";
  }
?>