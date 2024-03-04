<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Stijn Cappetijn</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php wp_head(); ?>
    </head>
    <body class="bg-black text-white"> 
        <div id="page-wrapper">
        <section id="hero" class="relative h-screen w-screen">
            <div class="h-full w-full">
                <video id="bgVideo" class="h-full w-full object-cover" preload="true" autoplay loop muted>
                    <!-- TODO: make link variable, set in customize menu. Also give option for photo (use php to change between video and img tag) -->
                    <source src="http://localhost/wp-content/uploads/2024/02/Home_Page.webm" type="video/webm" /> 
                </video>
            </div>
            <div class="absolute inset-0 flex flex-col justify-center bg-gray-600/60 z-50">
                <div class="text-center">
                    <h1 class="text-4xl sm:text-6xl font-extrabold my-4"><?php echo apply_filters( 'the_title', get_the_title( get_option( 'page_for_posts' ) ) );?></h1>
                    <p class="text-lg sm:text-2xl font-medium">Musician | Producer</p>
                </div>
            </div>
        </section>
        <hr>
        <section id="about" class="h-72 w-screen py-12">
            <div class="flex flex-row items-center justify-center w-6/12 m-auto">
                <div class="w-8/12">
<?php $page_query = new WP_Query( array( 'pagename' => 'stijn-cappetijn' ) );
    while ($page_query->have_posts()) {
        $page_query->the_post();
        $page_query->the_title();
        $page_query->the_content();
    }
wp_reset_postdata();
?>
                    <h2 class="text-4xl font-extrabold">Bio</h2>
                    <p>test test</p>
                </div>
                <img class="w-4/12" href="http://localhost/wp-content/uploads/2024/02/stijncappetijn.jpg"/>
            </div>
        </section>
        <hr>
        <section id="projects" class="w-screen py-12 sm:px-2">
            <div class="min-w-screen-lg grid 2xl:grid-cols-6 xl:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1">
                <?php
                    $args = array(
                        'post_type' => 'post'
                    );
                    $post_query = new WP_Query($args);
                    if ($post_query->have_posts()) {
                        while ($post_query->have_posts()) {
                            $post_query->the_post();
                ?>
                <article <?php post_class(); ?>>
                    <div class="relative aspect-square">
<?php
                            if ( has_post_thumbnail() ) :
                                the_post_thumbnail('full', array('class' => 'object-cover aspect-square'));
?>
                        <a href="<?php the_permalink(); ?>" alt="<?php the_title_attribute(); ?>" class="absolute h-full inset-0 opacity-0 hover:opacity-100 bg-black/60 cursor-pointer p-4">
<?php
                            else:
?>
                        <a href="<?php the_permalink(); ?>" alt="<?php the_title_attribute(); ?>" class="absolute h-full inset-0 opacity-100 hover:bg-black/60 bg-gray-700 cursor-pointer p-4">
<?php
                            endif;
?>
                            <div class="">
		                <h1 class="text-4xl text-white my-2 font-extrabold"><?php the_title(); ?></h1>
                                <p class="text-xl text-gray-400 my-1"><?php the_date(); ?></p>
                            </div>
                        </a>
                    </div>
		</article><!-- #post-## -->
                <?php
                        }
                    }
                    wp_reset_postdata();
                ?>
            </div>
            
        </section>
        <hr>
        <footer class="w-screen h-20 flex flex-col justify-center">
            <div class="flex flex-col items-center text-center justify-center text-sm">
                <p>Copyright © <?php echo do_shortcode("[year]"); ?> | Stijn Cappetijn</p>
                <p>Theme created with ❤️ by <a href="https://geertroks.com" class="underline">Geert Roks</a></p>
            </div>
        </footer>
        </div>
        <?php wp_footer(); ?>
    </body>
</html>
