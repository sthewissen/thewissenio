        <footer class="footer">
			<div class="wrap">
				<div class="row footer__wrapper">
					<div class="col-lg-6 col-sm-12">
						<span class="footer__copyright">
							Copyright &copy; Steven Thewissen. <?php echo date('Y'); ?> &bull; All rights reserved.
						</span>
					</div>
					<div class="col-lg-6 col-sm-12">
						<div class="footer__items">
							<ul class="footer__social">
								<li class="footer__social-link"><a href="https://www.twitter.com/devnl" target="_blank"><i class="footer__social-logo fab fa-twitter-square"></i></a></li>
								<li class="footer__social-link"><a href="https://www.linkedin.com/in/steventhewissen/" target="_blank"><i class="footer__social-logo fab fa-linkedin"></i></a></li>
								<li class="footer__social-link"><a href="https://www.twitch.tv/steventhewissen" target="_blank"><i class="footer__social-logo fab fa-twitch"></i></a></li>
								<li class="footer__social-link"><a href="https://www.instagram.com/sthewissen/" target="_blank"><i class="footer__social-logo fab fa-instagram"></i></a></li>
								<li class="footer__social-link"><a href="https://github.com/sthewissen" target="_blank"><i class="footer__social-logo fab fa-github"></i></a></li>
								<li class="footer__social-link"><a href="https://untappd.com/user/devnl" target="_blank"><i class="footer__social-logo fab fa-untappd"></i></a></li>
								<li class="footer__social-link"><a href="https://account.xbox.com/profile?gamertag=devnl" target="_blank"><i class="footer__social-logo fab fa-xbox"></i></a></li>
							
								<li class="footer__social-img"><a href="https://mvp.microsoft.com/en-us/PublicProfile/5003274?fullName=Steven%20Thewissen" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/img/mvp.png" /></a></li>
								<li class="footer__social-img"><a href="https://www.planetxamarin.com/authors" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/img/planetxamarin.png" /></a></li>
								<li class="footer__social-img"><a href="https://www.snppts.dev" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/img/snppts.png" /></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</footer>
	</div>

		<?php wp_footer(); ?>

		

		<% for ( let chunkJs in htmlWebpackPlugin.files.chunks ) { %>
		<% if ( htmlWebpackPlugin.files.chunks[chunkJs].entry != '') { %>
		<script src="<?php echo get_template_directory_uri(); ?>/<%= htmlWebpackPlugin.files.chunks[chunkJs].entry %>"></script>
		<% } %>
		<% } %>
</body>

</html>