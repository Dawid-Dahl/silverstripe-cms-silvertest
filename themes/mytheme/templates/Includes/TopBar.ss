	
    <!-- BEGIN HEADER -->
    <header id="header">
        <div id="top-bar">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">							
                        <ul id="top-buttons">
                            <li><a href="#"><i class="fa fa-sign-in"></i> Login</a></li>
                            <li><a href="#"><i class="fa fa-pencil-square-o"></i> Register</a></li>
                            <li class="divider"></li>
                            <li>
                                <div class="language-switcher">
                                    <span><i class="fa fa-globe"></i> English</span>
                                    <ul>
                                        <li><a href="#">Deutsch</a></li>
                                        <li><a href="#">Espa&ntilde;ol</a></li>
                                        <li><a href="#">Fran&ccedil;ais</a></li>
                                        <li><a href="#">Portugu&ecirc;s</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="nav-section">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <a href="$AbsoluteBaseURL" class="nav-logo"><img src="images/logo.png" alt="One Ring Rentals" /></a>
                                                    
                        <!-- BEGIN MAIN MENU -->
                        <nav class="navbar">
                            <button id="nav-mobile-btn"><i class="fa fa-bars"></i></button>
                            
                            <ul class="nav navbar-nav">
                                <% loop $Menu(1) %>
                                    <li><a class="LinkingMode" href="$Link" title="Go to the $Title page">$MenuTitle</a></li>
                                <% end_loop %>
                            </ul>
                        
                        </nav>
                        <!-- END MAIN MENU -->
                        
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- END HEADER -->