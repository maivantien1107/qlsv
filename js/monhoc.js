$(document).ready(function(){
   jQuery(document).ready(function($){
						$("#DSTruong").change(function(event){
							idtruong=$("#DSTruong").val();
							$.post('ajax_monhoc.php',{"idtruong":idtruong},function(data){
								$("#divDSMH").html(data);
								$(".btnXoa, .btnSuaMH").hide();
							})
						})
					});
	// xử lý nút xóa
	$(document).on("click",".btnXoaMH",function(event){
		 var button = $(this);
		 var mamh = $(button).val() ;
		 
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
   
             $('.ds').on('click','#paging a', function ()
             {
                 var url = $(this).attr('href');
                  
                 $.ajax({
                     url : url,
                     type : 'get',
                     dataType : 'json',
                     success : function (result)
                     {
                         //  kiểm tra kết quả đúng định dạng không
                         if (result.hasOwnProperty('member') && result.hasOwnProperty('paging'))
                         {
                             var html = '';
                             // lặp qua danh sách thành viên và tạo html
                             $.each(result['member'], function (key, item){
                               html+='<thead>';
            html+='<tr class="ui-widget-header">';
               html+=' <th><input type="checkbox" id="checkAll"/></th>';
               html+= '<th>STT</th>';
               html+= '<th>Mã môn học</th>';
                html+='<th>Tên môn học</th>';
               html+= '<th>Số tín chỉ</th>;'
                html+='<th>Kì học dự kiến</th>';
               html+= '<th></th>';
            html+='</tr>';
        html+='</thead>';
        html+='<tbody>';
                html+= "<tr class='trsv' >";
                html+= "<td><input name='chkmasv[]'  value='" + item ["MaMH"] +"' class='chkmasv' type='checkbox'/> </td>";
                html+= "<td class='stt'>"+1+ "</td>";
                html+= "<td>" + item ["MaMH"] + "</td>";
                html+= "<td>" + item ["TenMH"] + "</td>";
                html+= "<td>" + item["SoTC"] + "</td>";
                html+= "<td>" + item["KyHoc"] + "</td>";
                html+= "<td>";
                html+= "<button  class='btnSuaMH' name='MaMH' value='" + item["MaMH"] + "'><span class='ui-icon ui-icon-pencil' ></span></button>";
                html+= "<button name='btnXoaMH' class='btnXoaMH' value='" + item["MaMH"] + "' ><span class='ui-icon ui-icon-trash'  ></span> </button>";
                html+= "</td>";
                html+= "</tr>";
        html+='</tbody>';
                             });
                              
                             html += '</table>';
                              
                             // Thay đổi nội dung danh sách thành viên
                             $('#list_mh').html(html);
                              
                             // Thay đổi nội dung phân trang
                             $('#paging').html(result['paging']);
                              
                             // Thay đổi URL trên website
                             window.history.pushState({path:url},'',url);
                         }
                     }
                 });
                 return false;
             });
			}); //ready()