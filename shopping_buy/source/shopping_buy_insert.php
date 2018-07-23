<?php 
session_start();
if(isset($_SESSION['id'])){
    $id=$_SESSION['id'];
    $cname = $_SESSION['name'];
}else{
    $id=null;
}
if($_GET['mode']){
    $mode=$_GET['mode'];
}
if($_GET['no']){
    $no=$_GET['no'];
}
if($_GET['value']){
    $value=$_GET['value'];
}


?>
<html>
<head>
<script type="text/javascript"
	src="https://service.iamport.kr/js/iamport.payment-1.1.5.js"></script>
<script type="text/javascript"
	src="https://cdn.iamport.kr/js/iamport.payment-x.y.z.js"></script>
	<script  src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
function payment(){
	var IMP = window.IMP; // 생략가능
	var mode = '<?=$mode?>';
	IMP.init('imp57315089');
	IMP.request_pay({
	    pg : 'kakaopay',
	    pay_method : 'card',
	    merchant_uid : 'merchant_' + new Date().getTime(),
	    name : '주문명:결제테스트',
	    amount : 14000,
	    buyer_email : 'iamport@siot.do',
	    buyer_name : '구매자이름',
	    buyer_tel : '010-8348-8582',
	    buyer_addr : '서울특별시 강남구 삼성동',
	    buyer_postcode : '123-456',
	    kakaoOpenApp : true
	}, function(rsp) {
	    if ( rsp.success ) {
	    	//[1] 서버단에서 결제정보 조회를 위해 jQuery ajax로 imp_uid 전달하기
	    	jQuery.ajax({
	    		url: "/payments/complete", //cross-domain error가 발생하지 않도록 주의해주세요
	    		type: 'POST',
	    		dataType: 'json',
	    		data: {
		    		imp_uid : rsp.imp_uid
		    		//기타 필요한 데이터가 있으면 추가 전달
	    		}
	    	}).done(function(data) {
	    		//[2] 서버에서 REST API로 결제정보확인 및 서비스루틴이 정상적인 경우
	    		if ( everythings_fine ) {
	    			var msg = '결제가 완료되었습니다.';
	    			msg += '\n고유ID : ' + rsp.imp_uid;
	    			msg += '\n상점 거래ID : ' + rsp.merchant_uid;
	    			msg += '\결제 금액 : ' + rsp.paid_amount;
	    			msg += '카드 승인번호 : ' + rsp.apply_num;
	    			
	    			alert(msg);
	    				
	    		} else {
	    			//[3] 아직 제대로 결제가 되지 않았습니다.
	    			//[4] 결제된 금액이 요청한 금액과 달라 결제를 자동취소처리하였습니다.
	    		}
	    		 
	    	});
	    } else {
	        var msg = '결제에 실패하였습니다.';
	        msg += '에러내용 : ' + rsp.error_msg;
	        
	        alert(msg);
	        
	    }
	   if( rsp.success){
		   alert('1');
		   if(mode == "order"){
				location.href="./insert.php?no="+'<?=$no?>'+"&value="+'<?=$value?>'+"&mode="+'<?=$mode?>';
		   }else{
				location.href="./insert.php?mode="+'<?=$mode?>';
		   }
	   }else{
		   alert('2');
		   location.href="../../shopping/source/shopmain.php";
	   }
	});
	}
payment();

</script>
</head>
</html>
