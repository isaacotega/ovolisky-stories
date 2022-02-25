<?php

	$footer = '	
			<div id="footer">
			
				<div id="left">
				
					<br><br>
			
					<a href="' . $root . 'all_stories">
					
						<label class="footLinks">Search for stories</label>
						
					</a>
				
					<br><br>
			
					<a href="' . $root . 'all_stories?q=&sort=trending">
					
						<label class="footLinks">Trending Stories</label>
					
					</a>
					
					<br><br>
			
					<a href="' . $root . 'all_stories?q=&sort=ongoing">
					
						<label class="footLinks">Ongoing Stories</label>
						
					</a>
					
					<br><br>
			
					<a href="' . $root . 'all_stories?q=&sort=completed">
					
						<label class="footLinks">Completed Stories</label>
						
					</a>
				
					<br><br>
			
					<a href="' . $root . 'genres">
					
						<label class="footLinks">Genres</label>
						
					</a>
				
					<br><br>
			
					<a href="' . $root . 'all_stories">
					
						<label class="footLinks">All Stories</label>
					
					</a>
					
					<br><br>
			
				</div>
				
				<div id="right">
				
					<br><br>
			
					<a href="' . $root . 'about">
					
						<label class="footLinks">About us</label>
						
					</a>
				
					<br><br>
			
					<a href="' . $root . 'contact-us">
					
						<label class="footLinks">Contact us</label>
						
					</a>
				
					<br><br>
			
					<a href="' . $root . 'community">
					
						<label class="footLinks">Community</label>
						
					</a>
				
					<br><br>
			
					<a href="' . $root . 'privacy-policy">
					
						<label class="footLinks">Privacy policy</label>
						
					</a>
				
					<br><br>
			
					<a href="' . $root . 'cookie-policy">
					
						<label class="footLinks">Cookie policy</label>
						
					</a>
				
					<br><br>
			
					<a href="' . $root . 'terms-of-service">
					
						<label class="footLinks">Terms of service</label>
						
					</a>
				
					<br><br>
			
				</div>
				
				<div id="bottom">
					
					<br>
				
					<label id="copyright">Copyright © ' . date("Y") . " " . $domain . '</label>
					
					<br>
				
					<label id="reservedRight">All Rights Reserved</label>
					
					<br><br>
				
				</div>
			
			</div>
		';

		echo isset($pageSpecs["footer"]) ? ($pageSpecs["footer"] ? $footer : "") : $footer;
		
?>
	
    </body>
	 
  </html>