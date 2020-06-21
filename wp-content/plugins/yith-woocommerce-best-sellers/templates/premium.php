<style>
.section{
    margin-left: -20px;
    margin-right: -20px;
    font-family: "Raleway",san-serif;
    overflow-x: hidden;
}
.section h1{
    text-align: center;
    text-transform: uppercase;
    color: #808a97;
    font-size: 35px;
    font-weight: 700;
    line-height: normal;
    display: inline-block;
    width: 100%;
    margin: 50px 0 0;
}
.section ul{
    list-style-type: disc;
    padding-left: 15px;
}
.section:nth-child(even){
    background-color: #fff;
}
.section:nth-child(odd){
    background-color: #f1f1f1;
}
.section .section-title img{
    display: table-cell;
    vertical-align: middle;
    width: auto;
    margin-right: 15px;
}
.section h2,
.section h3 {
    display: inline-block;
    vertical-align: middle;
    padding: 0;
    font-size: 24px;
    font-weight: 700;
    color: #808a97;
    text-transform: uppercase;
}

.section .section-title h2{
    display: table-cell;
    vertical-align: middle;
    line-height: 25px;
}

.section-title{
    display: table;
}

.section h3 {
    font-size: 14px;
    line-height: 28px;
    margin-bottom: 0;
    display: block;
}

.section p{
    font-size: 13px;
    margin: 25px 0;
}
.section ul li{
    margin-bottom: 4px;
}
.landing-container{
    max-width: 750px;
    margin-left: auto;
    margin-right: auto;
    padding: 50px 0 30px;
}
.landing-container:after{
    display: block;
    clear: both;
    content: '';
}
.landing-container .col-1,
.landing-container .col-2{
    float: left;
    box-sizing: border-box;
    padding: 0 15px;
}
.landing-container .col-1 img{
    width: 100%;
}
.landing-container .col-1{
    width: 55%;
}
.landing-container .col-2{
    width: 45%;
}
.premium-cta{
    background-color: #808a97;
    color: #fff;
    border-radius: 6px;
    padding: 20px 15px;
}
.premium-cta:after{
    content: '';
    display: block;
    clear: both;
}
.premium-cta p{
    margin: 7px 0;
    font-size: 14px;
    font-weight: 500;
    display: inline-block;
    width: 60%;
}
.premium-cta a.button{
    border-radius: 6px;
    height: 60px;
    float: right;
    background: url(<?php echo YITH_WCBSL_ASSETS_URL?>/images/upgrade.png) #ff643f no-repeat 13px 13px;
    border-color: #ff643f;
    box-shadow: none;
    outline: none;
    color: #fff;
    position: relative;
    padding: 9px 50px 9px 70px;
}
.premium-cta a.button:hover,
.premium-cta a.button:active,
.premium-cta a.button:focus{
    color: #fff;
    background: url(<?php echo YITH_WCBSL_ASSETS_URL?>/images/upgrade.png) #971d00 no-repeat 13px 13px;
    border-color: #971d00;
    box-shadow: none;
    outline: none;
}
.premium-cta a.button:focus{
    top: 1px;
}
.premium-cta a.button span{
    line-height: 13px;
}
.premium-cta a.button .highlight{
    display: block;
    font-size: 20px;
    font-weight: 700;
    line-height: 20px;
}
.premium-cta .highlight{
    text-transform: uppercase;
    background: none;
    font-weight: 800;
    color: #fff;
}

.section.one{
    background-image: url(<?php echo YITH_WCBSL_ASSETS_URL?>/images/01-bg.png); background-repeat: no-repeat; background-position: 85% 75%
}
.section.two{
    background-image: url(<?php echo YITH_WCBSL_ASSETS_URL?>/images/02-bg.png); background-repeat: no-repeat; background-position: 15% 100%
}
.section.three{
    background-image: url(<?php echo YITH_WCBSL_ASSETS_URL?>/images/03-bg.png); background-repeat: no-repeat; background-position: 85% 75%
}
.section.four{
    background-image: url(<?php echo YITH_WCBSL_ASSETS_URL?>/images/04-bg.png); background-repeat: no-repeat; background-position: 15% 100%
}
.section.five{
    background-image: url(<?php echo YITH_WCBSL_ASSETS_URL?>/images/05-bg.png); background-repeat: no-repeat; background-position: 85% 75%
}
.section.six{
    background-image: url(<?php echo YITH_WCBSL_ASSETS_URL?>/images/06-bg.png); background-repeat: no-repeat; background-position: 15% 100%
}
.section.seven{
    background-image: url(<?php echo YITH_WCBSL_ASSETS_URL?>/images/07-bg.png); background-repeat: no-repeat; background-position: 85% 75%
}
.section.eight{
    background-image: url(<?php echo YITH_WCBSL_ASSETS_URL?>/images/08-bg.png); background-repeat: no-repeat; background-position: 15% 100%
}
.section.nine{
    background-image: url(<?php echo YITH_WCBSL_ASSETS_URL?>/images/09-bg.png); background-repeat: no-repeat; background-position: 85% 75%
}

@media (max-width: 768px) {
    .section{margin: 0}
    .premium-cta p{
        width: 100%;
    }
    .premium-cta{
        text-align: center;
    }
    .premium-cta a.button{
        float: none;
    }
}

@media (max-width: 480px){
    .wrap{
        margin-right: 0;
    }
    .section{
        margin: 0;
    }
    .landing-container .col-1,
    .landing-container .col-2{
        width: 100%;
        padding: 0 15px;
    }
    .section-odd .col-1 {
        float: left;
        margin-right: -100%;
    }
    .section-odd .col-2 {
        float: right;
        margin-top: 65%;
    }
}

@media (max-width: 320px){
    .premium-cta a.button{
        padding: 9px 20px 9px 70px;
    }

    .section .section-title img{
        display: none;
    }
}
</style>
<div class="landing">
    <div class="section section-cta section-odd">
        <div class="landing-container">
            <div class="premium-cta">
                <p>
                    <?php echo sprintf( __('Upgrade to %1$spremium version%2$s of %1$sYITH WooCommerce Best Sellers%2$s to benefit from all features!','yith-wcbls'),'<span class="highlight">','</span>' );?>
                </p>
                <a href="<?php echo $this->get_premium_landing_uri() ?>" target="_blank" class="premium-cta-button button btn">
                    <span class="highlight"><?php _e('UPGRADE','yith-wcbls');?></span>
                    <span><?php _e('to the premium version','yith-wcbls');?></span>
                </a>
            </div>
        </div>
    </div>
    <div class="one section section-even clear">
        <h1><?php _e('Premium Features','yith-wcbls');?></h1>
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCBSL_ASSETS_URL?>/images/01.png" alt="<?php _e('Sale index','yith-wcbls');?>" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCBSL_ASSETS_URL?>/images/01-icon.png" alt="icon 01"/>
                    <h2><?php _e('Sale index','yith-wcbls');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('Shop page is richer because it adds to your best-seller products a badge index of sales. This index informs users about %1$ssales trend%2$s for each product, if they have increased or decreased in comparison to the previous day, week, month or year. A simple way to show everyone most requested products in your store.', 'yith-wcbls'), '<b>', '</b>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="two section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCBSL_ASSETS_URL?>/images/02-icon.png" alt="icon 02" />
                    <h2><?php _e('Sales quantity','yith-wcbls');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('Administrators only will be able to see also the number of items sold for registered products since the first order or since the day, the week, the month or year before. In a glance, then, you will have an %1$soverview on products%2$s in your shop.', 'yith-wcbls'), '<b>', '</b>');?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WCBSL_ASSETS_URL?>/images/02.png" alt="<?php _e('sales quantity','yith-wcbls');?>" />
            </div>
        </div>
    </div>
    <div class="three section section-even clear">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCBSL_ASSETS_URL?>/images/03.png" alt="<?php _e('Product category','yith-wcbls');?>" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCBSL_ASSETS_URL?>/images/03-icon.png" alt="icon 03" />
                    <h2><?php _e( 'Product category','yith-wcbls');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('Thanks to the premium version, your users will be able to display %1$stop 100 best sellers for each category%2$s in your shop. Only this way, you will be able to see products belonging to the same category sorted according to number of sales.', 'yith-wcbls'), '<b>', '</b>','<br>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="four section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCBSL_ASSETS_URL?>/images/04-icon.png" alt="icon 04" />
                    <h2><?php _e('"Bestseller" badge ','yith-wcbls');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('Highlight all products that have generated more sales by applying to them the badge %1$s"Bestseller"%2$s, which will be shown both in shop page and in product detail page. But this is not all: change its %1$scolours%2$s and %1$stext%2$s to suit it to the style of your theme.', 'yith-wcbls'), '<b>', '</b>');?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WCBSL_ASSETS_URL?>/images/04.png" alt="Badge" />
            </div>
        </div>
    </div>
    <div class="five section section-even clear">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCBSL_ASSETS_URL?>/images/05.png" alt="<?php _e('Best seller icon','yith-wcbls');?>" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCBSL_ASSETS_URL?>/images/05-icon.png" alt="icon 05" />
                    <h2><?php _e('Best seller icon','yith-wcbls');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('Another way to highlight your best-seller products (among the first 100 with more sales). Use the icon made available with the plugin or use your own custom icon to give to mark your product as %1$sbest seller%2$s but by giving it your personal style.','yith-wcbls'),'<b>','</b>','<br>'); ?>
                </p>
            </div>
        </div>
    </div>
    <div class="six section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCBSL_ASSETS_URL?>/images/06-icon.png" alt="icon 06" />
                    <h2><?php _e('2 widgets','yith-wcbls');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __( 'Two %1$spowerful tools%2$s to make sidebars of your site richer with interesting information about best seller products. Thanks to these widgets, you will be able to show best sellers of the whole shop, or best seller belonging to all or just some selected categories.','yith-wcbls' ),'<b>','</b>','<br>' ) ?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WCBSL_ASSETS_URL?>/images/06.png" alt="Widgets" />
            </div>
        </div>
    </div>
    <div class="seven section section-even clear">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCBSL_ASSETS_URL?>/images/07.png" alt="Shortcode" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCBSL_ASSETS_URL?>/images/07-icon.png" alt="icon 07" />
                    <h2><?php _e('Shortcode','yith-wcbls');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('Enjoy now the countless opportunities offered to you by the plugin YITH WooCommerce Best Sellers. One of useful features is the possibility to use the shortcode %1$s"Best Seller Slider"%2$s to display best-seller products in a complete and dynamic way.','yith-wcbls'),'<b>','</b>'); ?>
                </p>
            </div>
        </div>
    </div>
    <div class="eight section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCBSL_ASSETS_URL?>/images/08-icon.png" alt="icon 08" />
                    <h2><?php _e('Rss','yith-wcbls');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __( 'Let your users be informed about products of your shop and keep always updated thanks to the possibility to subscribe %1$sRSS feed%2$s of your site. A simple additional feature for a top service!','yith-wcbls' ),'<b>','</b>','<br>' ) ?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WCBSL_ASSETS_URL?>/images/08.png" alt="Rss" />
            </div>
        </div>
    </div>
    <div class="section section-cta section-odd">
        <div class="landing-container">
            <div class="premium-cta">
                <p>
                    <?php echo sprintf( __('Upgrade to %1$spremium version%2$s of %1$sYITH WooCommerce Best Sellers%2$s to benefit from all features!','yith-wcbls'),'<span class="highlight">','</span>' );?>
                </p>
                <a href="<?php echo $this->get_premium_landing_uri() ?>" target="_blank" class="premium-cta-button button btn">
                    <span class="highlight"><?php _e('UPGRADE','yith-wcbls');?></span>
                    <span><?php _e('to the premium version','yith-wcbls');?></span>
                </a>
            </div>
        </div>
    </div>
</div>