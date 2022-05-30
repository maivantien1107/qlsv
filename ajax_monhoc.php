<?php
require_once("config.php");
if (isset($_REQUEST["Type"])){
    if ($_REQUEST["Type"]== "getInfo"){
        $mamh = $_REQUEST["MaMH"];
        $sql = "SELECT * FROM dbo_monhoc WHERE MaMH='".$mamh."'";
        $result = $db->query($sql);
        if ($result){
            echo  json_encode($result->fetch_array( ));
        }else{
            echo  json_encode(null);
        }
        
        exit();
    }
    
    if ($_REQUEST["Type"]== "Update"){
        $mamh = $_REQUEST["MaMH"];
        $tenmh = $_REQUEST["TenMH"];
        $sotc = $_REQUEST["SoTC"];
        $kihoc = $_REQUEST["KyHoc"];
        
        
        $sql = "UPDATE dbo_monhoc SET TenMH='".$tenmh."', 
                      SoTC='".$sotc."', KyHoc='".$kihoc."',
                 WHERE MaMH='".$mamh."'";
         
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
if (isset($_REQUEST["MaMH"])){
    $mamh = $_REQUEST["MaMH"];
    $sql = "DELETE FROM dbo_monhoc WHERE MaMH='".$mamh."'";
    $result = $db->query($sql);
    if ($result && $db->affected_rows > 0){
        echo "OK";
    }else{
        echo "ERROR";
    }
    
    exit();
}

$matrg=$_POST["idtruong"];
// lấy mã lớp chọn từ DropDownList
// if (isset($_REQUEST["MaTruong"])){
//       $matrg= $_REQUEST["MaTruong"];
      
// }

 
$limit = 10;
$last = $limit;
if (isset($_POST["Last"])){
    $last= $_POST["Last"]+$limit;
}

 
$sql = "SELECT COUNT(*) FROM dbo_monhoc WHERE MaMH like '$matrg%'";
$result = $db->query($sql);
$total_row = 0;
if ($result){
    $row = $result->fetch_array();
    $total_row = $row[0];
}


$sql = "SELECT * FROM dbo_monhoc WHERE MaMH like'$matrg%' LIMIT 0, $last";
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
                <th>Mã môn học</th>
                <th>Tên môn học</th>
                <th>Số tín chỉ</th>
                <th>Kì học dự kiến</th>
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
                echo "<td><input name='chkmasv[]'  value='" . $row ["MaMH"] . "' class='chkmasv' type='checkbox'/> </td>";
                echo "<td class='stt'>" . ++ $i . "</td>";
                echo "<td>" . $row ["MaMH"] . "</td>";
                echo "<td>" . $row ["TenMH"] . "</td>";
                echo "<td>" . $row ["SoTC"] . "</td>";
                echo "<td>" . $row ["KyHoc"] . "</td>";
                echo "<td>";
                echo "<button  class='btnSuaMH' name='MaMH' value='" . $row ["MaMH"] . "'><span class='ui-icon ui-icon-pencil' ></span></button>";
                echo "<button name='btnXoa' class='btnXoa' value='" . $row ["MaMH"] . "' ><span class='ui-icon ui-icon-trash'  ></span> </button>";
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
  echo "<div class='success'> Không có môn học nào. </div>";
}
?>