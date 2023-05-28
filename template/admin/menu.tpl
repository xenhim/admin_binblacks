<div class="navbar-content">
				<!-- start: SIDEBAR -->
				<div class="main-navigation navbar-collapse collapse">
					<!-- start: MAIN MENU TOGGLER BUTTON -->
					<div class="navigation-toggler">
						<i class="clip-chevron-left"></i>
						<i class="clip-chevron-right"></i>
					</div>
					<!-- end: MAIN MENU TOGGLER BUTTON -->
					<!-- start: MAIN NAVIGATION MENU -->
					<ul class="main-navigation-menu">
						<li class="active open">
							<a href="#" onclick="showpage('news.php');"><i class="clip-home-3"></i>
								<span class="title">News</span><span class="selected"></span>
							</a>
						</li>
						<li>
							<a href="#" onclick="javascript:void(0)"><i class="fa fa-credit-card"></i>
								<span class="title">Credit Cards</span><i class="icon-arrow"></i>
								<span class="selected"></span>
							</a>
                            <ul class="sub-menu">						
								<li>
									<a href="#" onclick="showpage('card.php');">
										<span class="title">Credit Cards</span>
									</a>
								</li>
                                <li>
									<a href="#" onclick="showpage('addprice.php');">
										<span class="title">Set CC Price</span>
									</a>
								</li>
                                <li>
									<a href="#" onclick="showpage('editprice.php');">
										<span class="title">Edit CC Price</span>
									</a>
								</li>
                                <li>
									<a href="#" onclick="showpage('category.php');">
										<span class="title">CC Categorys</span>
									</a>
								</li>
							</ul>
						</li>
                        <li>
							<a href="#" onclick="javascript:void(0)"><i class="fa fa-credit-card"></i>
								<span class="title">Dumps</span><i class="icon-arrow"></i>
								<span class="selected"></span>
							</a>
                            <ul class="sub-menu">						
								<li>
									<a href="#" onclick="showpage('dumps.php');">
										<span class="title">Dumps</span>
									</a>
								</li>
                                <li>
									<a href="#" onclick="showpage('dumpaddprice.php');">
										<span class="title">Set Dump Price</span>
									</a>
								</li>
                                <li>
									<a href="#" onclick="showpage('dumpeditprice.php');">
										<span class="title">Edit Dump Price</span>
									</a>
								</li>
                                <li>
									<a href="#" onclick="showpage('dumpcategory.php');">
										<span class="title">Dump Categorys</span>
									</a>
								</li>
							</ul>
						</li>
                        <li>
							<a href="#" onclick="showpage('packs.php');"><i class="clip-archive"></i>
								<span class="title">Dump Packs</span>
								<span class="selected"></span>
							</a>
						</li>
						<li>
							<a href="javascript:void(0)"><i class="clip-bars"></i>
								<span class="title">Stats</span><i class="icon-arrow"></i>
							</a>
                            <ul class="sub-menu">						
								<li>
									<a href="#" onclick="showpage('istat.php');">
										<span class="title">Main info</span>
									</a>
								</li>
								<li>
									<a href="#" onclick="showpage('stat.php');">
										<span class="title">Full sales cards</span>
									</a>
								</li>
								<li>
									<a href="#" onclick="showpage('restat.php');">
										<span class="title">Sellers info</span>
									</a>
								</li>
                                <li>
									<a href="#" onclick="showpage('dumpstat.php');">
										<span class="title">Dumps stat</span>
									</a>
								</li>
                                <li>
									<a href="#" onclick="showpage('salepacks.php');">
										<span class="title">Packs</span>
									</a>
								</li>
							</ul>
						</li>
                        <li>
							<a href="#" onclick="showpage('order.php?act=lastweek');"><i class="clip-banknote"></i>
								<span class="title">Orders</span>
                                <span class="badge badge-new">{{totalOrder}}</span>
								<span class="selected"></span>
							</a>
						</li>
                        <li>
							<a href="#" onclick="showpage('user.php');"><i class="clip-user-2"></i>
								<span class="title">Users</span>
                                <span class="badge badge-new">{{totalUser}}</span>
								<span class="selected"></span>
							</a>
						</li>
                        <li>
							<a href="#" onclick="showpage('setting.php');"><i class="clip-settings"></i>
								<span class="title">Settings</span>
								<span class="selected"></span>
							</a>
						</li>
						<li>
							<a href="#" onclick="showpage('faq.php');"><i class="fa fa-question"></i>
								<span class="title">FAQ</span>
								<span class="selected"></span>
							</a>
						</li>
                        <li>
							<a href="#" onclick="showpage('support.php');"><i class="fa fa-stack-exchange"></i>
								<span class="title">Support</span>
								<span class="selected"></span>
							</a>
						</li>
                        
					</ul>
				</div>
			</div>