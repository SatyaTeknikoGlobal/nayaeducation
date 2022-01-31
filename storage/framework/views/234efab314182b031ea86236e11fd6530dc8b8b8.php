<?php 
$ADMIN_ROUTE_NAME = CustomHelper::getAdminRouteName();

$url = url()->current();
// echo $url;

$baseurl = url('/');

?>
<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a  class="nav-link dropdown-toggle " href="<?php echo e(url('/admin')); ?>" id="topnav-dashboard" role="button" ><i class="fa fa-dashboard"></i> Dashboards 
                            
                        </a>
                                </li>



                                <?php if(CustomHelper::isAllowedModule('categories') && CustomHelper::isAllowedSection('categories' , 'list') || CustomHelper::isAllowedModule('courses') && CustomHelper::isAllowedSection('courses' , 'list') || CustomHelper::isAllowedModule('subject') && CustomHelper::isAllowedSection('subject' , 'list') || CustomHelper::isAllowedModule('banners') && CustomHelper::isAllowedSection('banners' , 'list')){?>





                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-th"></i> Master <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">
                                   <?php if(CustomHelper::isAllowedModule('categories')): ?>
                                   <?php if(CustomHelper::isAllowedSection('categories' , 'list')): ?>
                                   <a href="<?php echo e(route($ADMIN_ROUTE_NAME.'.categories.index')); ?>" class="dropdown-item">Categories</a>
                                   <?php endif; ?>

                                   <?php endif; ?>
                                   <?php if(CustomHelper::isAllowedModule('courses')): ?>
                                   <?php if(CustomHelper::isAllowedSection('courses' , 'list')): ?>
                                   <a href="<?php echo e(route($ADMIN_ROUTE_NAME.'.courses.index')); ?>" class="dropdown-item">Courses</a>

                                   <?php endif; ?>
                                   <?php endif; ?>
                                   <?php if(CustomHelper::isAllowedModule('subject')): ?>
                                   
                                   <?php if(CustomHelper::isAllowedSection('subject' , 'list')): ?>
                                   <a href="<?php echo e(route($ADMIN_ROUTE_NAME.'.subject.index')); ?>" class="dropdown-item">Subjects</a>
                                   <?php endif; ?>
                                   <?php endif; ?>

                                   <?php if(CustomHelper::isAllowedModule('banners')): ?>
                                   <?php if(CustomHelper::isAllowedSection('banners' , 'list')): ?>
                                   <a href="<?php echo e(route($ADMIN_ROUTE_NAME.'.banners.index')); ?>" class="dropdown-item">Banners</a>
                                   <?php endif; ?>
                                   <?php endif; ?>


                               </div>
                           </li>
                       <?php }?>

                          <?php if(CustomHelper::isAllowedModule('faculties') && CustomHelper::isAllowedSection('faculties' , 'list') || CustomHelper::isAllowedModule('user') && CustomHelper::isAllowedSection('user' , 'list')){?>

                           <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user-circle"></i> Users <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-apps">
                           <?php if(CustomHelper::isAllowedModule('faculties')): ?>
                           <?php if(CustomHelper::isAllowedSection('faculties' , 'list')): ?>
                           <a href="<?php echo e(route($ADMIN_ROUTE_NAME.'.faculties.index')); ?>" class="dropdown-item">Faculty</a>
                           <?php endif; ?>
                           <?php endif; ?>

                           <?php if(CustomHelper::isAllowedModule('user')): ?>
                           <?php if(CustomHelper::isAllowedSection('user' , 'list')): ?>

                           <a href="<?php echo e(route($ADMIN_ROUTE_NAME.'.user.index')); ?>" class="dropdown-item">Users</a>
                           <?php endif; ?>
                           <?php endif; ?>


                       </div>
                   </li>
               <?php }?>

                   <?php if(CustomHelper::isAllowedModule('live_class')): ?>
                           <?php if(CustomHelper::isAllowedSection('live_class' , 'list')): ?>

                   <li class="nav-item dropdown">
                    <a href="<?php echo e(route($ADMIN_ROUTE_NAME.'.live_class.index')); ?>" id="topnav-components" role="button" class="nav-link dropdown-toggle "><i class="fa fa-television"></i> Live Classes</a>
                </li>
                <?php endif; ?>
                <?php endif; ?>



                
                <?php if(CustomHelper::isAllowedModule('subscriptions')): ?>
                           <?php if(CustomHelper::isAllowedSection('live_class' , 'list')): ?>

                <li class="nav-item dropdown">
                    <a href="<?php echo e(route($ADMIN_ROUTE_NAME.'.subscriptions.index')); ?>" id="topnav-components" role="button" class="nav-link dropdown-toggle "><i class="fa fa-rocket"></i>  Subscription History</a>

                </li>
                <?php endif; ?>
                <?php endif; ?>



                <?php if(CustomHelper::isAllowedModule('chats')): ?>
                           <?php if(CustomHelper::isAllowedSection('live_class' , 'list')): ?>

                <li class="nav-item dropdown">
                    <a href="<?php echo e(route($ADMIN_ROUTE_NAME.'.chats.index')); ?>" id="topnav-form" role="button" class="nav-link dropdown-toggle "><i class="fa fa-comments"></i> Chats</a>

                </li>
                <?php endif; ?>
                <?php endif; ?>




                <?php if(CustomHelper::isAllowedModule('contacts')): ?>
                           <?php if(CustomHelper::isAllowedSection('contacts' , 'list')): ?>

                <li class="nav-item dropdown">
                    <a href="<?php echo e(route($ADMIN_ROUTE_NAME.'.contacts.index')); ?>" id="topnav-form" role="button" class="nav-link dropdown-toggle "><i class="fa fa-address-book"></i> Contact Us</a>

                </li>
                <?php endif; ?>
                <?php endif; ?>


                <?php if(CustomHelper::isAllowedModule('notifications')): ?>
                           <?php if(CustomHelper::isAllowedSection('notifications' , 'list')): ?>

                <li class="nav-item dropdown">
                    <a href="<?php echo e(route($ADMIN_ROUTE_NAME.'.notifications.index')); ?>" id="topnav-form" role="button" class="nav-link dropdown-toggle "><i class="fa fa-bell"></i> Notifications</a>

                </li>
                <?php endif; ?>
                <?php endif; ?>


                <?php if(CustomHelper::isAllowedModule('faqs')): ?>
                           <?php if(CustomHelper::isAllowedSection('faqs' , 'list')): ?>

                <li class="nav-item dropdown">
                    <a href="<?php echo e(route($ADMIN_ROUTE_NAME.'.faqs.index')); ?>" id="topnav-form" role="button" class="nav-link dropdown-toggle "><i class="fa fa-question-circle" aria-hidden="true"></i> FAQs</a>

                </li>
                <?php endif; ?>
                <?php endif; ?>



                <?php if(CustomHelper::isAllowedModule('dgl_form')): ?>
                           <?php if(CustomHelper::isAllowedSection('dgl_form' , 'list')): ?>

                <li class="nav-item dropdown">
                    <a href="<?php echo e(route($ADMIN_ROUTE_NAME.'.dgl_form.index')); ?>" id="topnav-form" role="button" class="nav-link dropdown-toggle "><i class="fa fa-wpforms" aria-hidden="true"></i> DGL Form</a>

                </li>
                <?php endif; ?>
                <?php endif; ?>






                                <?php /*
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-ui" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe-briefcase me-1"></i> UI Elements <div class="arrow-down"></div>
                                    </a>

                                    <div class="dropdown-menu mega-dropdown-menu dropdown-mega-menu-xl" aria-labelledby="topnav-ui">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div>
                                                    <a href="ui-buttons.html" class="dropdown-item">Buttons</a>
                                                    <a href="ui-cards.html" class="dropdown-item">Cards</a>
                                                    <a href="ui-avatars.html" class="dropdown-item">Avatars</a>
                                                    <a href="ui-portlets.html" class="dropdown-item">Portlets</a>
                                                    <a href="ui-tabs-accordions.html" class="dropdown-item">Tabs & Accordions</a>
                                                    <a href="ui-modals.html" class="dropdown-item">Modals</a>
                                                    <a href="ui-progress.html" class="dropdown-item">Progress</a>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div>
                                                    <a href="ui-notifications.html" class="dropdown-item">Notifications</a>
                                                    <a href="ui-placeholders.html" class="dropdown-item">Placeholders</a>
                                                    <a href="ui-offcanvas.html" class="dropdown-item">Offcanvas</a>
                                                    <a href="ui-spinners.html" class="dropdown-item">Spinners</a>
                                                    <a href="ui-images.html" class="dropdown-item">Images</a>
                                                    <a href="ui-carousel.html" class="dropdown-item">Carousel</a>
                                                    <a href="ui-list-group.html" class="dropdown-item">List Group</a>
                                        
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div>
                                                    <a href="ui-video.html" class="dropdown-item">Embed Video</a>
                                                    <a href="ui-dropdowns.html" class="dropdown-item">Dropdowns</a>
                                                    <a href="ui-ribbons.html" class="dropdown-item">Ribbons</a>
                                                    <a href="ui-tooltips-popovers.html" class="dropdown-item">Tooltips & Popovers</a>
                                                    <a href="ui-general.html" class="dropdown-item">General UI</a>
                                                    <a href="ui-typography.html" class="dropdown-item">Typography</a>
                                                    <a href="ui-grid.html" class="dropdown-item">Grid</a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </li>

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-components" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe-layers me-1"></i> Components <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-components">
                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-extendedui"
                                                role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fe-pocket me-1"></i> Extended UI <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-extendedui">
                                                <a href="extended-nestable.html" class="dropdown-item">Nestable List</a>
                                                <a href="extended-range-slider.html" class="dropdown-item">Range Slider</a>
                                                <a href="extended-dragula.html" class="dropdown-item">Dragula</a>
                                                <a href="extended-animation.html" class="dropdown-item">Animation</a>
                                                <a href="extended-sweet-alert.html" class="dropdown-item">Sweet Alert</a>
                                                <a href="extended-tour.html" class="dropdown-item">Tour Page</a>
                                                <a href="extended-scrollspy.html" class="dropdown-item">Scrollspy</a>
                                                <a href="extended-loading-buttons.html" class="dropdown-item">Loading Buttons</a>
                                            </div>
                                        </div>
                                        <a href="widgets.html" class="dropdown-item"><i class="fe-gift me-1"></i> Widgets</a>
                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                                role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fe-bookmark me-1"></i> Forms <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-form">
                                                <a href="forms-elements.html" class="dropdown-item">General Elements</a>
                                                <a href="forms-advanced.html" class="dropdown-item">Advanced</a>
                                                <a href="forms-validation.html" class="dropdown-item">Validation</a>
                                                <a href="forms-pickers.html" class="dropdown-item">Pickers</a>
                                                <a href="forms-wizard.html" class="dropdown-item">Wizard</a>
                                                <a href="forms-masks.html" class="dropdown-item">Masks</a>
                                                <a href="forms-quilljs.html" class="dropdown-item">Quilljs Editor</a>
                                                <a href="forms-file-uploads.html" class="dropdown-item">File Uploads</a>
                                                <a href="forms-x-editable.html" class="dropdown-item">X Editable</a>
                                                <a href="forms-image-crop.html" class="dropdown-item">Image Crop</a>
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-charts"
                                                role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fe-bar-chart-2 me-1"></i> Charts <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-charts">
                                                <a href="charts-apex.html" class="dropdown-item">Apex Charts</a>
                                                <a href="charts-flot.html" class="dropdown-item">Flot Charts</a>
                                                <a href="charts-morris.html" class="dropdown-item">Morris Charts</a>
                                                <a href="charts-chartjs.html" class="dropdown-item">Chartjs Charts</a>
                                                <a href="charts-peity.html" class="dropdown-item">Peity Charts</a>
                                                <a href="charts-chartist.html" class="dropdown-item">Chartist Charts</a>
                                                <a href="charts-c3.html" class="dropdown-item">C3 Charts</a>
                                                <a href="charts-sparklines.html" class="dropdown-item">Sparklines Charts</a>
                                                <a href="charts-knob.html" class="dropdown-item">Jquery Knob Charts</a>
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-table"
                                                role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fe-grid me-1"></i> Tables <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-table">
                                                <a href="tables-basic.html" class="dropdown-item">Basic Tables</a>
                                                <a href="tables-datatables.html" class="dropdown-item">Data Tables</a>
                                                <a href="tables-editable.html" class="dropdown-item">Editable Tables</a>
                                                <a href="tables-responsive.html" class="dropdown-item">Responsive Tables</a>
                                                <a href="tables-footables.html" class="dropdown-item">FooTable</a>
                                                <a href="tables-bootstrap.html" class="dropdown-item">Bootstrap Tables</a>
                                                <a href="tables-tablesaw.html" class="dropdown-item">Tablesaw Tables</a>
                                                <a href="tables-jsgrid.html" class="dropdown-item">JsGrid Tables</a>
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-icons"
                                                role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fe-cpu me-1"></i> Icons <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-icons">
                                                <a href="icons-two-tone.html" class="dropdown-item">Two Tone Icons</a>
                                                <a href="icons-feather.html" class="dropdown-item">Feather Icons</a>
                                                <a href="icons-mdi.html" class="dropdown-item">Material Design Icons</a>
                                                <a href="icons-dripicons.html" class="dropdown-item">Dripicons</a>
                                                <a href="icons-font-awesome.html" class="dropdown-item">Font Awesome 5</a>
                                                <a href="icons-themify.html" class="dropdown-item">Themify</a>
                                                <a href="icons-simple-line.html" class="dropdown-item">Simple Line</a>
                                                <a href="icons-weather.html" class="dropdown-item">Weather</a>
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-map"
                                                role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fe-map me-1"></i> Maps <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-map">
                                                <a href="maps-google.html" class="dropdown-item">Google Maps</a>
                                                <a href="maps-vector.html" class="dropdown-item">Vector Maps</a>
                                                <a href="maps-mapael.html" class="dropdown-item">Mapael Maps</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe-package me-1"></i> Pages <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-pages">
                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-auth"
                                                role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Auth Style 1 <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-auth">
                                                <a href="auth-login.html" class="dropdown-item">Log In</a>
                                                <a href="auth-register.html" class="dropdown-item">Register</a>
                                                <a href="auth-signin-signup.html" class="dropdown-item">Signin - Signup</a>
                                                <a href="auth-recoverpw.html" class="dropdown-item">Recover Password</a>
                                                <a href="auth-lock-screen.html" class="dropdown-item">Lock Screen</a>
                                                <a href="auth-logout.html" class="dropdown-item">Logout</a>
                                                <a href="auth-confirm-mail.html" class="dropdown-item">Confirm Mail</a>
                                            </div>
                                        </div>

                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-auth2"
                                                role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Auth Style 2 <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-auth2">
                                                <a href="auth-login-2.html" class="dropdown-item">Log In 2</a>
                                                <a href="auth-register-2.html" class="dropdown-item">Register 2</a>
                                                <a href="auth-signin-signup-2.html" class="dropdown-item">Signin - Signup 2</a>
                                                <a href="auth-recoverpw-2.html" class="dropdown-item">Recover Password 2</a>
                                                <a href="auth-lock-screen-2.html" class="dropdown-item">Lock Screen 2</a>
                                                <a href="auth-logout-2.html" class="dropdown-item">Logout 2</a>
                                                <a href="auth-confirm-mail-2.html" class="dropdown-item">Confirm Mail 2</a>
                                            </div>
                                        </div>

                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-error"
                                                role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Errors <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-error">
                                                <a href="pages-404.html" class="dropdown-item">Error 404</a>
                                                <a href="pages-404-two.html" class="dropdown-item">Error 404 Two</a>
                                                <a href="pages-404-alt.html" class="dropdown-item">Error 404-alt</a>
                                                <a href="pages-500.html" class="dropdown-item">Error 500</a>
                                                <a href="pages-500-two.html" class="dropdown-item">Error 500 Two</a>
                                            </div>
                                        </div>

                                        <div class="dropdown">
                                            <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-utility"
                                                role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Utility <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-utility">
                                                <a href="pages-starter.html" class="dropdown-item">Starter</a>
                                                <a href="pages-timeline.html" class="dropdown-item">Timeline</a>
                                                <a href="pages-sitemap.html" class="dropdown-item">Sitemap</a>
                                                <a href="pages-invoice.html" class="dropdown-item">Invoice</a>
                                                <a href="pages-faqs.html" class="dropdown-item">FAQs</a>
                                                <a href="pages-search-results.html" class="dropdown-item">Search Results</a>
                                                <a href="pages-pricing.html" class="dropdown-item">Pricing</a>
                                                <a href="pages-maintenance.html" class="dropdown-item">Maintenance</a>
                                                <a href="pages-coming-soon.html" class="dropdown-item">Coming Soon</a>
                                                <a href="pages-gallery.html" class="dropdown-item">Gallery</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe-sidebar me-1"></i> Layouts <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-layout">
                                        <a href="layouts-vertical.html" class="dropdown-item">Vertical</a>
                                        <a href="layouts-detached.html" class="dropdown-item">Detached</a>
                                        <a href="layouts-two-column.html" class="dropdown-item">Two Column Menu</a>
                                        <a href="layouts-two-tone-icons.html" class="dropdown-item">Two Tones Icons</a>
                                        <a href="layouts-preloader.html" class="dropdown-item">Preloader</a>
                                    </div>
                                </li>

                        */?>
                    </ul> <!-- end navbar-->
                </div> <!-- end .collapsed-->
            </nav>
        </div> <!-- end container-fluid -->
    </div> <!-- end topnav-->
<?php /**PATH /home/appmantr/public_html/nayaeducation/resources/views/admin/common/sidebar.blade.php ENDPATH**/ ?>