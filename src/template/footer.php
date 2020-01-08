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
								<li class="footer__social-link"><a title="Follow me on Twitter" href="https://www.twitter.com/devnl" rel="noreferrer" target="_blank"><i class="footer__social-logo fab fa-twitter-square"></i></a></li>
								<li class="footer__social-link"><a title="Let's connect on LinkedIn" href="https://www.linkedin.com/in/steventhewissen/" rel="noreferrer" target="_blank"><i class="footer__social-logo fab fa-linkedin"></i></a></li>
								<li class="footer__social-link"><a title="Watch me on Twitch" href="https://www.twitch.tv/steventhewissen" rel="noreferrer" target="_blank"><i class="footer__social-logo fab fa-twitch"></i></a></li>
								<li class="footer__social-link"><a title="Follow me on Instagram" href="https://www.instagram.com/sthewissen/" rel="noreferrer" target="_blank"><i class="footer__social-logo fab fa-instagram"></i></a></li>
								<li class="footer__social-link"><a title="Code with me on GitHub" href="https://github.com/sthewissen" rel="noreferrer" target="_blank"><i class="footer__social-logo fab fa-github"></i></a></li>
								<li class="footer__social-link"><a title="Let's drink a beer on Untappd" href="https://untappd.com/user/devnl" rel="noreferrer" target="_blank"><i class="footer__social-logo fab fa-untappd"></i></a></li>
								<li class="footer__social-link"><a title="Game with me on Xbox" href="https://account.xbox.com/profile?gamertag=devnl" rel="noreferrer" target="_blank"><i class="footer__social-logo fab fa-xbox"></i></a></li>
							</ul>
							<ul class="footer__social">
								<li class="footer__social-img"><a title="Microsoft MVP" href="https://mvp.microsoft.com/en-us/PublicProfile/5003274?fullName=Steven%20Thewissen" rel="noreferrer" target="_blank"><img alt="Microsoft MVP" src="<?php echo get_template_directory_uri(); ?>/img/mvp.png" /></a></li>
								<li class="footer__social-img"><a title="Planet Xamarin Contributor" href="https://www.planetxamarin.com/authors" rel="noreferrer" target="_blank"><img alt="Planet Xamarin Contributor" src="<?php echo get_template_directory_uri(); ?>/img/planetxamarin.png" /></a></li>
								<li class="footer__social-img"><a title="Snppts Contributor" href="https://www.snppts.dev" rel="noreferrer" target="_blank"><img alt="Snppts Contributor" src="<?php echo get_template_directory_uri(); ?>/img/snppts.png" /></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</footer>
	</div>

		<?php wp_footer(); ?>

		<script src='<?php echo get_template_directory_uri(); ?>/js/lib/typewriter.js'></script>

		<script src='<?php echo get_template_directory_uri(); ?>/js/lib/library-g.min.js'></script>
		<script src='<?php echo get_template_directory_uri(); ?>/js/lib/Morph.js'></script>

		<% for ( let chunkJs in htmlWebpackPlugin.files.chunks ) { %>
		<% if ( htmlWebpackPlugin.files.chunks[chunkJs].entry != '') { %>
		<script src="<?php echo get_template_directory_uri(); ?>/<%= htmlWebpackPlugin.files.chunks[chunkJs].entry %>"></script>
		<% } %>
		<% } %>
</body>

</html>