<style type="text/css">

.side-note{
	height: 28%%;
	/*width: 90%;*/
	z-index: 99999999999999999999999999999999999999999999;
	position: fixed;
	left: 100px;
    top: 0px;
    
}

.textarea {
	border: 3px solid #cccccc;
	min-height: 100px;
	width: 98% !important;
	font-family: "Comic Sans MS", cursive, sans-serif !important;
}

.textarea_2{
	border: 3px solid #cccccc;
	min-height: 100px;
	width: 98% !important;
	font-family: "Comic Sans MS", cursive, sans-serif !important;	
}

.btn-close-note{
	cursor: pointer;
	cursor: hand;
}

.auto_text{
	cursor: pointer;
	cursor: hand;
}

.saved_alert{
	color: #fff;
}
.row-sidenote{
	/*margin-top: 15px;
	margin-right: 10px;
	margin-left: 10px;*/
	background: #f5f5f5;
	border-radius: 2px;
	overflow: scroll !important;
	/*height: 100% !important;*/
	max-height: 200px;
	height: auto;
}
.note-history-btn{
	cursor: pointer;
	cursor: hand;
}
.row-sidenote h5{
	margin-left: 10px;
}
.view_note{
	cursor: pointer;
	cursor: hand;
}

</style>

<div class="col-md-6 side-note">
	<div class="row">
		<div class="col-md-12" data-flag="1">
			<textarea class="form-control textarea" placeholder="Write your notes here..." row=300></textarea>
			<a class="btn btn-danger btn-xs btn-close-note">Close</a>
			<a class="btn btn-primary btn-xs auto_text">NA</a>
			<a class="btn btn-primary btn-xs auto_text">10 sec Voice 2 txt</a>
			<a class="btn btn-primary btn-xs auto_text">LM</a>
			<a class="btn btn-primary btn-xs auto_text">Rang out</a>
			<!-- <div class="saved_alert"><i>Saved...</i></div> -->
		</div>
		<div class="col-md-12" hidden data-flag="2">
			<textarea class="form-control textarea_2" placeholder="Write your notes here..." row=300></textarea>
			<a class="btn btn-primary btn-xs auto_text">NA</a>
			<a class="btn btn-primary btn-xs auto_text">10 sec Voice 2 txt</a>
			<a class="btn btn-primary btn-xs auto_text">LM</a>
			<a class="btn btn-primary btn-xs auto_text">Rang out</a>
		</div>
	</div>
</div>
<!-- <div class="btn-sidenote">
	Q<br>U<br>I<br>C<br>K<br><br>N<br>O<br>T<br>E
</div> -->




