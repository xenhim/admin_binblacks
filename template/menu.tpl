<div class="navbar-content">
				<div class="main-navigation navbar-collapse collapse">
					<div class="navigation-toggler">
						<i class="clip-chevron-left"></i>
						<i class="clip-chevron-right"></i>
					</div>
					<ul class="main-navigation-menu">
                        <li class="active open">
							<a href="#" onclick="showpage('news.php');"><i class="clip-globe"></i>
								<span class="title">News</span>
								<span class="selected"></span>
							</a>
						</li>
                        {% if config['salecc'] == '1' %}
                        <li>
							<a href="#" onclick="showpage('card.php');"><i class="fa fa-credit-card"></i>
								<span class="title">Credit Cards</span>
								<span class="selected"></span>
							</a>
						</li>
                        {% endif %}
                        {% if config['saledump'] == '1' %}
                        <li>
							<a href="#" onclick="showpage('dumps.php');"><i class="clip-phone-3"></i>
								<span class="title">Dumps</span>
								<span class="selected"></span>
							</a>
						</li>
                        {% endif %}
                        {% if session['userType'] == '3' %}
                        <li>
							<a href="#" onclick="showpage('sellerstats.php');"><i class="clip-stats"></i>
								<span class="title">Seller Stats</span>
								<span class="selected"></span>
							</a>
						</li>
                        {% endif %}
                        {% if config['salecc'] == '1' %}
                        <li>
							<a href="#" onclick="showpage('checkcc.php');"><i class="clip-cc"></i>
								<span class="title">CC Checker</span>
								<span class="selected"></span>
							</a>
						</li>
                        {% endif %}
                        <!-- <li>
							<a href="#" onclick="showpage('packs.php');"><i class="clip-archive"></i>
								<span class="title">Dump Packs</span>
								<span class="selected"></span>
							</a>
						</li>-->
						<li> 
							<a href="#" onclick="showpage('checkbin.php');"><i class="clip-study"></i>
								<span class="title">Bin Checker</span>
								<span class="selected"></span>
							</a>
						</li>
						{% if config['salecc'] == '1' %}
                        <li>
							<a href="#" onclick="showpage('card.php?act=mycard');"><i class="clip-user-2"></i>
								<span class="title">My Cards</span>
								<span class="selected"></span>
							</a>
						</li>
                        {% endif %}
                        {% if config['saledump'] == '1' %}
                        <li>
							<a href="#" onclick="showpage('dumps.php?act=mycard');"><i class="clip-user-3"></i>
								<span class="title">My Dumps</span>
								<span class="selected"></span>
							</a>
						</li>
                        {% endif %}
                        {% if config['packs'] == '1' %}
                        <!-- <li>
							<a href="#" onclick="showpage('packs.php?act=mypacks');"><i class="clip-user-5"></i>
								<span class="title">My Packs</span>
								<span class="selected"></span>
							</a>
						</li> -->
                        {% endif %}
                        <li>
							<a href="#" onclick="showpage('buy.php');"><i class="fa fa-money"></i>
								<span class="title">Add Balance</span>
								<span class="selected"></span>
							</a>
						</li>
                        <li>
							<a href="#" onclick="showpage('faq.php');"><i class="fa fa-question"></i>
								<span class="title">FAQ</span>
								<span class="selected"></span>
							</a>
						</li>
                       <!-- <li class="nav-item uppercase-link">
                        <a href="#" class="nav-link" data-toggle="modal" data-target="#rangoModal">Rank
                            <span class="label label-warning"><?php require_once 'news.php'; ?></span>
                        </a>
                        </li> -->
                        {% if session['userType'] != '1' %}
                        <li>
							<a href="#" onclick="showpage('support.php');"><i class="fa fa-stack-exchange"></i>
								<span class="title">Support</span>
								<span class="selected"></span>
							</a>
						</li>
                        {% endif %}
					</ul>
				</div>
			</div>



