<?php
			$url = get_permalink($post->ID);
			$url = esc_url($url);

			$title = get_the_title();
			// $excerpt = sprintf(get_the_excerpt());

			$image = get_the_post_thumbnail_url();

?>

<div class='share-print-wrapper' >
	<div class='social-share-wrapper' >
		<div id='sharessm' class='share-on'>Share this page
		</div>

		<div class='sharemedia'>



     <!--Show Facebook-->

			<div class='ssmicon'>
				<a data-facebook='mobile' target='_blank' href='http://www.facebook.com/sharer.php?u=<?php echo $url  ?>' rel='nofollow' alt='Share on Facebook'>
					<div class='ssmfacebook'>

					</div>
				</a>
			</div>

    <!--Show Twitter-->

			<div class='ssmicon'>
				<a href='http://twitter.com/share?url=<?php echo $url ?>&amp;text=<?php echo $excerpt ?>' target='_blank' rel='nofollow' alt='Share on Twitter'>
					<div class='ssmtwitter'>

					</div>
				</a>
			</div>


     <!--Show Google+-->

			<div class='ssmicon'>
				<a href='https://plus.google.com/share?url=<?php echo $url ?>' target='_blank' rel='nofollow' alt='Share on Google+'>
					<div class='ssmgoogle'>

					</div>
				</a>
			</div>

     <!--ShowPinterest-->

			<div class='ssmicon'>
				<a data-site='linkedin' href='http://pinterest.com/pin/create/bookmarklet/?is_video=false&url=<?php echo $url ?>&media=<?php echo $image  ?>&description=<?php  echo $title  ?>' target='_blank' rel='nofollow' alt='Share on Pinterest'>
					<div class='ssmpinterest'>
					</div>
				</a>
			</div>

     <!--Show LinkedIn-->

			<div class='ssmicon'>
				<a data-site='linkedin' href='http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $url ?>' target='_blank' rel='nofollow' alt='Share on LinkedIn'>
					<div class='ssmlinkedin'>
					</div>
				</a>
			</div>


    <!--Show Email-->

			<div class='ssmicon'>
				<a href='mailto:?Subject=Simple Share Buttons<?php echo $url ?>' alt='Share via Email'>
					<div class='ssmemail'>
					</div>
				</a>
			</div>
		</div>
	</div>

    <!--Print-->
		<a href='javascript:window.print()' alt='Print this page'>
			<div class='print-wrapper' >
				<div class='printer'>Print
				</div>
			</div>
		</a>

</div>
