<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
$this->title = 'Web Skills';
?>
<!-- Preloader -->
<div id="preloader">
    <div id="load"></div>
</div>

<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                <i class="fa fa-bars"></i>
            </button>
            <?= Html::a('<h1>WEB SKILLS</h1>', ['site/index'], ['class' => 'navbar-brand']); ?>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#intro">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#service">Service</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
<!-- Section: intro -->
<section id="intro" class="intro">

    <div class="slogan">
        <h2>ДОБРО ПОЖАЛОВАТЬ</h2>
        <h4>Услуги по веб-разработке</h4>
    </div>
    <div class="page-scroll">
        <a href="#service" class="btn btn-circle">
            <i class="fa fa-angle-double-down animated"></i>
        </a>
    </div>
</section>
<!-- /Section: intro -->

<!-- Section: about -->
<section id="about" class="home-section text-center">
    <div class="heading-about">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="wow bounceInDown" data-wow-delay="0.4s">
                        <div class="section-heading">
                            <h2>About me</h2>
                            <i class="fa fa-2x fa-angle-down"></i>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">

        <div class="row">
            <div class="col-lg-2 col-lg-offset-5">
                <hr class="marginbot-50">
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 text-center">
                <div class="wow bounceInUp" data-wow-delay="0.2s">
                    <div class="team boxed-grey">
                        <div class="inner">
                            <h5>Sasha Grischuk</h5>
                            <p class="subtitle">PHP, JS Developer</p>
                            <div class="avatar text-center" >
                                <img src="img/team/sasha.jpg" alt="" class="img-responsive img-circle" style="margin: 0 auto;" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Section: about -->


<!-- Section: services -->
<section id="service" class="home-section text-center bg-gray">

    <div class="heading-about">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="wow bounceInDown" data-wow-delay="0.4s">
                        <div class="section-heading">
                            <h2>My Services</h2>
                            <i class="fa fa-2x fa-angle-down"></i>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-lg-offset-5">
                <hr class="marginbot-50">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3 col-md-3">
                <div class="wow fadeInLeft" data-wow-delay="0.2s">
                    <div class="service-box">
                        <div class="service-icon">
                            <img src="img/icons/service-1.png" alt="" />
                        </div>
                        <div class="service-desc">
                            <h5>Разработка сайтов</h5>
                            <p>Занимаюсь разработкой веб-сайтов с использованием Yii фреймворка.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-md-3">
                <div class="wow fadeInUp" data-wow-delay="0.2s">
                    <div class="service-box">
                        <div class="service-icon">
                            <img src="img/icons/service-2.png" alt="" />
                        </div>
                        <div class="service-desc">
                            <h5>Разработка стартапов</h5>
                            <p>С радостью принимаю участие в разработке стартапов.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-md-3">
                <div class="wow fadeInUp" data-wow-delay="0.2s">
                    <div class="service-box">
                        <div class="service-icon">
                            <img src="img/icons/service-3.png" alt="" />
                        </div>
                        <div class="service-desc">
                            <h5>Техническая поддержка</h5>
                            <p>Поддержка и доработка сеществующих проектов на PHP.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-md-3">
                <div class="wow fadeInRight" data-wow-delay="0.2s">
                    <div class="service-box">
                        <div class="service-icon">
                            <img src="img/icons/service-4.png" alt="" />
                        </div>
                        <div class="service-desc">
                            <h5>Другие подобные услуги</h5>
                            <p>Другие нестандартные задачи и услуги.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Section: services -->

<!-- Section: contact -->
<section id="contact" class="home-section text-center">
    <div class="heading-contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="wow bounceInDown" data-wow-delay="0.4s">
                        <div class="section-heading">
                            <h2>Contacts</h2>
                            <i class="fa fa-2x fa-angle-down"></i>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">

        <div class="row">
            <div class="col-lg-2 col-lg-offset-5">
                <hr class="marginbot-50">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="boxed-grey">
                    <form id="contact-form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">
                                        Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter name" required="required" />
                                </div>
                                <div class="form-group">
                                    <label for="email">
                                        Email Address</label>
                                    <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
                                </span>
                                        <input type="email" class="form-control" id="email" placeholder="Enter email" required="required" /></div>
                                </div>
                                <div class="form-group">
                                    <label for="subject">
                                        Subject</label>
                                    <input type="text" class="form-control" id="subject" placeholder="Enter subject" required="required" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">
                                        Message</label>
                                    <textarea name="message" id="message" class="form-control" rows="9" cols="25" required="required"
                                              placeholder="Message"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-skin pull-right" id="btnContactUs">
                                    Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="widget-contact">

                    <address>
                        <strong>Ukraine</strong><br>
                        <abbr title="Skype">Skype:</abbr> alexandr_grischuk
                    </address>

                    <address>
                        <strong>Email</strong><br>
                        <a href="mailto:#">grischuk.alexandr@gmail.com</a>
                    </address>
                    <address>
                        <strong>Social networks</strong><br>
                        <ul class="soc">
                            <li><a class="soc-facebook" href="https://www.facebook.com/grischuk.sasha" target="_blank"></a></li>
                            <li><a class="soc-google" href="https://plus.google.com/102877191415258150576/posts" target="_blank"></a></li>
                            <li><a class="soc-linkedin" href="https://www.linkedin.com/profile/view?id=301231885&trk=miniprofile-name-link" target="_blank"></a></li>
                            <li><a class="soc-github" href="https://github.com/grischuk2703" target="_blank"></a></li>
                            <li><a class="soc-vkontakte soc-icon-last" href="http://vk.com/grischuk_sasha" target="_blank"></a></li>
                        </ul>
                    </address>

                </div>
            </div>
        </div>

    </div>
</section>
<!-- /Section: contact -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="wow shake" data-wow-delay="0.4s">
                    <div class="page-scroll marginbot-30">
                        <a href="#intro" id="totop" class="btn btn-circle">
                            <i class="fa fa-angle-double-up animated"></i>
                        </a>
                    </div>
                </div>
                <p>&copy;Copyright <?= date('Y') ?> - Web Skills. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>
