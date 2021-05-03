<?php
/**
 * Sidebar setup for fundament extended footer.
 *
 * @package fundament_wp
 */
$container = get_theme_mod('theme_layout_container', 'container');
?>

<?php if (is_active_sidebar('footerfundamentextended')) : ?>

    <!-- ******************* The Footer Full-width Widget Area ******************* -->
    <div class="wrapper fundament-default-footer" id="wrapper-footer-full">
        <div class="container" id="footer-full-content" tabindex="-1">
            <div class="footer-separator">
                <i data-feather="message-circle"></i> CONTACT
            </div>
            <div class="row">
                <div class="footer-widget col-lg-1 col-md-2 col-sm-2 col-xs-6 col-3">
                    <div class="textwidget custom-html-widget">
                        <a href="/"><img src="https://fundament.acdh.oeaw.ac.at/common-assets/images/acdh_logo.svg" class="image" alt="ACDH Logo" style="max-width: 100%; height: auto;" title="ACDH Logo"></a>
                    </div>
                </div><!-- .footer-widget -->
                <div class="footer-widget col-lg-3 col-md-3 col-sm-6 col-9">
                    <div class="textwidget custom-html-widget">
                        <p>
                            ACDH-CH
                            <br>
                            Austrian Centre for Digital Humanities <br/> and Cultural Heritage
                            <br>
                            Austrian Academy of Sciences
                        </p>
                        <p>
                            Sonnenfelsgasse 19,
                            <br>
                            1010 Vienna
                        </p>
                        <p>
                            T: +43 1 51581-2200
                            <br>
                            E: <a href="mailto:acdh@oeaw.ac.at">acdh@oeaw.ac.at</a>
                        </p>
                    </div>
                </div><!-- .footer-widget -->
                <div class="footer-widget col-lg-4 col-md-4 col-sm-12">
                    <div class="textwidget custom-html-widget">
                        <?php dynamic_sidebar('footerfundamentextended'); ?>
                    </div>
                </div><!-- .footer-widget -->
                <div class="footer-widget col-lg-4 col-md-3 col-sm-12">
                    <div class="textwidget custom-html-widget">
                        <h6>HELPDESK</h6>
                        <p>ACDH-CH runs a helpdesk offering advice for questions related to various digital humanities topics.</p>
                        <p>
                            <a class="helpdesk-button" href="mailto:acdh-helpdesk@oeaw.ac.at">ASK US!</a>
                        </p>
                    </div>
                </div><!-- .footer-widget -->
            </div>
        </div>
    </div><!-- #wrapper-footer-full -->
    <div class="footer-imprint-bar" id="wrapper-footer-secondary" style="text-align:center; padding:0.4rem 0; font-size: 0.9rem;">
        © Copyright OEAW | <a href="/imprint">Impressum/Imprint</a>
    </div>

<?php endif; ?>
