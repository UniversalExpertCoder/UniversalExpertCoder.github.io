		<div class="footer">
			<h2>&copy; www.zoomrahul.com</h2>		
		</div>


	</div>
	<!--Container Ends Here-->

<script type="text/javascript">
	document.getElementById("navigation_menu").style.width = "0%";

	function slide_menu() {
	  var x = document.getElementById("slide_menu_bar");
	  if (x.style.display === "block") {
	    x.style.display = "none";
	  } else {
	    x.style.display = "block";
	  }
	}

	function slide_navigation_menu() {
		var x = document.getElementById("navigation_menu");

		if (x.style.width === "0%") {
			console.log(screen.width/2);

			var maximum = window.matchMedia("(max-width: 600px)").matches;
			console.log(maximum);
			if (maximum ) {
			  /* The viewport is less than, or equal to, 700 pixels wide */
			  x.style.width = "100%";
			  console.log("100%");

			} else {
			  /* The viewport is greater than 700 pixels wide */
			  x.style.width = "50%";
			  console.log("50%");

			}
			
		} else {
			x.style.width = "0%";
		}
	}


</script>

<script type="text/javascript">
	
</script>

</body>
</html>