<?php require "header.php"; 

?>

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
								$(".btnXoa, .btnSuaMH").hide();
							})
						})
					});
    // xử lý load thêm danh sách môn học
	$(window).scroll(function(){		 
		 loadMore();
		
	 });
	 
	 function loadMore(){
		 var lastPos = 0;
		 var isLoaded = false;
		 
		 try{
			 lastPos = $("#btnLast").offset().top ;
			 isLoaded = true;
			 
		 }catch(e){
			 isLoaded = false; 
		 }
		 
		 var finish = 0;
		 try{
			 finish = parseInt($("#btnLast").data("finish"));
		 }catch(e){
			 finish = 0;
		 }
		 		 
		 var top = ( $(window).scrollTop()  +  $(window).height());
		 
		 
		 if  ( isLoaded && top >= lastPos && !finish){
		 
		 	var url = "ajax_monhoc.php";
			var matrg = $("#svDSMH").val();			 
			var last = $("#btnLast").val().toString();	
			
			var param = {"MaTruong" : matrg , "Last" : last};
			 
			$.ajax({
				url:url,
				type: "POST",
				data: param,
				dataType: "HTML",			
				error: function(xhr,status,errmgs){
					$("#divDSMH").html("<div class='error'>Có lỗi xảy ra: " + errmgs + "</div>");
				},
				beforeSend: function(){
					$("#divThemImgMH").html("<img id='imgLoading' src='images/more_loading.gif' width='22' height='22'  />");
				},
				complete: function(){
					//$("#divThemImg").html(divInnerHTML);
				},
				success: function(data){
					$("#divDSMH").html(data);
					$(".btnXoaMH, .btnSuaMH").hide();
				}
				
			});
		 }
		 
	 }
	 
	 
	 function reLoad(){
		 
		 	var url = "ajax_monhoc.php";
			var matrg = $("#svDSMH").val();			 
			var last = $("#btnLast").val().toString();	
			
			var param = {"MaTruong" : matrg , "Last" : last};
			 
			$.ajax({
				url:url,
				type: "POST",
				data: param,
				dataType: "HTML",			
				error: function(xhr,status,errmgs){
					$("#divDSMH").html("<div class='error'>Có lỗi xảy ra: " + errmgs + "</div>");
				},
				beforeSend: function(){
					$("#divThemImgMH").html("<img id='imgLoading' src='images/more_loading.gif' width='22' height='22'  />");
				},
				complete: function(){
					//$("#divThemImg").html(divInnerHTML);
				},
				success: function(data){
					$("#divDSMH").html(data);
					$(".btnXoaMH, .btnSuaMH").hide();
				}
				
			});
		  
	 }
	// xử lý nút xóa

	$(document).on("click",".btnXoaMH",function(event){
		 var button = $(this);
		 var masv = $(button).val() ;
		 
		 var x = "Có chắc bạn muốn xóa " + mamh + " không?";
		 var dialog = $("#delDialogMH");
		 $(dialog).find("p").text(x);
		 
		 $(dialog).dialog({
			 closeOnEscape: true,
			 closeText: "Đóng",
			 resizable: false,
			 title: "Xác nhận",
			 show: {effect: "drop", duration: 200, direction: "up"},
		 	 hide: "slide",
		 	 modal: true,
		 	 buttons: [
				{
				 	html:"<span class='ui-icon ui-icon-trash'></span>",
				 	title: "Xóa",
				 	click: function(){
				 		$(dialog).dialog("close");	
				 		var url = "ajax_monhoc.php";							 			
						var param = {"MaMH":mamh};		
						$.ajax({
							url:url,
							type: "POST",
							data: param,
							dataType: "HTML",			
							error: function(xhr,status,errmgs){
								var err = "Có lỗi xảy ra: " + errmgs;
								showError(err);
								$(dialog).dialog("close");								
							},							 
							complete: function(){
								
							},
							success: function(data){
								if (data == "OK"){						 
									 $(button).parent().parent().remove();
									 $(".stt").each(function(index){
										 $(this).text(index + 1);
									 });
								}else{
									var err = "Không thể xóa môn học " + mamh;
									showError(err);
								}
							}
							
						});
							
					}
				},
		 		{
			 	 	html:"<span class='ui-icon ui-icon-cancel'></span>",
			 	 	title: "Hủy",
			 	 	id: "btnClose",
			 	 	click: function(){
						$(this).dialog("close");
				 	}
				}
			]
			 
		 });
		 event.preventDefault(); 
	 });
	 
		function showError(err){
			$("#errDialogMH").find("p").text(err);
			$("#errDialogMH").dialog({
				closeOnEscape: true,
				 closeText: "Đóng",
				 resizable: false,
				 
				 title: "Thông báo lỗi",
				 show: {effect: "drop", duration: 200, direction: "up"},
			 	 hide: "bounce",
			 	 buttons: [
			 	       {
			 	    	  text:"Đóng",					 	 	 
					 	 	click: function(){
								$(this).dialog("close");
						 	}
			 	       }    
			 	  ]
			});
		}
					//nút sửa môn học
	$(document).on("click",".btnSuaMH",function(event){
		var dialog = $("#dialogUpdateMH");
		
		var button = $(this);
		var mamh = $(button).val() ;		 
		var url = "ajax_monhoc.php";
		var imgEdit = $(button).html();
		var param = {"MaMH" : mamh , "Type" : "getInfo"};
		 
		$.ajax({
			url:url,
			type: "POST",
			data: param,
			dataType: "JSON",			
			error: function(xhr,status,errmgs){
				var err = "Có lỗi xảy ra khi lấy thông tin môn học " + mamh + " " + errmgs;
 				showError(err);
			},
			beforeSend: function(){
				$(button).html("<img id='imgLoading' src='images/more_loading.gif' width='20' height='14'  />");			 
			},
			complete: function(){
				$(button).html(imgEdit);
			},
			success: function(data){
				if (data){
					 $(dialog).find("#txtMaMH").val(data.MaMH);
					 $(dialog).find("#txtTenMH").val(data.TenMH);
					 $(dialog).find("#txtSoTC").val(data.SoTC);

					 $(dialog).find("#txtKyHoc").val(data.KyHoc);
					 $(dialog).dialog("open");					 
				 
				}else{
					showError("Môn học không tồn tại.");
				}
				
				 
				 
			}
			
		});
		$("#dialogUpdateMH").dialog({
	autoOpen:false,
	closeOnEscape: true,
	closeText: "Đóng",
	resizable: false,
	title: "Cập nhật thông tin",
	show: {effect: "drop", duration: 200, direction: "up"},
	hide: "slide",
	modal: true,
	width: 550,
	height: 600,
	buttons: [
				 {
					text:"Lưu",
					id: "btnLuu",
					click: function(){
						   $("#btnLuu").hide().before("<span id='spanUpdateLoading'><img src='images/more_loading.gif' width='26' height='18'  />  &nbsp; &nbsp; &nbsp;</span>");
						   
						   var mamh = $("#txtMaMH").val();
						   var tenmh = $("#txtTenMH").val();
						   var sotc = $("#txtSoTC").val();
						   var kyhoc = $("#txtKyHoc").val();
						   
						   var param = {
								   Type: "Update",
								   MaMH : mamh,
								   TenMH: tenmh,
								   SoTC: sotc,
								   KyHoc: kyhoc
						   };
						   var url = "ajax_monhoc.php";
						   
						   $.ajax({
							 url:url,
							 type: "POST",
							 data: param,
							 dataType: "HTML",			
							 error: function(xhr,status,errmgs){
								 var err = "Có lỗi xảy ra: " + errmgs;
								 $(this).dialog("close");
								 showError(err);									 							
							 },							 
							 complete: function(){
								 $("#spanUpdateLoading").remove();
								 $("#btnLuu").show();
								 
							 },
							 beforeSend: function(){ 
							 },
							 success: function(data){
								 if (data == "OK"){	
									 reLoad();
									 $("#dialogUpdateMH").dialog("close");										
									 
								 }else{
									 var err = "Không thể cập nhật môn học " + mamh;
									 showError(err);
								 }
							 }
							 
						 });
						
					   }
				 },
				{
					text:"Đóng",					 	 	 
					   click: function(){
						   $(this).dialog("close");
					   }
				}
			]
});
   
		
		 event.preventDefault();
		
	});
	$(document).on("mouseover",".ds tr",function(event){
		$(this).find(".btnXoaMH").show();
		 $(this).find(".btnSuaMH").show();
	 });
	 
	 $(document).on("mouseout",".ds tr",function(event){
		$(this).find(".btnXoaMH").hide();
		 $(this).find(".btnSuaMH").hide();
	 });
	 $( ".group-box" ).addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
     	.find( ".title" ).addClass( "ui-widget-header ui-corner-all" )
     	.prepend( "<span class='ui-icon ui-icon-triangle-1-s'></span>");

   $( ".group-box .ui-icon" ).click(function() {
     $( this ).toggleClass( "ui-icon-triangle-1-s" )
     	.toggleClass( "ui-icon-triangle-1-w" );
     $( this ).parents(".group-box").find( ".group-box-content" )
     	.slideToggle();
   });
   
   $("#leftSide").sortable({
	   axis: "y",
	   revert: 500,
	   handle:".title",
	   curosr: "move"
   }).disableSelection();
   //phân trang
//    $('ds').on('click','#paging a', function ()
//              {
//                  var url = $(this).attr('href');
// 				 console.log(url);
			
                  
//                  $.ajax({
//                      url : url,
//                      type : 'get',
//                      dataType : 'html',
//                      success : function (result)
//                      {
//                          //  kiểm tra kết quả đúng định dạng không
//                          if (result.hasOwnProperty('member') && result.hasOwnProperty('paging'))
//                          {
//                              var html = '<table class="ds">'
// 							 +'<!-- in tiêu đề danh sách -->'+
// 								+'<thead>'
// 									+ '<tr class="ui-widget-header">'
// 									+  '  <th><input type="checkbox" id="checkAll"/></th>'
// 									+  '  <th>STT</th>'
// 									+  '  <th>Mã môn học</th>'
// 									+  '  <th>Tên môn học</th>'
// 									+  '  <th>Số tín chỉ</th>'
// 									+  '  <th>Kì học dự kiến</th>'
// 									+  '  <th></th>'
// 								+  '  </tr>'
// 							+  '</thead>'
// 							+  '  <!-- end in tiêu đề-->'
// 							+  '  <!-- inh danh dánh -->'
// 							+  '  <tbody>';
//                              // lặp qua danh sách thành viên và tạo html
// 							 var i=0;
//                              $.each(result['member'], function (key, item){
// 							    html+= "<tr class='trsv' >";
// 								html+= "<td><input name='chkmasv[]'  value='"+item['MaMH']+ "' class='chkmasv' type='checkbox'/> </td>";
// 								html+= "<td class='stt'>" + (++i) + "</td>";
// 								html+= "<td>"+item['MaMH']+ "</td>";
// 								html+= "<td>" +item['TenMH']+ "</td>";
// 								html+= "<td>"+item['SoTC'] +"</td>";
// 								html+= "<td>" +item['KyHoc']+ "</td>";
// 								html+= "<td>";
// 								html+= "<button  class='btnSuaMH' name='MaMH' value='"+item['MaMH']+ "'><span class='ui-icon ui-icon-pencil' ></span></button>";
// 								html+= "<button name='btnXoaMH' class='btnXoaMH' value='"+item['MaMH'] +"' ><span class='ui-icon ui-icon-trash'  ></span> </button>";
// 								html+= "</td>";
// 								html+= "</tr>";
//                              });                          
//                              html += '</tbody>';
// 							 html+='</table>';
                              
//                              // Thay đổi nội dung danh sách thành viên
//                              $('#divDSMH').html(html);
                              
//                              // Thay đổi nội dung phân trang
//                              $('#paging').html(result['paging']);
                              
//                              // Thay đổi URL trên website
//                              window.history.pushState({path:url},'',url);
//                          }
//                      }
//                  });
//                  return false;
//              });

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
		
		
		<div id="dialogUpdateMH">
				<p id="info"></p>
				
				<label for="txtMaMH">Mã môn học:</label>
				<input type="text" id="txtMaMH" name="txtMaMH" disabled /> <br />
				
				<label for="txtTenMH">Tên môn học:</label>
				<input type="text" id="txtTenMH" name="txtTenMH" /> <br />
				
				<label for="txtSoTC">Số tín chỉ:</label>
				<input type="text" id="txtSoTC" name="txtSoTC" /> <br />
				
				<label for="txtKiHoc">Kỳ học dự kiến:</label>
				<input type="text" id="txtKiHoc" name="txtKiHoc" /> <br />
				
			</div>
	 <p> </p>
	 </div>
	 </div>
</div>		
<?php require "footer.php"; ?>