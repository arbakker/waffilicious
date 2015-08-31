<?php
/**
 * Template Name: 401 Unauthorized
 *
 * The template for displaying 401 pages (Unauthorized).
 *
 */

get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="error-template">
                <h1>
                    This is not where you parked your car</h1>
                <h2>
                    Unauthorized</h2>
                <div class="error-details">
                    You are not allowed to view this page. Go away!
                </div>
                <div class="error-actions">
                    <a href="<?php echo site_url();?>" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>
                        Take Me Home </a><a href="mailto:waf@wur.nl" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope"></span> Contact Support </a>
                </div>
            </div>
        </div>
    </div>
</div>


    </div><!-- #primary .content-area -->
 </main>
<?php get_footer(); ?>
