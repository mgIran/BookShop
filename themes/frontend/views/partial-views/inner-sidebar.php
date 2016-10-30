<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 sidebar-col">
    <div class="boxed">
        <div class="heading">
            <h4>دسته بندی ها</h4>
        </div>
        <ul class="categories">
            <?php
            foreach($this->categories as $category):
                ?>
                <li class="<?= (isset($activeId) && $category->id===$activeId)?'active':'' ?>"><a href="<?= $this->createUrl('/category/'.$category->id.'/'.urlencode($category->title)) ?>"><?= $category->title ?>
                        <small>(<?= $category->getBooksCount() ?>)</small></a></li>
                <?php
            endforeach;
            ?>
        </ul>
    </div>
    <div class="boxed">
        <div class="heading">
            <h4>محبوب ترین ها</h4>
        </div>
        <div class="sidebar-book-list">
            <div class="thumbnail-container">
                <div class="thumbnail smallest">
                    <div class="thumb">
                        <a href="#" title="عنوان کتاب">
                            <img src="../../uploads/books/icons/JNSLy1477560156.jpg" alt="نام کتاب" >
                            <div class="thumbnail-overlay"></div>
                            <div class="thumbnail-overlay-icon">
                                <i class="icon"></i>
                            </div>
                        </a>
                    </div>
                    <div class="caption">
                        <h4><a href="#" title="عنوان کتاب">فرزندان ایرانیم</a></h4>
                        <div class="stars">
                            <i class="icon"></i>
                            <i class="icon"></i>
                            <i class="icon"></i>
                            <i class="icon"></i>
                            <i class="icon off"></i>
                        </div>
                        <span class="price">رایگان</span>
                    </div>
                </div>
            </div>
            <div class="thumbnail-container">
                <div class="thumbnail smallest">
                    <div class="thumb">
                        <a href="#" title="عنوان کتاب">
                            <img src="../../uploads/books/icons/gvXUa1477582174.jpg" alt="نام کتاب" >
                            <div class="thumbnail-overlay"></div>
                            <div class="thumbnail-overlay-icon">
                                <i class="icon"></i>
                            </div>
                        </a>
                    </div>
                    <div class="caption">
                        <h4><a href="#" title="عنوان کتاب">من دیگر ما</a></h4>
                        <div class="stars">
                            <i class="icon"></i>
                            <i class="icon"></i>
                            <i class="icon"></i>
                            <i class="icon"></i>
                            <i class="icon off"></i>
                        </div>
                        <span class="price">رایگان</span>
                    </div>
                </div>
            </div>
            <div class="thumbnail-container">
                <div class="thumbnail smallest">
                    <div class="thumb">
                        <a href="#" title="عنوان کتاب">
                            <img src="../../uploads/books/icons/wD8Oc1477588685.jpg" alt="نام کتاب" >
                            <div class="thumbnail-overlay"></div>
                            <div class="thumbnail-overlay-icon">
                                <i class="icon"></i>
                            </div>
                        </a>
                    </div>
                    <div class="caption">
                        <h4><a href="#" title="عنوان کتاب">کافکا در ساحل</a></h4>
                        <div class="stars">
                            <i class="icon"></i>
                            <i class="icon"></i>
                            <i class="icon"></i>
                            <i class="icon"></i>
                            <i class="icon off"></i>
                        </div>
                        <span class="price">رایگان</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="boxed">
        <div class="heading">
            <h4>محبوب ترین ها</h4>
        </div>
        <div class="sidebar-book-list">
            <div class="thumbnail-container">
                <div class="thumbnail smallest">
                    <div class="thumb">
                        <a href="#" title="عنوان کتاب">
                            <img src="../../uploads/books/icons/gvXUa1477582174.jpg" alt="نام کتاب" >
                            <div class="thumbnail-overlay"></div>
                            <div class="thumbnail-overlay-icon">
                                <i class="icon"></i>
                            </div>
                        </a>
                    </div>
                    <div class="caption">
                        <h4><a href="#" title="عنوان کتاب">من دیگر ما</a></h4>
                        <div class="stars">
                            <i class="icon"></i>
                            <i class="icon"></i>
                            <i class="icon"></i>
                            <i class="icon"></i>
                            <i class="icon off"></i>
                        </div>
                        <span class="price">رایگان</span>
                    </div>
                </div>
            </div>
            <div class="thumbnail-container">
                <div class="thumbnail smallest">
                    <div class="thumb">
                        <a href="#" title="عنوان کتاب">
                            <img src="../../uploads/books/icons/wD8Oc1477588685.jpg" alt="نام کتاب" >
                            <div class="thumbnail-overlay"></div>
                            <div class="thumbnail-overlay-icon">
                                <i class="icon"></i>
                            </div>
                        </a>
                    </div>
                    <div class="caption">
                        <h4><a href="#" title="عنوان کتاب">کافکا در ساحل</a></h4>
                        <div class="stars">
                            <i class="icon"></i>
                            <i class="icon"></i>
                            <i class="icon"></i>
                            <i class="icon"></i>
                            <i class="icon off"></i>
                        </div>
                        <span class="price">رایگان</span>
                    </div>
                </div>
            </div>
            <div class="thumbnail-container">
                <div class="thumbnail smallest">
                    <div class="thumb">
                        <a href="#" title="عنوان کتاب">
                            <img src="../../uploads/books/icons/JNSLy1477560156.jpg" alt="نام کتاب" >
                            <div class="thumbnail-overlay"></div>
                            <div class="thumbnail-overlay-icon">
                                <i class="icon"></i>
                            </div>
                        </a>
                    </div>
                    <div class="caption">
                        <h4><a href="#" title="عنوان کتاب">دختر شینا</a></h4>
                        <div class="stars">
                            <i class="icon"></i>
                            <i class="icon"></i>
                            <i class="icon"></i>
                            <i class="icon"></i>
                            <i class="icon off"></i>
                        </div>
                        <span class="price">4.000 تومان</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>