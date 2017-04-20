<?php get_header(); ?>
<div class="articles-homepage">
<div class="container">
<h2 class="gray top">Featured Articles</h2>
<?php

the_content();


?>


    </div>
    <a href="/analysis" alt="More articles" class="catAll"><span class="arrow">Explore More Articles</span></a>
    </div>

    <div class="intro-homepage">
        <div class="container">
        <div class="row">
            <div class="col-sm-4">
            <h2 class="gray">Latest Tweets</h2>

            <a class="twitter-timeline" data-theme="light" data-link-color="#98B0BC" data-height="350" data-chrome="noheader nofooter noborders transparent"  data-tweet-limit="1" href="https://twitter.com/beyondcsiskorea">Tweets by Beyond Parallel</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
            </div><!--/col-sm-4-->
            <div class="col-sm-8">
                 <h2 class="gray">About Beyond Parallel</h2>
                 <p>Beyond Parallel is a nonpartisan and authoritative analytic vehicle for delivering greater clarity and understanding to policymakers, strategists, and opinion leaders about Korean unification. The project will address issues that hold strategic significance for unification and functional issues such as economic development, migration, food security, transitional justice, human rights, and health that will be at the heart of how unification is carried out.</p>
                 
                 <a href="/about" alt="Read about Beyond Parallel" class="followButton"><span class="arrow ">Learn More</span>
                 </a>

            </div><!--/col-sm-8-->
        </div><!--/row-->
        </div><!--/container-->
    </div><!--/intro homepage-->

<?php get_footer(); ?>