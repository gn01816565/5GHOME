<div class="rsidebar span_1_of_left">
  <section  class="sky-form">
	  <div class="product_right">
		  <h4 class="m_2"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span>分類類別</h4>
		  <div class="tab1">
			  <ul class="place">								
				  <li class="sort">UL線材</li>
				  <li class="by"><img src="images/do.png" alt=""></li>
					<div class="clearfix"> </div>
			  </ul>
			  <div class="single-bottom">						
					 <a href="#"><p>UL線材</p></a>
		    </div>
	    </div>						  
		  <div class="tab2">
			  <ul class="place">								
				  <li class="sort">行動電源</li>
				  <li class="by">
            <img src="images/do.png" alt="">
          </li>
					<div class="clearfix"> </div>
			  </ul>
			  <div class="single-bottom">						
					<a href="#"><p>行動電源配件</p></a>					
		    </div>
	    </div>
		  <div class="tab3">
			  <ul class="place">								
				  <li class="sort">影音/遊戲用線</li>
				  <li class="by"><img src="images/do.png" alt=""></li>
					<div class="clearfix"> </div>
			  </ul>
			  <div class="single-bottom">						
					<a href="#"><p>光纖傳輸線</p></a>
          <a href="#"><p>HDMI / MINI HDMI /DVI用線</p></a>
          <a href="#"><p>A/V傳輸線</p></a>
          <a href="#"><p>音源/耳機/麥克風/手機</p></a>
          <a href="#"><p>遊戲周邊用線</p></a>
		    </div>
	    </div>
		  <div class="tab4">
			  <ul class="place">								
				  <li class="sort">轉接頭</li>
				  <li class="by"><img src="images/do.png" alt=""></li>
					<div class="clearfix"> </div>
			  </ul>
			  <div class="single-bottom">						
					<a href="#"><p>USB/MINI USB/MICRO USB轉接頭</p></a>
					<a href="#"><p>AC 電源轉接頭</p></a>
					<a href="#"><p>HDMI /MINI HDMI 轉接頭</p></a>
		    </div>
	    </div>
		  <div class="tab5">
			  <ul class="place">								
				  <li class="sort">USB/MINI USB/MICRO USB</li>
				  <li class="by"><img src="images/do.png" alt=""></li>
					<div class="clearfix"> </div>
			  </ul>
			  <div class="single-bottom">						
					<a href="#"><p>USB傳輸線</p></a>
					<a href="#"><p>USB 配件</p></a>
					<a href="#"><p>USB 可伸縮轉換線</p></a>
		    </div>
	    </div>
		  
		  <!--script-->
		  <script>
			  $(document).ready(function(){
				  $(".tab1 .single-bottom").hide();
				  $(".tab2 .single-bottom").hide();
				  $(".tab3 .single-bottom").hide();
				  $(".tab4 .single-bottom").hide();
				  $(".tab5 .single-bottom").hide();
				
				  $(".tab1 ul").click(function(){
					  $(".tab1 .single-bottom").slideToggle(300);
					  $(".tab2 .single-bottom").hide();
					  $(".tab3 .single-bottom").hide();
					  $(".tab4 .single-bottom").hide();
					  $(".tab5 .single-bottom").hide();
				  })
				  $(".tab2 ul").click(function(){
					  $(".tab2 .single-bottom").slideToggle(300);
					  $(".tab1 .single-bottom").hide();
					  $(".tab3 .single-bottom").hide();
					  $(".tab4 .single-bottom").hide();
					  $(".tab5 .single-bottom").hide();
				  })
				  $(".tab3 ul").click(function(){
					  $(".tab3 .single-bottom").slideToggle(300);
					  $(".tab4 .single-bottom").hide();
					  $(".tab5 .single-bottom").hide();
					  $(".tab2 .single-bottom").hide();
					  $(".tab1 .single-bottom").hide();
				  })
				  $(".tab4 ul").click(function(){
					  $(".tab4 .single-bottom").slideToggle(300);
					  $(".tab5 .single-bottom").hide();
					  $(".tab3 .single-bottom").hide();
					  $(".tab2 .single-bottom").hide();
					  $(".tab1 .single-bottom").hide();
				  })	
				  $(".tab5 ul").click(function(){
					  $(".tab5 .single-bottom").slideToggle(300);
					  $(".tab4 .single-bottom").hide();
					  $(".tab3 .single-bottom").hide();
					  $(".tab2 .single-bottom").hide();
					  $(".tab1 .single-bottom").hide();
				  })	
			  });
		  </script>
		  <!-- script -->	
    </div>  				 
  </section>
				 <!--
				 <section  class="sky-form">
					 <h4><span class="glyphicon glyphicon-minus" aria-hidden="true"></span>折扣條件</h4>
					 <div class="row row1 scroll-pane">
						 <div class="col col-4">
								<label class="checkbox"><input type="checkbox" name="checkbox" checked=""><i></i>Upto - 10% (20)</label>
						 </div>
						 <div class="col col-4">
								<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>40% - 50% (5)</label>
								<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>30% - 20% (7)</label>
								<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>10% - 5% (2)</label>
								<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>其它(50)</label>
						 </div>
					 </div>
				 </section>  				 
				   
				 <section  class="sky-form">
						<h4><span class="glyphicon glyphicon-minus" aria-hidden="true"></span>價格條件</h4>
							<ul class="dropdown-menu1">
								 <li><a href="">								               
								<div id="slider-range"></div>							
								<input type="text" id="amount" style="border: 0; font-weight: NORMAL;   font-family: 'Dosis-Regular';" />
							 </a></li>			
						  </ul>
				   </section>
           -->
				   <!---->
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
	<script type='text/javascript'>//<![CDATA[ 
	$(window).load(function(){
		$( "#slider-range" ).slider({
			range: true,
			min: 0,
			max: 100000,
			values: [ 500, 100000 ],
			slide: function( event, ui ) {  $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
			}
		});
		$( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) + " - $" + $( "#slider-range" ).slider( "values", 1 ) );
  	});//]]> 
	</script>

  
				 <!--
				 <section  class="sky-form">
						<h4><span class="glyphicon glyphicon-minus" aria-hidden="true"></span>Type</h4>
							<div class="row row1 scroll-pane">
								<div class="col col-4">
									<label class="checkbox"><input type="checkbox" name="checkbox" checked=""><i></i>Lights (30)</label>
								</div>
								<div class="col col-4">
									<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Diwali Lights   (30)</label>
									<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Tube Lights      (30)</label>
									<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>LED Lights        (30)</label>
									<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Bulbs  (30)</label>
									<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Ceiling Lights  (30)</label>
								</div>
							</div>
				   </section>
				   <section  class="sky-form">
						<h4><span class="glyphicon glyphicon-minus" aria-hidden="true"></span>Brand</h4>
							<div class="row row1 scroll-pane">
								<div class="col col-4">
									<label class="checkbox"><input type="checkbox" name="checkbox" checked=""><i></i>Everyday</label>
								</div>
								<div class="col col-4">
									<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Anchor</label>
									<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Philips</label>
									<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Wipro</label>
									<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Havells</label>
									<label class="checkbox"><input type="checkbox" name="checkbox" ><i></i>Ferolex</label>
									<label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Gold Medal</label>
								</div>
							</div>
				   </section>				   
           -->
</div>
<div class="rsidebar span_1_of_left">
  <div style="float:left;width:80%;">最新消息</div>
  <div style=""><a href="?pageData=news_list" >more</a></div>
  <iframe src="https://www.youtube.com/embed/DL4MnuzbFEk?list=PLH25swPR4qs3EYPYW0CsP_1DfvxXS1j7J" frameborder="0" allowfullscreen style="width:100%;">
  </iframe>
</div>
<!--
  <div class="productMenu">
      <div class="productMenu_tr">
        <div class="productMenu_td">最新消息</div>
        <div class="productMenu_td">more</div> 
      </div>
      <div class="productMenu_tr">
        <div class="productMenu_td">
          <iframe src="https://www.youtube.com/embed/DL4MnuzbFEk?list=PLH25swPR4qs3EYPYW0CsP_1DfvxXS1j7J" frameborder="0" allowfullscreen>
          </iframe>
        </div>
      </div>
    </div>
    -->