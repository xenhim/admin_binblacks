<div class="navbar-tools">
					<ul class="nav navbar-right">
                    {% if config['saledump'] == '1' %}
                    <li class="dropdown">
							<a class="dropdown-toggle" data-close-others="true" data-hover="dropdown" data-toggle="dropdown" href="#" onclick="showpage('dumpcart.php?act=order');">
								<span>DUMPS&nbsp;&nbsp;</span>
                                <i class="clip-cart"></i>
								<div id="dumpcart">
                                {% if session['dumps_val'] == false %}
                                <span class="badge"> 0</span>
                                {% else %}
                                <span class="badge"> {{session['dumps_val']}}</span>
                                {% endif %}
                            </div></a></li>
                    {% endif %}
                    {% if config['salecc'] == '1' %}
                        <li class="dropdown">
							<a class="dropdown-toggle" data-close-others="true" data-hover="dropdown" data-toggle="dropdown" href="#" onclick="showpage('cart.php?act=order');">
								<span>CC&nbsp;&nbsp;</span>
                                <i class="clip-cart"></i>
								<div id="cart">
                                {% if session['cards_val'] == false %}
                                <span class="badge"> 0</span>   
                                {% else %}
                                <span class="badge"> {{session['cards_val']}}</span>
                                {% endif %}
                                </div></a></li>
                    {% endif %}
                                
					<li class="dropdown">
							<a class="dropdown-toggle" data-close-others="true" data-hover="dropdown" data-toggle="dropdown" href="#">
								<i class="clip-bubble-3"></i>
                                {{msgnew | raw}}
							</a>
                                {{shortmsg | raw}}
					</li>
						<!-- start: USER DROPDOWN -->
						<li class="dropdown current-user">
							<a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" data-close-others="true" href="#">
                            <span id="balance"><span class="label label-info">{{credit}} $</span></span>
								<span class="username">{{session['username']}}</span>
								<i class="clip-chevron-down"></i>
							</a>
							<ul class="dropdown-menu">
								{% if config['salecc'] == '1' %}
                                <li>
									<a href="#" onclick="showpage('card.php?act=mycard');">
										<i class="clip-user-2"></i>
										&nbsp;My Cards
									</a>
								</li>
                                {% endif %}
								{% if config['saledump'] == '1' %}
                                <li>
									<a href="#" onclick="showpage('dumps.php?act=mycard');">
										<i class="clip-user-3"></i>
										&nbsp;My Dumps
									</a>
								</li>
                                {% endif %}
                                {% if config['packs'] == '1' %}
                                <li>
									<a href="#" onclick="showpage('packs.php?act=mypacks');">
										<i class="clip-user-5"></i>
										&nbsp;My Packs
									</a>
								</li>
                                {% endif %}
								<li>
									<a href="#" onclick="showpage('buy.php');">
										<i class="clip-calendar"></i>
										&nbsp;Add Balance
									</a>
								<li class="divider"></li>
								<li>
									<a href="#" onclick="logout();">
										<i class="clip-exit"></i>
										&nbsp;Log Out
									</a>
								</li>
							</ul>
						</li>
						<!-- end: USER DROPDOWN -->
					</ul>
				</div>