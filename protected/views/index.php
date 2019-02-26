<?
/* @var $this SiteController */
/* @var $newestProgramDataProvider CActiveDataProvider */
/* @var $newestGameDataProvider CActiveDataProvider */
/* @var $newestEducationDataProvider CActiveDataProvider */
/* @var $suggestedDataProvider CActiveDataProvider */
/* @var $advertise Advertises */

Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/owl.carousel.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/jquery.mousewheel.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/owl.carousel.min.js');
?>

<<<<<<< HEAD
    <div class="book-box">
        <div class="top-box">
            <div class="title pull-right">
                <h2>جدیدترین کتاب ها</h2>
=======
    <div class="slider">
        <div class="slider-item">
            <div class="slider-thumbnail"><img src="uploads/slide/1.jpg" alt="عنوان اسلاید"></div>
            <div class="slider-overlay">
                <a href="#" class="slider-overlay-nav slider-next"><i class="arrow-icon"></i></a>
                <a href="#" class="slider-overlay-nav slider-prev"><i class="arrow-icon"></i></a>
                <a href="#" class="slider-overlay-link">
                    <img src="uploads/books/images/8420.jpg" alt="عنوان کتاب">
                    <h3>مزرعه حیوانات<small>جرج اورول</small></h3>
                </a>
            </div>
        </div>
        <div class="slider-item">
            <div class="slider-thumbnail"><img src="uploads/slide/2.jpg" alt="عنوان اسلاید"></div>
            <div class="slider-overlay">
                <a href="#" class="slider-overlay-nav slider-next"><i class="arrow-icon"></i></a>
                <a href="#" class="slider-overlay-nav slider-prev"><i class="arrow-icon"></i></a>
                <a href="#" class="slider-overlay-link">
                    <img src="uploads/books/images/12206.jpg" alt="عنوان کتاب">
                    <h3>فتح خون<small>سید مرتضی آوینی</small></h3>
                </a>
            </div>
        </div>
        <div class="slider-item">
            <div class="slider-thumbnail"><img src="uploads/slide/3.jpg" alt="عنوان اسلاید"></div>
            <div class="slider-overlay">
                <a href="#" class="slider-overlay-nav slider-next"><i class="arrow-icon"></i></a>
                <a href="#" class="slider-overlay-nav slider-prev"><i class="arrow-icon"></i></a>
                <a href="#" class="slider-overlay-link">
                    <img src="uploads/books/images/12210.jpg" alt="عنوان کتاب">
                    <h3>مطلع مهر<small>امیرحسین بانکی پور فرد</small></h3>
                </a>
>>>>>>> origin/master
            </div>
        </div>
    </div>
    <div class="categories">
        <div class="container">
            <div class="heading">
                <h2>دسته بندی ها</h2>
            </div>
            <div class="is-carousel" data-items="4" data-margin="10" data-dots="1" data-nav="0" data-mouse-drag="1" data-responsive='{"1200":{"items":"4"},"992":{"items":"3"},"768":{"items":"3"},"650":{"items":"2"},"0":{"items":"1"}}'>
                <div class="cat-item">
                    <img src="uploads/categories/images/1.jpg" alt="عنوان دسته بندی">
                    <div class="caption">
                        <div class="icon" style="background: #accf3d url('uploads/categories/svg/1.svg') no-repeat center;background-size: 40px;"></div>
                        <div class="heading"><h4>پزشکی</h4></div>
                        <span class="additional">110 کتاب</span>
                    </div>
                </div>
                <div class="cat-item">
                    <img src="uploads/categories/images/2.jpg" alt="عنوان دسته بندی">
                    <div class="caption">
                        <div class="icon" style="background: #2e9fc7 url('uploads/categories/svg/2.svg') no-repeat center;background-size: 40px;"></div>
                        <div class="heading"><h4>مهندسی</h4></div>
                        <span class="additional">100 کتاب</span>
                    </div>
                </div>
                <div class="cat-item">
                    <img src="uploads/categories/images/3.jpg" alt="عنوان دسته بندی">
                    <div class="caption">
                        <div class="icon" style="background: #e96e44 url('uploads/categories/svg/3.svg') no-repeat center;background-size: 40px;"></div>
                        <div class="heading"><h4>حسابداری</h4></div>
                        <span class="additional">80 کتاب</span>
                    </div>
                </div>
                <div class="cat-item">
                    <img src="uploads/categories/images/4.jpg" alt="عنوان دسته بندی">
                    <div class="caption">
                        <div class="icon" style="background: #fbb11a url('uploads/categories/svg/4.svg') no-repeat center;background-size: 40px;"></div>
                        <div class="heading"><h4>کشاورزی</h4></div>
                        <span class="additional">41 کتاب</span>
                    </div>
                </div>
                <div class="cat-item">
                    <img src="uploads/categories/images/1.jpg" alt="عنوان دسته بندی">
                    <div class="caption">
                        <div class="icon" style="background: #fbb11a url('uploads/categories/svg/1.svg') no-repeat center;background-size: 40px;"></div>
                        <div class="heading"><h4>پزشکی</h4></div>
                        <span class="additional">41 کتاب</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="offers paralax">
        <div class="container">
            <div class="content">
                <div class="head">
                    <h2>پیشنهاد ما</h2>
                </div>
                <div class="is-carousel auto-width" data-items='{"1200":"5", "1024":"4", "992":"4", "768":"3", "650":"3", "480":"2", "0":"1"}' data-margin='{"768":"20", "0":"10"}' data-nav="1" data-dots="1">
                    <div class="thumbnail-container">
                        <div class="thumbnail full">
                            <div class="thumb">
                                <a href="#" title="عنوان کتاب">
                                    <img src="uploads/books/images/10561.jpg" alt="نام کتاب" >
                                    <div class="thumbnail-overlay"></div>
                                    <div class="thumbnail-overlay-icon">
                                        <i class="icon"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="caption">
                                <div class="cat-icon" style="background: #fbb11a;">
                                    <a href="#" title="عنوان دسته"><img src="uploads/categories/svg/4.svg"></a>
                                </div>
                                <div class="stars">
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon off"></i>
                                </div>
                                <h4><a href="#" title="عنوان کتاب">فرزندان ایرانیم</a></h4>
                                <span class="price">رایگان</span>
                                <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                            </div>
                        </div>
                    </div>
                    <div class="thumbnail-container">
                        <div class="thumbnail full">
                            <div class="thumb">
                                <a href="#" title="عنوان کتاب">
                                    <img src="uploads/books/images/12439.jpg" alt="نام کتاب" >
                                    <div class="thumbnail-overlay"></div>
                                    <div class="thumbnail-overlay-icon">
                                        <i class="icon"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="caption">
                                <div class="cat-icon" style="background: #859d64;">
                                    <a href="#" title="عنوان دسته"><img src="uploads/categories/svg/3.svg"></a>
                                </div>
                                <div class="stars">
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon off"></i>
                                </div>
                                <h4><a href="#" title="عنوان کتاب">من دیگر ما</a></h4>
                                <span class="price">رایگان</span>
                                <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                            </div>
                        </div>
                    </div>
                    <div class="thumbnail-container">
                        <div class="thumbnail full">
                            <div class="thumb">
                                <a href="#" title="عنوان کتاب">
                                    <img src="uploads/books/images/12957.jpg" alt="نام کتاب" >
                                    <div class="thumbnail-overlay"></div>
                                    <div class="thumbnail-overlay-icon">
                                        <i class="icon"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="caption">
                                <div class="cat-icon" style="background: #35a7c8;">
                                    <a href="#" title="عنوان دسته"><img src="uploads/categories/svg/2.svg"></a>
                                </div>
                                <div class="stars">
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon off"></i>
                                </div>
                                <h4><a href="#" title="عنوان کتاب">کافکا در ساحل</a></h4>
                                <span class="price">رایگان</span>
                                <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                            </div>
                        </div>
                    </div>
                    <div class="thumbnail-container">
                        <div class="thumbnail full">
                            <div class="thumb">
                                <a href="#" title="عنوان کتاب">
                                    <img src="uploads/books/images/914.jpg" alt="نام کتاب" >
                                    <div class="thumbnail-overlay"></div>
                                    <div class="thumbnail-overlay-icon">
                                        <i class="icon"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="caption">
                                <div class="cat-icon" style="background: #fbb11a;">
                                    <a href="#" title="عنوان دسته"><img src="uploads/categories/svg/1.svg"></a>
                                </div>
                                <div class="stars">
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon off"></i>
                                </div>
                                <h4><a href="#" title="عنوان کتاب">دختر شینا</a></h4>
                                <span class="price">4.000 تومان</span>
                                <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                            </div>
                        </div>
                    </div>
                    <div class="thumbnail-container">
                        <div class="thumbnail full">
                            <div class="thumb">
                                <a href="#" title="عنوان کتاب">
                                    <img src="uploads/books/images/12206.jpg" alt="نام کتاب" >
                                    <div class="thumbnail-overlay"></div>
                                    <div class="thumbnail-overlay-icon">
                                        <i class="icon"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="caption">
                                <div class="cat-icon" style="background: #e96e44;">
                                    <a href="#" title="عنوان دسته"><img src="uploads/categories/svg/2.svg"></a>
                                </div>
                                <div class="stars">
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon off"></i>
                                </div>
                                <h4><a href="#" title="عنوان کتاب">فتح خون</a></h4>
                                <span class="price">1.500 تومان</span>
                                <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                            </div>
                        </div>
                    </div>
                    <div class="thumbnail-container">
                        <div class="thumbnail full">
                            <div class="thumb">
                                <a href="#" title="عنوان کتاب">
                                    <img src="uploads/books/images/8420.jpg" alt="نام کتاب" >
                                    <div class="thumbnail-overlay"></div>
                                    <div class="thumbnail-overlay-icon">
                                        <i class="icon"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="caption">
                                <div class="cat-icon" style="background: #2e9fc7;">
                                    <a href="#" title="عنوان دسته"><img src="uploads/categories/svg/3.svg"></a>
                                </div>
                                <div class="stars">
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon off"></i>
                                </div>
                                <h4><a href="#" title="عنوان کتاب">مزرعه حیوانات</a></h4>
                                <span class="price">1.500 تومان</span>
                                <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                            </div>
                        </div>
                    </div>
                    <div class="thumbnail-container">
                        <div class="thumbnail full">
                            <div class="thumb">
                                <a href="#" title="عنوان کتاب">
                                    <img src="uploads/books/images/12210.jpg" alt="نام کتاب" >
                                    <div class="thumbnail-overlay"></div>
                                    <div class="thumbnail-overlay-icon">
                                        <i class="icon"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="caption">
                                <div class="cat-icon" style="background: #fbb11a;">
                                    <a href="#" title="عنوان دسته"><img src="uploads/categories/svg/4.svg"></a>
                                </div>
                                <div class="stars">
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon off"></i>
                                </div>
                                <h4><a href="#" title="عنوان کتاب">مطلع مهر</a></h4>
                                <span class="price">1.500 تومان</span>
                                <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="newest">
        <div class="container">
            <div class="heading">
                <h2>تازه ترین کتابها</h2>
            </div>
            <div class="thumbnail-list">
                <div class="thumbnail-container">
                    <div class="thumbnail simple">
                        <div class="thumb">
                            <a href="#" title="عنوان کتاب">
                                <img src="uploads/books/images/10561.jpg" alt="نام کتاب" >
                                <div class="thumbnail-overlay"></div>
                                <div class="thumbnail-overlay-icon">
                                    <i class="icon"></i>
                                </div>
                            </a>
                        </div>
                        <div class="caption">
                            <div class="stars">
                                <i class="icon"></i>
                                <i class="icon"></i>
                                <i class="icon"></i>
                                <i class="icon"></i>
                                <i class="icon off"></i>
                            </div>
                            <h4><a href="#" title="عنوان کتاب">فرزندان ایرانیم</a></h4>
                            <span class="price">رایگان</span>
                            <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                        </div>
                    </div>
                </div>
                <div class="thumbnail-container">
                    <div class="thumbnail simple">
                        <div class="thumb">
                            <a href="#" title="عنوان کتاب">
                                <img src="uploads/books/images/12439.jpg" alt="نام کتاب" >
                                <div class="thumbnail-overlay"></div>
                                <div class="thumbnail-overlay-icon">
                                    <i class="icon"></i>
                                </div>
                            </a>
                        </div>
                        <div class="caption">
                            <div class="stars">
                                <i class="icon"></i>
                                <i class="icon"></i>
                                <i class="icon"></i>
                                <i class="icon"></i>
                                <i class="icon off"></i>
                            </div>
                            <h4><a href="#" title="عنوان کتاب">من دیگر ما</a></h4>
                            <span class="price">رایگان</span>
                            <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                        </div>
                    </div>
                </div>
                <div class="thumbnail-container">
                    <div class="thumbnail simple">
                        <div class="thumb">
                            <a href="#" title="عنوان کتاب">
                                <img src="uploads/books/images/12957.jpg" alt="نام کتاب" >
                                <div class="thumbnail-overlay"></div>
                                <div class="thumbnail-overlay-icon">
                                    <i class="icon"></i>
                                </div>
                            </a>
                        </div>
                        <div class="caption">
                            <div class="stars">
                                <i class="icon"></i>
                                <i class="icon"></i>
                                <i class="icon"></i>
                                <i class="icon"></i>
                                <i class="icon off"></i>
                            </div>
                            <h4><a href="#" title="عنوان کتاب">کافکا در ساحل</a></h4>
                            <span class="price">رایگان</span>
                            <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                        </div>
                    </div>
                </div>
                <div class="thumbnail-container">
                    <div class="thumbnail simple">
                        <div class="thumb">
                            <a href="#" title="عنوان کتاب">
                                <img src="uploads/books/images/914.jpg" alt="نام کتاب" >
                                <div class="thumbnail-overlay"></div>
                                <div class="thumbnail-overlay-icon">
                                    <i class="icon"></i>
                                </div>
                            </a>
                        </div>
                        <div class="caption">
                            <div class="stars">
                                <i class="icon"></i>
                                <i class="icon"></i>
                                <i class="icon"></i>
                                <i class="icon"></i>
                                <i class="icon off"></i>
                            </div>
                            <h4><a href="#" title="عنوان کتاب">دختر شینا</a></h4>
                            <span class="price">4.000 تومان</span>
                            <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                        </div>
                    </div>
                </div>
                <div class="thumbnail-container">
                    <div class="thumbnail simple">
                        <div class="thumb">
                            <a href="#" title="عنوان کتاب">
                                <img src="uploads/books/images/12206.jpg" alt="نام کتاب" >
                                <div class="thumbnail-overlay"></div>
                                <div class="thumbnail-overlay-icon">
                                    <i class="icon"></i>
                                </div>
                            </a>
                        </div>
                        <div class="caption">
                            <div class="stars">
                                <i class="icon"></i>
                                <i class="icon"></i>
                                <i class="icon"></i>
                                <i class="icon"></i>
                                <i class="icon off"></i>
                            </div>
                            <h4><a href="#" title="عنوان کتاب">فتح خون</a></h4>
                            <span class="price">1.500 تومان</span>
                            <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                        </div>
                    </div>
                </div>
                <div class="thumbnail-container">
                    <div class="thumbnail simple">
                        <div class="thumb">
                            <a href="#" title="عنوان کتاب">
                                <img src="uploads/books/images/8420.jpg" alt="نام کتاب" >
                                <div class="thumbnail-overlay"></div>
                                <div class="thumbnail-overlay-icon">
                                    <i class="icon"></i>
                                </div>
                            </a>
                        </div>
                        <div class="caption">
                            <div class="stars">
                                <i class="icon"></i>
                                <i class="icon"></i>
                                <i class="icon"></i>
                                <i class="icon"></i>
                                <i class="icon off"></i>
                            </div>
                            <h4><a href="#" title="عنوان کتاب">مزرعه حیوانات</a></h4>
                            <span class="price">1.500 تومان</span>
                            <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                        </div>
                    </div>
                </div>
                <div class="thumbnail-container">
                    <div class="thumbnail simple">
                        <div class="thumb">
                            <a href="#" title="عنوان کتاب">
                                <img src="uploads/books/images/12210.jpg" alt="نام کتاب" >
                                <div class="thumbnail-overlay"></div>
                                <div class="thumbnail-overlay-icon">
                                    <i class="icon"></i>
                                </div>
                            </a>
                        </div>
                        <div class="caption">
                            <div class="stars">
                                <i class="icon"></i>
                                <i class="icon"></i>
                                <i class="icon"></i>
                                <i class="icon"></i>
                                <i class="icon off"></i>
                            </div>
                            <h4><a href="#" title="عنوان کتاب">مطلع مهر</a></h4>
                            <span class="price">1.500 تومان</span>
                            <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                        </div>
                    </div>
                </div>
                <div class="thumbnail-container">
                    <div class="thumbnail simple">
                        <div class="thumb">
                            <a href="#" title="عنوان کتاب">
                                <img src="uploads/books/images/6980.jpg" alt="نام کتاب" >
                                <div class="thumbnail-overlay"></div>
                                <div class="thumbnail-overlay-icon">
                                    <i class="icon"></i>
                                </div>
                            </a>
                        </div>
                        <div class="caption">
                            <div class="stars">
                                <i class="icon"></i>
                                <i class="icon"></i>
                                <i class="icon"></i>
                                <i class="icon"></i>
                                <i class="icon off"></i>
                            </div>
                            <h4><a href="#" title="عنوان کتاب">دیدن دختر صددرصد دلخواه در صبح زیبای ماه آوریل</a></h4>
                            <span class="price">1.500 تومان</span>
                            <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                        </div>
                    </div>
                </div>
                <div class="thumbnail-container">
                    <div class="thumbnail simple">
                        <div class="thumb">
                            <a href="#" title="عنوان کتاب">
                                <img src="uploads/books/images/6032.jpg" alt="نام کتاب" >
                                <div class="thumbnail-overlay"></div>
                                <div class="thumbnail-overlay-icon">
                                    <i class="icon"></i>
                                </div>
                            </a>
                        </div>
                        <div class="caption">
                            <div class="stars">
                                <i class="icon"></i>
                                <i class="icon"></i>
                                <i class="icon"></i>
                                <i class="icon"></i>
                                <i class="icon off"></i>
                            </div>
                            <h4><a href="#" title="عنوان کتاب">دنیای آشنا</a></h4>
                            <span class="price">1.500 تومان</span>
                            <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                        </div>
                    </div>
                </div>
                <div class="thumbnail-container">
                    <div class="thumbnail simple">
                        <div class="thumb">
                            <a href="#" title="عنوان کتاب">
                                <img src="uploads/books/images/12927.jpg" alt="نام کتاب" >
                                <div class="thumbnail-overlay"></div>
                                <div class="thumbnail-overlay-icon">
                                    <i class="icon"></i>
                                </div>
                            </a>
                        </div>
                        <div class="caption">
                            <div class="stars">
                                <i class="icon"></i>
                                <i class="icon"></i>
                                <i class="icon"></i>
                                <i class="icon"></i>
                                <i class="icon off"></i>
                            </div>
                            <h4><a href="#" title="عنوان کتاب">تخم مرغ ها</a></h4>
                            <span class="price">1.500 تومان</span>
                            <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                        </div>
                    </div>
                </div>
            </div>
            <a href="#" class="more"><i class="icon"></i>کتابهای بیشتر</a>
        </div>
    </div>
    <div class="bestselling paralax">
        <div class="container">
            <div class="content">
                <div class="head">
                    <h2>پرفروش ترین ها</h2>
                </div>
                <div class="is-carousel auto-width" data-items='{"1200":"5", "1024":"4", "992":"4", "768":"3", "650":"3", "480":"2", "0":"1"}' data-margin='{"768":"20", "0":"10"}' data-dots="1" data-nav="1">
                    <div class="thumbnail-container">
                        <div class="thumbnail small">
                            <div class="thumb">
                                <a href="#" title="عنوان کتاب"><img src="uploads/books/images/12927.jpg" alt="نام کتاب" ></a>
                            </div>
                            <div class="caption">
                                <div class="cat-icon" style="background: #cd3660;">
                                    <a href="#" title="عنوان دسته"><img src="uploads/categories/svg/3.svg"></a>
                                </div>
                                <div class="heading">
                                    <h4>تخم مرغ ها</h4>
                                </div>
                                <div class="stars">
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon off"></i>
                                </div>
                                <span class="price">1.500 تومان</span>
                            </div>
                        </div>
                    </div>
                    <div class="thumbnail-container">
                        <div class="thumbnail small">
                            <div class="thumb">
                                <a href="#" title="عنوان کتاب"><img src="uploads/books/images/12210.jpg" alt="نام کتاب" ></a>
                            </div>
                            <div class="caption">
                                <div class="cat-icon" style="background: #fbb11a;">
                                    <a href="#" title="عنوان دسته"><img src="uploads/categories/svg/2.svg"></a>
                                </div>
                                <div class="heading">
                                    <h4>مطلع مهر</h4>
                                </div>
                                <div class="stars">
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon off"></i>
                                </div>
                                <span class="price">1.500 تومان</span>
                            </div>
                        </div>
                    </div>
                    <div class="thumbnail-container">
                        <div class="thumbnail small">
                            <div class="thumb">
                                <a href="#" title="عنوان کتاب"><img src="uploads/books/images/8420.jpg" alt="نام کتاب" ></a>
                            </div>
                            <div class="caption">
                                <div class="cat-icon" style="background: #2e9fc7;">
                                    <a href="#" title="عنوان دسته"><img src="uploads/categories/svg/1.svg"></a>
                                </div>
                                <div class="heading">
                                    <h4>مزرعه حیوانات</h4>
                                </div>
                                <div class="stars">
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon off"></i>
                                </div>
                                <span class="price">1.500 تومان</span>
                            </div>
                        </div>
                    </div>
                    <div class="thumbnail-container">
                        <div class="thumbnail small">
                            <div class="thumb">
                                <a href="#" title="عنوان کتاب"><img src="uploads/books/images/914.jpg" alt="نام کتاب" ></a>
                            </div>
                            <div class="caption">
                                <div class="cat-icon" style="background: #28c295;">
                                    <a href="#" title="عنوان دسته"><img src="uploads/categories/svg/4.svg"></a>
                                </div>
                                <div class="heading">
                                    <h4>دختر شینا</h4>
                                </div>
                                <div class="stars">
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon off"></i>
                                </div>
                                <span class="price">1.500 تومان</span>
                            </div>
                        </div>
                    </div>
                    <div class="thumbnail-container">
                        <div class="thumbnail small">
                            <div class="thumb">
                                <a href="#" title="عنوان کتاب"><img src="uploads/books/images/6032.jpg" alt="نام کتاب" ></a>
                            </div>
                            <div class="caption">
                                <div class="cat-icon" style="background: #2a664c;">
                                    <a href="#" title="عنوان دسته"><img src="uploads/categories/svg/2.svg"></a>
                                </div>
                                <div class="heading">
                                    <h4>دنیای آشنا</h4>
                                </div>
                                <div class="stars">
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon"></i>
                                    <i class="icon off"></i>
                                </div>
                                <span class="price">1.500 تومان</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tabs">
        <div class="container">
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                <ul class="nav nav-pills nav-stacked row">
                    <li role="presentation" class="active"><a data-toggle="tab" href="#row-1">برترین ها</a></li>
                    <li role="presentation"><a data-toggle="tab" href="#row-2">محبوب ترین ها</a></li>
                    <li role="presentation"><a data-toggle="tab" href="#row-3">رایگان ها</a></li>
                </ul>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 tabs-container">
                <div class="tab-content">
                    <div id="row-1" class="tab-pane fade in active">
                        <div class="is-carousel auto-width" data-items='{"1200":"4", "1024":"3", "992":"3", "768":"2", "650":"3", "480":"2", "0":"1"}' data-margin='{"768":"20", "0":"10"}' data-dots="1" data-nav="0">
                            <div class="thumbnail-container">
                                <div class="thumbnail simple">
                                    <div class="thumb">
                                        <a href="#" title="عنوان کتاب">
                                            <img src="uploads/books/images/10561.jpg" alt="نام کتاب" >
                                            <div class="thumbnail-overlay"></div>
                                            <div class="thumbnail-overlay-icon">
                                                <i class="icon"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="caption">
                                        <div class="stars">
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon off"></i>
                                        </div>
                                        <h4><a href="#" title="عنوان کتاب">فرزندان ایرانیم</a></h4>
                                        <span class="price">رایگان</span>
                                        <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                                    </div>
                                </div>
                            </div>
                            <div class="thumbnail-container">
                                <div class="thumbnail simple">
                                    <div class="thumb">
                                        <a href="#" title="عنوان کتاب">
                                            <img src="uploads/books/images/12439.jpg" alt="نام کتاب" >
                                            <div class="thumbnail-overlay"></div>
                                            <div class="thumbnail-overlay-icon">
                                                <i class="icon"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="caption">
                                        <div class="stars">
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon off"></i>
                                        </div>
                                        <h4><a href="#" title="عنوان کتاب">من دیگر ما</a></h4>
                                        <span class="price">رایگان</span>
                                        <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                                    </div>
                                </div>
                            </div>
                            <div class="thumbnail-container">
                                <div class="thumbnail simple">
                                    <div class="thumb">
                                        <a href="#" title="عنوان کتاب">
                                            <img src="uploads/books/images/12957.jpg" alt="نام کتاب" >
                                            <div class="thumbnail-overlay"></div>
                                            <div class="thumbnail-overlay-icon">
                                                <i class="icon"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="caption">
                                        <div class="stars">
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon off"></i>
                                        </div>
                                        <h4><a href="#" title="عنوان کتاب">کافکا در ساحل</a></h4>
                                        <span class="price">رایگان</span>
                                        <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                                    </div>
                                </div>
                            </div>
                            <div class="thumbnail-container">
                                <div class="thumbnail simple">
                                    <div class="thumb">
                                        <a href="#" title="عنوان کتاب">
                                            <img src="uploads/books/images/914.jpg" alt="نام کتاب" >
                                            <div class="thumbnail-overlay"></div>
                                            <div class="thumbnail-overlay-icon">
                                                <i class="icon"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="caption">
                                        <div class="stars">
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon off"></i>
                                        </div>
                                        <h4><a href="#" title="عنوان کتاب">دختر شینا</a></h4>
                                        <span class="price">4.000 تومان</span>
                                        <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                                    </div>
                                </div>
                            </div>
                            <div class="thumbnail-container">
                                <div class="thumbnail simple">
                                    <div class="thumb">
                                        <a href="#" title="عنوان کتاب">
                                            <img src="uploads/books/images/12206.jpg" alt="نام کتاب" >
                                            <div class="thumbnail-overlay"></div>
                                            <div class="thumbnail-overlay-icon">
                                                <i class="icon"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="caption">
                                        <div class="stars">
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon off"></i>
                                        </div>
                                        <h4><a href="#" title="عنوان کتاب">فتح خون</a></h4>
                                        <span class="price">1.500 تومان</span>
                                        <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="row-2" class="tab-pane fade">
                        <div class="is-carousel auto-width" data-items='{"1200":"4", "1024":"3", "992":"3", "768":"2", "650":"3", "480":"2", "0":"1"}' data-margin='{"768":"20", "0":"10"}' data-dots="1" data-nav="0">
                            <div class="thumbnail-container">
                                <div class="thumbnail simple">
                                    <div class="thumb">
                                        <a href="#" title="عنوان کتاب">
                                            <img src="uploads/books/images/10561.jpg" alt="نام کتاب" >
                                            <div class="thumbnail-overlay"></div>
                                            <div class="thumbnail-overlay-icon">
                                                <i class="icon"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="caption">
                                        <div class="stars">
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon off"></i>
                                        </div>
                                        <h4><a href="#" title="عنوان کتاب">فرزندان ایرانیم</a></h4>
                                        <span class="price">رایگان</span>
                                        <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                                    </div>
                                </div>
                            </div>
                            <div class="thumbnail-container">
                                <div class="thumbnail simple">
                                    <div class="thumb">
                                        <a href="#" title="عنوان کتاب">
                                            <img src="uploads/books/images/12206.jpg" alt="نام کتاب" >
                                            <div class="thumbnail-overlay"></div>
                                            <div class="thumbnail-overlay-icon">
                                                <i class="icon"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="caption">
                                        <div class="stars">
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon off"></i>
                                        </div>
                                        <h4><a href="#" title="عنوان کتاب">فتح خون</a></h4>
                                        <span class="price">1.500 تومان</span>
                                        <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                                    </div>
                                </div>
                            </div>
                            <div class="thumbnail-container">
                                <div class="thumbnail simple">
                                    <div class="thumb">
                                        <a href="#" title="عنوان کتاب">
                                            <img src="uploads/books/images/12957.jpg" alt="نام کتاب" >
                                            <div class="thumbnail-overlay"></div>
                                            <div class="thumbnail-overlay-icon">
                                                <i class="icon"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="caption">
                                        <div class="stars">
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon off"></i>
                                        </div>
                                        <h4><a href="#" title="عنوان کتاب">کافکا در ساحل</a></h4>
                                        <span class="price">رایگان</span>
                                        <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                                    </div>
                                </div>
                            </div>
                            <div class="thumbnail-container">
                                <div class="thumbnail simple">
                                    <div class="thumb">
                                        <a href="#" title="عنوان کتاب">
                                            <img src="uploads/books/images/12439.jpg" alt="نام کتاب" >
                                            <div class="thumbnail-overlay"></div>
                                            <div class="thumbnail-overlay-icon">
                                                <i class="icon"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="caption">
                                        <div class="stars">
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon off"></i>
                                        </div>
                                        <h4><a href="#" title="عنوان کتاب">من دیگر ما</a></h4>
                                        <span class="price">رایگان</span>
                                        <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                                    </div>
                                </div>
                            </div>
                            <div class="thumbnail-container">
                                <div class="thumbnail simple">
                                    <div class="thumb">
                                        <a href="#" title="عنوان کتاب">
                                            <img src="uploads/books/images/914.jpg" alt="نام کتاب" >
                                            <div class="thumbnail-overlay"></div>
                                            <div class="thumbnail-overlay-icon">
                                                <i class="icon"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="caption">
                                        <div class="stars">
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon off"></i>
                                        </div>
                                        <h4><a href="#" title="عنوان کتاب">دختر شینا</a></h4>
                                        <span class="price">4.000 تومان</span>
                                        <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="row-3" class="tab-pane fade">
                        <div class="is-carousel auto-width" data-items='{"1200":"4", "1024":"3", "992":"3", "768":"2", "650":"3", "480":"2", "0":"1"}' data-margin='{"768":"20", "0":"10"}' data-dots="1" data-nav="0">
                            <div class="thumbnail-container">
                                <div class="thumbnail simple">
                                    <div class="thumb">
                                        <a href="#" title="عنوان کتاب">
                                            <img src="uploads/books/images/10561.jpg" alt="نام کتاب" >
                                            <div class="thumbnail-overlay"></div>
                                            <div class="thumbnail-overlay-icon">
                                                <i class="icon"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="caption">
                                        <div class="stars">
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon off"></i>
                                        </div>
                                        <h4><a href="#" title="عنوان کتاب">فرزندان ایرانیم</a></h4>
                                        <span class="price">رایگان</span>
                                        <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                                    </div>
                                </div>
                            </div>
                            <div class="thumbnail-container">
                                <div class="thumbnail simple">
                                    <div class="thumb">
                                        <a href="#" title="عنوان کتاب">
                                            <img src="uploads/books/images/12439.jpg" alt="نام کتاب" >
                                            <div class="thumbnail-overlay"></div>
                                            <div class="thumbnail-overlay-icon">
                                                <i class="icon"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="caption">
                                        <div class="stars">
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon off"></i>
                                        </div>
                                        <h4><a href="#" title="عنوان کتاب">من دیگر ما</a></h4>
                                        <span class="price">رایگان</span>
                                        <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                                    </div>
                                </div>
                            </div>
                            <div class="thumbnail-container">
                                <div class="thumbnail simple">
                                    <div class="thumb">
                                        <a href="#" title="عنوان کتاب">
                                            <img src="uploads/books/images/12957.jpg" alt="نام کتاب" >
                                            <div class="thumbnail-overlay"></div>
                                            <div class="thumbnail-overlay-icon">
                                                <i class="icon"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="caption">
                                        <div class="stars">
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon off"></i>
                                        </div>
                                        <h4><a href="#" title="عنوان کتاب">کافکا در ساحل</a></h4>
                                        <span class="price">رایگان</span>
                                        <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                                    </div>
                                </div>
                            </div>
                            <div class="thumbnail-container">
                                <div class="thumbnail simple">
                                    <div class="thumb">
                                        <a href="#" title="عنوان کتاب">
                                            <img src="uploads/books/images/914.jpg" alt="نام کتاب" >
                                            <div class="thumbnail-overlay"></div>
                                            <div class="thumbnail-overlay-icon">
                                                <i class="icon"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="caption">
                                        <div class="stars">
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon off"></i>
                                        </div>
                                        <h4><a href="#" title="عنوان کتاب">دختر شینا</a></h4>
                                        <span class="price">4.000 تومان</span>
                                        <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                                    </div>
                                </div>
                            </div>
                            <div class="thumbnail-container">
                                <div class="thumbnail simple">
                                    <div class="thumb">
                                        <a href="#" title="عنوان کتاب">
                                            <img src="uploads/books/images/12206.jpg" alt="نام کتاب" >
                                            <div class="thumbnail-overlay"></div>
                                            <div class="thumbnail-overlay-icon">
                                                <i class="icon"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="caption">
                                        <div class="stars">
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon"></i>
                                            <i class="icon off"></i>
                                        </div>
                                        <h4><a href="#" title="عنوان کتاب">فتح خون</a></h4>
                                        <span class="price">1.500 تومان</span>
                                        <a href="#" class="btn btn-add-to-library" role="button"><i class="icon"></i>افزودن به کتابخانه</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="news">
        <div class="container">
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                <div class="is-carousel" data-dots="0" data-nav="1" data-autoplay="1" data-autoplay-hover-pause="1" data-loop="1" data-items="1" data-mouseDrag="0">
                    <div class="news-item">
                        <div class="thumb"><img src="uploads/news/logo.svg"></div>
                        <div class="text">
                            <h2><a href="#">رونمایی از کتاب سیستان وکوروش بزرگ در زاهدان</a></h2>
                            <div class="info">
                                <span class="date">15 شهریور 1395 - 10:20</span>
                            </div>
                            <div class="summary">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد.</div>
                        </div>
                    </div>
                    <div class="news-item">
                        <div class="thumb"><img src="uploads/news/logo.svg"></div>
                        <div class="text">
                            <h2><a href="#">کتاب chemical thermodynamics منتشر شد</a></h2>
                            <div class="info">
                                <span class="date">15 شهریور 1395 - 10:20</span>
                            </div>
                            <div class="summary">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد.</div>
                        </div>
                    </div>
                    <div class="news-item">
                        <div class="thumb"><img src="uploads/news/logo.svg"></div>
                        <div class="text">
                            <h2><a href="#">کتاب chemical منتشر شد</a></h2>
                            <div class="info">
                                <span class="date">15 شهریور 1395 - 10:20</span>
                            </div>
                            <div class="summary">لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد.</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 controls">
                <i class="arrow-icon next"></i>
                <i class="arrow-icon prev"></i>
            </div>
        </div>
    </div>









<!--    <div class="book-box">-->
<!--        <div class="top-box">-->
<!--            <div class="title pull-right">-->
<!--                <h2>جدیدترین برنامه ها</h2>-->
<!--            </div>-->
<!--            <a class="pull-left btn btn-success more-book" href="--><?php //echo $this->createUrl('/books/programs');?><!--">بیشتر</a>-->
<!--        </div>-->
<!--        --><?php //$this->widget('zii.widgets.CListView', array(
//            'dataProvider'=>$newestProgramDataProvider,
//            'id'=>'newest-programs',
//            'itemView'=>'_book_item',
//            'template'=>'{items}',
//            'itemsCssClass'=>'book-carousel'
//        ));?>
<!--    </div>-->
<!--    <div class="book-box">-->
<!--        <div class="top-box">-->
<!--            <div class="title pull-right">-->
<!--                <h2>جدیدترین بازی ها</h2>-->
<!--            </div>-->
<!--            <a class="pull-left btn btn-success more-book" href="--><?php //echo $this->createUrl('/books/games');?><!--">بیشتر</a>-->
<!--        </div>-->
<!--        --><?php //$this->widget('zii.widgets.CListView', array(
//            'id'=>'newest-games',
//            'dataProvider'=>$newestGameDataProvider,
//            'itemView'=>'_book_item',
//            'template'=>'{items}',
//            'itemsCssClass'=>'book-carousel'
//        ));?>
<!--    </div>-->
<!---->
<?//
//if($advertise) {
//    ?>
<!--    <div class="banner-box">-->
<!--        <div class="banner-carousel">-->
<!--            <div class="banner-item">-->
<!--                <div class="fade-overly"></div>-->
<!--                --><?//
//                Yii::app()->clientScript->registerCss('fade-overly', "
//                    .content .banner-box .banner-carousel .banner-item{
//                        background-color: #{$advertise->fade_color};
//                    }
//                    .content .banner-box .banner-carousel .banner-item .fade-overly{
//                        background: -moz-linear-gradient(left,#{$advertise->fade_color} 0%, rgba(0,0,0,0) 100%);
//                        background: -webkit-linear-gradient(left, #{$advertise->fade_color} 0%, rgba(0,0,0,0) 100%);
//                        background: -o-linear-gradient(left, #{$advertise->fade_color} 0%, rgba(0,0,0,0) 100%);
//                        background: -ms-linear-gradient(left, #{$advertise->fade_color} 0%, rgba(0,0,0,0) 100%);
//                        background: linear-gradient(to right, #{$advertise->fade_color} 0%, rgba(0,0,0,0) 100%);
//                    }
//                ");
//                ?>
<!--                --><?//= $this->renderPartial('/books/_vertical_book_item', array('data' => $advertise->book)) ?>
<!--                --><?//
//                if($advertise->cover && file_exists(Yii::getPathOfAlias('webroot').'/uploads/advertisesCover/'.$advertise->cover)) {
//                    ?>
<!--                    <img src="--><?//= $this->createAbsoluteUrl('/uploads/advertisesCover/'.$advertise->cover) ?><!--">-->
<!--                    --><?//
//                }
//                ?>
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    --><?//
//}
//?>
<!--    <div class="book-box">-->
<!--        <div class="top-box">-->
<!--            <div class="title pull-right">-->
<!--                <h2>برترین ها</h2>-->
<!--            </div>-->
<!--            <button type="button" class="pull-left btn btn-success more-book" >-->
<!--                بیشتر-->
<!--            </button>-->
<!--        </div>-->
<!--        <div class="book-carousel">-->
<!--            <div class="book-item">-->
<!--                <div class="book-item-content">-->
<!--                    <div class="pic">-->
<!--                        <div>-->
<!--                            <img src="--><?//= Yii::app()->theme->baseUrl; ?><!--/images/login-back.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="detail">-->
<!--                        <div class="book-title">-->
<!--                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس-->
<!--                            <span class="paragraph-end"></span>-->
<!--                        </div>-->
<!--                        <div class="book-any">-->
<!--                                    <span class="book-price">-->
<!--                                        رایگان-->
<!--                                    </span>-->
<!--                                    <span class="book-rate">-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star-half-empty"></span>-->
<!--                                        <span class="icon-star-empty"></span>-->
<!--                                    </span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="book-item">-->
<!--                <div class="book-item-content">-->
<!--                    <div class="pic">-->
<!--                        <div>-->
<!--                            <img src="--><?//= Yii::app()->theme->baseUrl; ?><!--/images/login-back.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="detail">-->
<!--                        <div class="book-title">-->
<!--                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس-->
<!--                            <span class="paragraph-end"></span>-->
<!--                        </div>-->
<!--                        <div class="book-any">-->
<!--                                    <span class="book-price">-->
<!--                                        رایگان-->
<!--                                    </span>-->
<!--                                    <span class="book-rate">-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star-half-empty"></span>-->
<!--                                        <span class="icon-star-empty"></span>-->
<!--                                    </span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="book-item">-->
<!--                <div class="book-item-content">-->
<!--                    <div class="pic">-->
<!--                        <div>-->
<!--                            <img src="--><?//= Yii::app()->theme->baseUrl; ?><!--/images/login-back.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="detail">-->
<!--                        <div class="book-title">-->
<!--                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس-->
<!--                            <span class="paragraph-end"></span>-->
<!--                        </div>-->
<!--                        <div class="book-any">-->
<!--                                    <span class="book-price">-->
<!--                                        رایگان-->
<!--                                    </span>-->
<!--                                    <span class="book-rate">-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star-half-empty"></span>-->
<!--                                        <span class="icon-star-empty"></span>-->
<!--                                    </span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="book-item">-->
<!--                <div class="book-item-content">-->
<!--                    <div class="pic">-->
<!--                        <div>-->
<!--                            <img src="--><?//= Yii::app()->theme->baseUrl; ?><!--/images/login-back.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="detail">-->
<!--                        <div class="book-title">-->
<!--                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس-->
<!--                            <span class="paragraph-end"></span>-->
<!--                        </div>-->
<!--                        <div class="book-any">-->
<!--                                    <span class="book-price">-->
<!--                                        رایگان-->
<!--                                    </span>-->
<!--                                    <span class="book-rate">-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star-half-empty"></span>-->
<!--                                        <span class="icon-star-empty"></span>-->
<!--                                    </span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="book-item">-->
<!--                <div class="book-item-content">-->
<!--                    <div class="pic">-->
<!--                        <div>-->
<!--                            <img src="--><?//= Yii::app()->theme->baseUrl; ?><!--/images/login-back.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="detail">-->
<!--                        <div class="book-title">-->
<!--                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس-->
<!--                            <span class="paragraph-end"></span>-->
<!--                        </div>-->
<!--                        <div class="book-any">-->
<!--                                    <span class="book-price">-->
<!--                                        رایگان-->
<!--                                    </span>-->
<!--                                    <span class="book-rate">-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star-half-empty"></span>-->
<!--                                        <span class="icon-star-empty"></span>-->
<!--                                    </span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="book-box">-->
<!--        <div class="top-box">-->
<!--            <div class="title pull-right">-->
<!--                <h2>پر فروش های هفته</h2>-->
<!--            </div>-->
<!--            <button type="button" class="pull-left btn btn-success more-book" >-->
<!--                بیشتر-->
<!--            </button>-->
<!--        </div>-->
<!--        <div class="book-carousel">-->
<!--            <div class="book-item">-->
<!--                <div class="book-item-content">-->
<!--                    <div class="pic">-->
<!--                        <div>-->
<!--                            <img src="--><?//= Yii::app()->theme->baseUrl; ?><!--/images/login-back.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="detail">-->
<!--                        <div class="book-title">-->
<!--                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس-->
<!--                            <span class="paragraph-end"></span>-->
<!--                        </div>-->
<!--                        <div class="book-any">-->
<!--                                    <span class="book-price">-->
<!--                                        رایگان-->
<!--                                    </span>-->
<!--                                    <span class="book-rate">-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star-half-empty"></span>-->
<!--                                        <span class="icon-star-empty"></span>-->
<!--                                    </span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="book-item">-->
<!--                <div class="book-item-content">-->
<!--                    <div class="pic">-->
<!--                        <div>-->
<!--                            <img src="--><?//= Yii::app()->theme->baseUrl; ?><!--/images/login-back.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="detail">-->
<!--                        <div class="book-title">-->
<!--                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس-->
<!--                            <span class="paragraph-end"></span>-->
<!--                        </div>-->
<!--                        <div class="book-any">-->
<!--                                    <span class="book-price">-->
<!--                                        رایگان-->
<!--                                    </span>-->
<!--                                    <span class="book-rate">-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star-half-empty"></span>-->
<!--                                        <span class="icon-star-empty"></span>-->
<!--                                    </span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="book-item">-->
<!--                <div class="book-item-content">-->
<!--                    <div class="pic">-->
<!--                        <div>-->
<!--                            <img src="--><?//= Yii::app()->theme->baseUrl; ?><!--/images/login-back.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="detail">-->
<!--                        <div class="book-title">-->
<!--                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس-->
<!--                            <span class="paragraph-end"></span>-->
<!--                        </div>-->
<!--                        <div class="book-any">-->
<!--                                    <span class="book-price">-->
<!--                                        رایگان-->
<!--                                    </span>-->
<!--                                    <span class="book-rate">-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star-half-empty"></span>-->
<!--                                        <span class="icon-star-empty"></span>-->
<!--                                    </span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="book-item">-->
<!--                <div class="book-item-content">-->
<!--                    <div class="pic">-->
<!--                        <div>-->
<!--                            <img src="--><?//= Yii::app()->theme->baseUrl; ?><!--/images/login-back.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="detail">-->
<!--                        <div class="book-title">-->
<!--                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس-->
<!--                            <span class="paragraph-end"></span>-->
<!--                        </div>-->
<!--                        <div class="book-any">-->
<!--                                    <span class="book-price">-->
<!--                                        رایگان-->
<!--                                    </span>-->
<!--                                    <span class="book-rate">-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star-half-empty"></span>-->
<!--                                        <span class="icon-star-empty"></span>-->
<!--                                    </span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="book-item">-->
<!--                <div class="book-item-content">-->
<!--                    <div class="pic">-->
<!--                        <div>-->
<!--                            <img src="--><?//= Yii::app()->theme->baseUrl; ?><!--/images/login-back.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="detail">-->
<!--                        <div class="book-title">-->
<!--                            تی وی پلاستی وی پلاستی وی پلاستی وی پلاس-->
<!--                            <span class="paragraph-end"></span>-->
<!--                        </div>-->
<!--                        <div class="book-any">-->
<!--                                    <span class="book-price">-->
<!--                                        رایگان-->
<!--                                    </span>-->
<!--                                    <span class="book-rate">-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star"></span>-->
<!--                                        <span class="icon-star-half-empty"></span>-->
<!--                                        <span class="icon-star-empty"></span>-->
<!--                                    </span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="book-box">-->
<!--        <div class="top-box">-->
<!--            <div class="title pull-right">-->
<!--                <h2>تازه های آموزشی</h2>-->
<!--            </div>-->
<!--            <a class="pull-left btn btn-success more-book" href="--><?php //echo $this->createUrl('/books/educations');?><!--">بیشتر</a>-->
<!--        </div>-->
<!--        --><?php //$this->widget('zii.widgets.CListView', array(
//            'id'=>'newest-educations',
//            'dataProvider'=>$newestEducationDataProvider,
//            'itemView'=>'_book_item',
//            'template'=>'{items}',
//            'itemsCssClass'=>'book-carousel'
//        ));?>
<!--    </div>-->
<!--    <div class="book-box suggested-list">-->
<!--        <div class="top-box">-->
<!--            <div class="title pull-right">-->
<!--                <h2>پیشنهاد ما به شما</h2>-->
<!--            </div>-->
<!--        </div>-->
<!--        --><?php //$this->widget('zii.widgets.CListView', array(
//            'id'=>'newest-educations',
//            'dataProvider'=>$suggestedDataProvider,
//            'itemView'=>'_book_item',
//            'template'=>'{items}',
//            'itemsCssClass'=>'book-carousel'
//        ));?>
<!--    </div>-->
<?//
//Yii::app()->clientScript->registerScript('carousels','
//    var owl = $(".book-carousel");
//    owl.owlCarousel({
//        responsive:{
//            0:{
//                items : 1,
//            },
//            410:{
//                items : 2,
//            },
//            580:{
//                items : 3
//            },
//            800:{
//                items : 4
//            },
//            1130:{
//                items : 5
//            },
//            1370:{
//                items : 6
//            }
//        },
//        lazyLoad :true,
//        margin :0,
//        rtl:true,
//        nav:true,
//        navText : ["","<span class=\'icon-chevron-left\'></span>"]
//    });
//
//'
//);