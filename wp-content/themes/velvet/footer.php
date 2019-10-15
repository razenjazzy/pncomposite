<?php
defined('ABSPATH') or die('Keep Silent');
?>
</div>
<!-- .contents -->

<!-- copyright-section start -->
<footer class="footer">

    <?php if (is_active_sidebar('velvet-footer-widget')): ?>
        <div class="footer-top-wrapper">
            <div class="row">
                <div class="col-sm-12">
                    <div class="footer-widgets-wrapper">
                        <div class="row">
                            <?php dynamic_sidebar('velvet-footer-widget') ?>
                        </div>
                    </div>
                </div>
            </div> <!-- .row -->
        </div> <!-- .footer-top-wrapper -->
    <?php endif; ?> <!-- / velvet-footer-widget -->

    <div class="copyright">
        <div class="row">
            <div class="col-sm-6">
                <div class="copyright-info">
                    <?php if (velvet_option('footer-copyright')) : ?>
                        <span>
							<?php echo wp_kses(velvet_option('footer-copyright'), array(
                                'a' => array(
                                    'href' => array(),
                                    'title' => array(),
                                    'target' => array()
                                ),
                                'br' => array(),
                                'em' => array(),
                                'strong' => array(),
                                'ul' => array(),
                                'li' => array(),
                                'p' => array(),
                            )); ?>
						</span>
                    <?php else : ?>
                        <span>
	                        <?php printf(
                                wp_kses(__('Copyright &copy; P.N.Composite. All Rights Reserved.', 'velvet'),
                                    array(
                                        'a' => array(
                                            'href' => array(),
                                            'title' => array(),
                                            'class' => array()
                                        )
                                    )), date('Y'), esc_html__('velvet', 'velvet'), "<a href='http://www.themehippo.com' title='Visit themehippo.com!'>ThemeHippo.com</a>"); ?>
						</span>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (velvet_option('social-section-show', FALSE, TRUE) || velvet_option('back-to-top')) : ?>
                <div class="col-sm-6">
                    <div class="social-section">
                        <ul class="zoom-social-icons-list zoom-social-icons-list--without-canvas zoom-social-icons-list--rounded zoom-social-icons-list--align-left zoom-social-icons-list--no-labels">
                            
                            <li class="zoom-social_icons-list__item">
                                <a class="zoom-social_icons-list__link" href="https://facebook.com/pncomposite/" target="_blank">

                                    <span class="screen-reader-text">facebook</span>

                                    <span class="zoom-social_icons-list-span socicon socicon-facebook" data-hover-rule="color" data-hover-color="#ff6666" style="color : #3b5998; font-size: 20px; padding:9px"></span>
                                </a>
                            </li>
							

                            <li class="zoom-social_icons-list__item">
                                <a class="zoom-social_icons-list__link" href="https://www.youtube.com/channel/UC3h4iCEkqpWsUPMA-umBQLg" target="_blank">

                                    <span class="screen-reader-text">twitter</span>

                                    <span class="fa fa-youtube"  data-hover-color="#ff6666"   font-size: 20px; padding: 9px;"></span>
                                </a>
                            </li>
                            
                            <li class="zoom-social_icons-list__item">
                                <a class="zoom-social_icons-list__link" href="https://instagram.com/" target="_blank">

                                    <span class="screen-reader-text">instagram</span>

                                    <span class="zoom-social_icons-list-span socicon socicon-instagram" data-hover-rule="color" data-hover-color="#ff6666" style="color: rgb(226, 226, 226); font-size: 20px; padding: 9px;" data-old-color="rgb(226, 226, 226)"></span>
                                </a>
                            </li>


                            <li class="zoom-social_icons-list__item">
                                <a class="zoom-social_icons-list__link" href="http://mail.pncomposite.com" target="_blank">
                                    <span class="screen-reader-text">mail</span>
                                    <span class="zoom-social_icons-list-span socicon socicon-mail" data-hover-rule="color" data-hover-color="#f2f2f2" style="color: rgb(34, 180, 216); font-size: 20px; padding: 9px;" data-old-color="rgb(34, 180, 216)"></span>
                                </a>
                            </li>
                            
                        </ul>
                    </div><!-- .social-section -->
                </div>
            <?php endif; ?>

        </div><!-- .row -->
    </div><!-- .copyright -->
</footer> <!-- footer end -->
<?php if (offCanvas_On_InnerPusher(velvet_option('offcanvas-menu-effect', FALSE, 'reveal'))) : ?>
    <nav class="menu-wrapper" id="offcanvasmenu">
        <button type="button" class="close close-sidebar">&times;</button>
        <div>
            <div>
                <?php dynamic_sidebar('offcanvas-menu') ?>
            </div>
        </div>
    </nav>
<?php endif; ?>

<?php do_action('velvet_theme_end_inner_wrapper'); ?>
<?php do_action('hippo_theme_end_inner_wrapper'); ?>

</div><!-- .container -->
</div><!-- .container-wrapper -->
</div> <!-- .pusher -->
<?php do_action('velvet_theme_after_inner_wrapper'); ?>
<?php do_action('hippo_theme_after_inner_wrapper'); ?>

<?php if (!offCanvas_On_InnerPusher(velvet_option('offcanvas-menu-effect', FALSE, 'reveal'))) : ?>
    <nav class="menu-wrapper" id="offcanvasmenu">
        <button type="button" class="close close-sidebar">&times;</button>
        <div>
            <div>
                <?php dynamic_sidebar('offcanvas-menu') ?>
            </div>
        </div>
    </nav>
<?php endif; ?>
</div> <!-- #wrapper -->
<?php wp_footer(); ?>
<!-- Load Facebook SDK for JavaScript -->
  <div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
	</script>
</body>
</html>