<?php get_header(); ?>
<div class="articles-homepage">
<div class="container">
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
            <h2 class="gray">Twitter</h2>


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
        <script type="text/javascript">
        
 jQuery(window).load(function() {
    //console.log("hello");
      var container = document.querySelector('#ms-container');
      var msnry = new Masonry( container, {
        itemSelector: '.ms-item',
        columnWidth: '.ms-item',                
      });  
      
});

      
    </script>
<?php get_footer(); ?>