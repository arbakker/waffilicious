<?php
/**
 * Template Name: 404 Not Found
 *
 * The template for displaying 404 pages (Not found).
 *
 */

get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="error-template">
                <h1>
                    Oops!</h1>
                <h2>
                    Page Not Found</h2>
                <div class="error-details">
                    An error has occured, requested page not found!
                </div>
                <div class="error-actions">
                  <a href="#" class="btn btn-primary btn-lg" data-target="#loginmodal" data-toggle="modal"><i class='fa fa-home fa-lg'></i>
                      Go home!</a>
                      <a href="mailto:waf@wur.nl" class="btn btn-default btn-lg"><i class='fa fa-envelope fa-lg'></i> Contact WAF</a>
                </div>
            </div>
        </div>
    </div>
</div>


    </div><!-- #primary .content-area -->
 </main>
<?php get_footer(); ?>
