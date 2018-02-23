<?php require_once('config.php');?><!doctype html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="../vendor/bootstrap-3.3.7-dist/css/bootstrap.min.css"></link>
	<link rel="stylesheet" type="text/css" href="../vendor/bootstrap-3.3.7-dist/css/bootstrap-theme.min.css"></link>
	<link rel="stylesheet" type="text/css" href="../vendor/ui.anglepicker/ui.anglepicker.css"></link>
	<style>
		#angleTip{
			background: #2d2d2d;
            color: #b9b9b9;
            padding: 4px 10px;
            border-radius: 10px;
            display:inline-block;
            margin: 20px 0;
            font-style: normal;
            display: none;
		}
	</style>
</head>
<body>
	<div class="container">
		<h3>Image Placeholder</h3>
		<div class="panel panel-primary">
			<div class="panel-heading">Form Builder</div>
			<div class="panel-body">
				<form id="form-builder">
					<div class="row">
						<div class="col-md-6">
							<div class="row">
								<div class="col-xs-6">
									<div class="form-group">
										<label for="width">Width</label>
										<input class="form-control" name="width" id="width" type="number" min="<?=$config['width'][1];?>" max="<?=$config['width'][2];?>" placeholder="<?=$config['width'][0];?>" >
									</div>
								</div>
								<div class="col-xs-6">
									<div class="form-group">
										<label for="height">Height</label>
										<input class="form-control" name="height" id="height" type="number" min="<?=$config['height'][1];?>" max="<?=$config['height'][2];?>" placeholder="<?=$config['height'][0];?>" >
									</div>									
								</div>
							</div>
							<div class="form-group">
								<label for="text">Text</label>
								<input class="form-control" name="text" id="text" type="text" placeholder="<?=$config['text'];?>">
							</div>
							<div class="row">
								<div class="col-xs-6">
									<div class="form-group">
										<label for="backgroundColor">Background Color</label>
										<input class="form-control color" name="backgroundColor" id="backgroundColor" type="text" placeholder="<?=$config['backgroundColor'];?>">	
									</div>
								</div>
								<div class="col-xs-6">
									<div class="form-group">
										<label for="fontColor">Font Color</label>
										<input class="form-control color" name="fontColor" id="fontColor" type="text" placeholder="<?=$config['fontColor'];?>" >
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-xs-6">
									<div class="form-group">
										<label for="fontFamily">Font Family</label>
										<select class="form-control" name="fontFamily" id="fontFamily" >
											<option value="">Select Font</option>
											<?php foreach($config['availableFont'] as $font):?>
											<option value="<?=$font;?>"><?=$font;?></option>
											<?php endforeach;?>
										</select>
									</div>
								</div>
								<div class="col-xs-6">
									<div class="form-group">
										<label for="fontSize">Font Size</label>
										<input class="form-control" name="fontSize" id="fontSize" type="number" min="<?=$config['fontSize'][1];?>" max="<?=$config['fontSize'][2];?>" placeholder="<?=$config['fontSize'][0];?>">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6">								
									<div class="form-group">
										<label for="fontAngle">Font Angle</label>
										<input class="form-control" name="fontAngle" id="fontAngle" type="number" min="-360" max="360" placeholder="<?=$config['fontAngle'];?>">
									</div>
								</div>
								<div class="col-xs-6">
									<div id="angle"></div>
									<em id="angleTip">Tip: If you hold shift,<br>you can snap to 15 degree increments</em>	
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<input type="submit" class="btn btn-primary" value="Submit"> 
							<input type="reset" class="btn btn-danger" value="Reset"> 
						</div>
						
						<div class="col-md-12">
							<hr>
							<div >Url: <span id="display"></span></div>
							<div id="preview"></div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="../vendor/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	<script src="../vendor/tinyColorPicker/jqColorPicker.min.js"></script>
	<script src="../vendor/jquery-ui/jquery-ui-1.10.2.js"></script>
	<script src="../vendor/ui.anglepicker/ui.anglepicker.js"></script>
	<script>
		$(function(){
			
			
			$('.color').colorPicker({
				opacity: false, // disables opacity slider
				renderCallback: function($elm, toggled) {
					$elm.val(this.color.colors.HEX);
				}
			});
			
			$("#angle").anglepicker({
				change: function(e, ui) {
                    $("#fontAngle").val(ui.value)
                },
                start: function(e, ui) {
                    $("#fontAngle").val(ui.value)
                    $("#angleTip").fadeIn('fast');
                },
                stop: function() {
                    $("#angleTip").hide();
                },
				value: 0,
				options: {
					distance: 1,
					delay: 1,
					snap: 1,
					min: 0,
					shiftSnap: 15,
					value: 90,
					clockwise: true
				}
			});
			
			$('#fontAngle').on('input', function(){
				$("#angle").anglepicker("value", $(this).val());
			});
			
			$('input[type="reset"]').click(function(){
				$("#angle").anglepicker("value", 0);
				$('#display').html('');
				$('#preview').html('');
			});
			
			$('#form-builder').submit(function(e){
				e.preventDefault();
				var splitUrl = window.location.href.split('/');
				splitUrl[splitUrl.length-1] ='';
				var url = splitUrl.join('/');
				var path = [];
				var status = false;
				if($('#fontAngle').val() !='') {
					path.unshift($('#fontAngle').val()); 
					status=true;
				}
				if($('#fontSize').val() !='' || status) {
					path.unshift($('#fontSize').val()); 
					status=true;						
				}
				if($('#fontFamily').val() !='' || status) {
					path.unshift($('#fontFamily').val()); 
					status=true;						
				}
				if($('#fontColor').val() !='' || status) {
					path.unshift($('#fontColor').val()); 
					status=true;						
				}
				if($('#backgroundColor').val() !='' || status) {
					path.unshift($('#backgroundColor').val()); 
					status=true;					
				}
				if($('#text').val() !='' || status) {
					path.unshift($('#text').val()); 
					status=true;					
				}
				if($('#height').val() !='' || status) {
					path.unshift($('#height').val()); 
					status=true;					
				}
				if($('#width').val() !='' || status) {
					path.unshift($('#width').val()); 
					status=true;					
				}else
					path.unshift(100);
				
				var imgUrl = url+path.join('-');
				$('#display').html('<a target="_blank" href="'+imgUrl+'">'+imgUrl+'</a>');
				$('#preview').html('<img src="'+imgUrl+'">');
			});
		});
	</script>
</body>
</html>