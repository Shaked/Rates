<!DOCTYPE html>
<html>
<head>
	<script src='//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js' type="text/javascript"></script>
	<style>
		#container {
			margin: 0 auto; 
			text-align: center; 	
		}
		#currencies { 
			width: 700px; 
			height: 40px; 
			border-top: 1px solid #efefef; 
			border-left: 1px solid #efefef; 
			border-right: 1px solid gray;
		 	border-bottom: 1px solid gray;
			font-family: Verdana; 
			font-size: 22px; 
		 }
		  
		 #submit { 
		 	margin-top: 10px; 
			width: 300px; 
		 	height: 20px; 
		 	border: 1px solid gray;
		 	background: #efefef; 	 
		 	cursor: pointer;	
		 }
		 
		 .results { 
			margin-top: 40px; 
		 	border: 1px solid #efefef; 
		 	width: 100%;  	
		  }
		 
		 .hide { display:none; } 
		 .show { display:block; } 
	</style>
</head>
<body>
<div id="container">
	<div>
		<form action='#' method="GET">
			<input type="hidden" name="r" value="<?php echo $this->actionName; ?>" /> 
			<input type="text" name="currencies" id="currencies" value="<?php echo $this->currencies ?>" />
			<br/>
			<input type="button" name="submit" id="submit" value="Convert to US currency " /> 
		</form>
	</div>
	
	<?php
		$style = 'hide';  
		if ($this->results) { 
			$curr = array_values(array_unique(explode(',',$this->currencies)));
			$style = 'show';  
		}
	?>
	<h2>Results</h2>
	<div class="results <?php echo $style; ?>">
		<?php foreach ($this->results as $index=>$result){ ?>
			<div><?php echo $result; ?> (<?php echo $curr[$index]; ?>)</div>
		<?php } ?>
	</div> 
	
	<?php 
		$style = 'hide'; 
		if ($this->errorMsg){
			$style='show'; 
		}
	?>  
	<div id="error" class="<?php echo $style; ?>">
		<?php echo $this->errorMsg; ?>
	</div>
</div>

<script type="text/javascript">
function unique(arr) { 
	var a = []; 
	var l = arr.length; 
	for(var i=0; i<l; i++) { 
		for(var j=i+1; j<l; j++) { // If a[i] is found later in the array 
			if (arr[i] === arr[j]) j = ++i; 
		} 
		a.push(arr[i]); 
	} 
	return a; 
};
$(document).ready(function(){
		var results = $('.results'),
			submit  = $('#submit');  
		
		submit.click(function(){
			 var curr = $('#currencies').val();  
			 $.ajax({
			  url: "index.php",
			  type: "GET",
			  data: {r : 'ajax', currencies: curr },
			  dataType: "json",
			  success: function(data){
				  if (!data.error){
				   var curr = $('#currencies').val(); 
				   var html = '', 
				  		curr = unique(curr.split(',')); 
				   for (var i in data){
						html += '<div>' + data[i] + ' ('+ curr[i] +')</div>'; 
				   }
				   
				   results.html(html).show(); 
				   $('#error').hide(); 
				  } else {
					results.hide();
					$('#error').text(data.error).show(); 
				  }
			  }, 
			  error: function(data){
				alert('please check your internet connection'); 
			  }
			}); 

			 return false; 
		}); 

		$('#currencies').keyup(function(e){
			if (13 == e.keyCode){ 
				submit.click(); 
			}; 

			return false; 
		});
	});
</script>
</body>
</html>