<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<meta charset="utf-8" />
	<title>CrowdCureDB</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="assets/plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
	<link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	<link href="assets/css/style-metro.css" rel="stylesheet" type="text/css"/>
	<link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
	<link href="assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
	<link href="assets/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
	<link href="assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" type="text/css" href="assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.css"/>
	<link href="assets/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" type="text/css" href="assets/plugins/select2/select2_metro.css" />
	<link rel="stylesheet" href="assets/plugins/data-tables/DT_bootstrap.css" />
	<!-- END GLOBAL MANDATORY STYLES -->
	<link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed page-full-width">
	<!-- BEGIN HEADER -->
	<div class="header navbar navbar-inverse navbar-fixed-top">
		<!-- BEGIN TOP NAVIGATION BAR -->
		<div class="navbar-inner">
			<div class="container-fluid">
				<!-- BEGIN LOGO -->
				<a class="brand" href="index.html">
				<img src="assets/img/logo.png" alt="logo" />
				</a>
				<!-- END LOGO -->
				<!-- BEGIN HORIZANTAL MENU -->
				<div class="navbar hor-menu hidden-phone hidden-tablet">
					<div class="navbar-inner">
						<ul class="nav">
							<li>
								<a href="dashboard">
								<span class="selected"></span>
								Dashboard
								</a>
							</li>
							<li  class='active'>
								<a data-toggle='dropdown' class='dropdown-toggle' href='javascript:;'>
									<span class='selected'></span> 
									Queries
									<span class='arrow'></span>
								</a>
								<ul class='dropdown-menu'>
									<li><a href='createquery'>Create</a></li>
									<li><a href='ongoingquery'>Ongoing</a></li>
									<li><a href='archivequery'>Archive</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
				<!-- END HORIZANTAL MENU -->
				<!-- BEGIN RESPONSIVE MENU TOGGLER -->
				<a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
				<img src="assets/img/menu-toggler.png" alt="" />
				</a>          
				<!-- END RESPONSIVE MENU TOGGLER -->            
				<!-- BEGIN TOP NAVIGATION MENU -->              
				<ul class="nav pull-right">
					<!-- BEGIN NOTIFICATION DROPDOWN -->   
					<li class="dropdown" id="header_notification_bar">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-warning-sign"></i>
						<span class="badge"></span>
						</a>
						<ul class="dropdown-menu extended notification">
							<li>
								<p>You have no new notifications</p>
							</li>							
							<li class="external">
								<a href="#">See all notifications <i class="m-icon-swapright"></i></a>
							</li>
						</ul>
					</li>
					<!-- END NOTIFICATION DROPDOWN -->
					<!-- BEGIN INBOX DROPDOWN -->
					<li class="dropdown" id="header_inbox_bar">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-envelope"></i>
						<span class="badge"></span>
						</a>
						<ul class="dropdown-menu extended inbox">
							<li>
								<p>You have no new messages</p>
							</li>							
							<li class="external">
								<a href="inbox.html">See all messages <i class="m-icon-swapright"></i></a>
							</li>
						</ul>
					</li>
					<!-- END INBOX DROPDOWN -->
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<li class="dropdown user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img alt="" src="assets/img/avatar_small.png" />
						<span class="username"><?= $sessionData['username'] ?></span>
						<i class="icon-angle-down"></i>
						</a>
						<ul class="dropdown-menu">
							<li><a href="extra_profile.html"><i class="icon-user"></i> My Profile</a></li>
							<li><a href="#"><i class="icon-envelope"></i> My Inbox</a></li>
							<?php 
								if( $sessionData['usertypeid'] != 3 ) {
									echo "<li><a href='#'><i class='icon-tasks'></i> My Tasks</a></li>";
								}
							?>
							<li class="divider"></li>
							<li><a href="logout"><i class="icon-key"></i> Log Out</a></li>
						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
				<!-- END TOP NAVIGATION MENU --> 
			</div>
		</div>
		<!-- END TOP NAVIGATION BAR -->
	</div>
	<!-- END HEADER -->
	<!-- BEGIN CONTAINER -->   
	<div class="page-container row-fluid" >
		<!-- BEGIN EMPTY PAGE SIDEBAR -->
		<div class="page-sidebar nav-collapse collapse visible-phone visible-tablet">
			<ul class="page-sidebar-menu">
				<li>
					<a href="dashboard">
					<span class="selected"></span> 
					Dashboard                        
					</a>
				</li>
				<?php
					if( $sessionData['usertypeid'] == 2 ) {
						echo "<li>
							<a href=''>
								User Management
								<span class='arrow'></span>
							</a>
							<ul class='sub-menu'>
								<li><a href=''>Experts</a></li>
								<li><a href=''>Users</a></li>
							</ul>	
						</li>
						<li>
							<a href=''> Query Management</a>
						</li>";
					}
					else if( $sessionData['usertypeid'] == 1 ) {
						echo "<li>
							<a href=''>
								Queries
								<span class='arrow'></span>
							</a>
							<ul class='sub-menu'>
								<li><a href=''>Pending</a></li>
								<li><a href=''>Archive</a></li>
							</ul>
						</li>";
					}
					else {
						echo "<li>
							<a href=''> 
								Queries
								<span class='arrow'></span>
							</a>
							<ul class='sub-menu'>
								<li class='active'><a class='active' href='createquery'>Create</a></li>
								<li><a href=''>Pending</a></li>
								<li><a href=''>Archive</a></li>
							</ul>
						</li>";
					}
				?>
			</ul>
		</div>
		<!-- END EMPTY PAGE SIDEBAR -->
		<!-- BEGIN PAGE -->
		<div class="page-content">
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<div id="portlet-config" class="modal hide">
				<div class="modal-header">
					<button data-dismiss="modal" class="close" type="button"></button>
					<h3>portlet Settings</h3>
				</div>
				<div class="modal-body">
					<p>Here will be a configuration form</p>
				</div>
			</div>
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN STYLE CUSTOMIZER -->
						<!--<div class="color-panel hidden-phone">
							<div class="color-mode-icons icon-color"></div>
							<div class="color-mode-icons icon-color-close"></div>
							<div class="color-mode">
								<p>THEME COLOR</p>
								<ul class="inline">
									<li class="color-black current color-default" data-style="default"></li>
									<li class="color-blue" data-style="blue"></li>
									<li class="color-brown" data-style="brown"></li>
									<li class="color-purple" data-style="purple"></li>
									<li class="color-grey" data-style="grey"></li>
									<li class="color-white color-light" data-style="light"></li>
								</ul>
								<label>
									<span>Layout</span>
									<select class="layout-option m-wrap small">
										<option value="fluid" selected>Fluid</option>
										<option value="boxed">Boxed</option>
									</select>
								</label>
								<label>
									<span>Header</span>
									<select class="header-option m-wrap small">
										<option value="fixed" selected>Fixed</option>
										<option value="default">Default</option>
									</select>
								</label>
								<label>
									<span>Sidebar</span>
									<select class="sidebar-option m-wrap small">
										<option value="fixed">Fixed</option>
										<option value="default" selected>Default</option>
									</select>
								</label>
								<label>
									<span>Footer</span>
									<select class="footer-option m-wrap small">
										<option value="fixed">Fixed</option>
										<option value="default" selected>Default</option>
									</select>
								</label>
							</div>
						</div>-->
						<!-- END BEGIN STYLE CUSTOMIZER --> 
						<!-- BEGIN PAGE TITLE & BREADCRUMB-->
						<h3 class="page-title">
							Create Query <small></small>
						</h3>
						<ul class="breadcrumb">
							<li>
								<a href="dashboard"><i class="icon-home"></i></a>
								<a href="#">Query</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<a href="createquery">Create</a>
								<!--<i class="icon-angle-right"></i>-->
							</li>
							<!--<li><a href="#">Horzontal Menu 1</a></li>-->
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid margin-bottom-20">
					<div class="span2"></div>
					<div class="span8">
						<!-- BEGIN INLINE TABS PORTLET-->
						<div class="portlet box grey" id="cqbase">
							<div class="portlet-title">
								<div class="caption" id="cqbasetitle">Select Data Table</div>
							</div>
							<div id='msginsertkey'></div>
							<div id='msgenterkeybtn'></div>
							<div class="portlet-body" id="cqbasebody">
								<div class="row-fluid">
									<div class="span12">
										<div class="span5">
											<div class="well" style="text-align: justify">
												<h4>Existing Table</h4>
												Select any of the existing tables containing different types of interacting protein data. Each of the tables has different columns. <br><br><br>
												<!--<div class="control-group">
													<div class="controls" style="text-align: center">
														<select class="medium m-wrap" tabindex="1">
															<option value="Category 1">Category 1</option>
															<option value="Category 2">Category 2</option>
															<option value="Category 3">Category 5</option>
															<option value="Category 4">Category 4</option>
														</select>
													</div>
												</div>-->
												<a class="btn green btn-block ccbtn" href="#" id="oldtablebtn">
													Select Table
													<i class="m-icon-swapright m-icon-white"></i>
												</a>
											</div>
										</div>
										<div class="span2">
										<div style="margin: 20px auto; text-align: center">
											<a class="btn grey"> OR </a>
										</div>
										</div>
										<div class="span5">
											<div class="well" style="text-align: justify">
												<h4>Custom Table</h4>
												Proceed to create a new data table with different columns to store interaction data. The interaction data will be extracted from various mining tools and/or collected by a number of experts. <br><br>
												<a class="btn green btn-block ccbtn" href="#" id="newtablebtn">
													Create Table
													<i class="m-icon-swapright m-icon-white"></i>
												</a>
											</div>
										</div>
									</div>
								</div>								
							</div>
						</div>

						<!-- END INLINE TABS PORTLET-->
					</div>
					<div class="span2"></div>
				</div>
				<!-- END PAGE CONTENT-->
			</div>
			<div style='display: none;'>
				<a id='modal-caller-btn' class=" btn yellow" href="#full-width" data-toggle="modal">modal caller</a>
			</div>
			<div id="full-width" class="modal container hide fade" tabindex="-1" data-backdrop="full-width" data-keyboard="false">
				<div class="modal-body" id='modal-expert-table'>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn green" id='modal-add-expert'>Add Expert</button>
					<button type="button" data-dismiss="modal" class="btn red" id='my-modal-close-btn'>Cancel</button>
				</div>
			</div>
			<!-- END PAGE CONTAINER--> 
		</div>
		<!-- END PAGE -->    
	</div>
	<!-- END CONTAINER -->
	<!-- BEGIN FOOTER -->
	<div class="footer">
		<div class="footer-inner">
			2016 &copy; CrowdCureDB
		</div>
		<div class="footer-tools">
			<span class="go-top">
			<i class="icon-angle-up"></i>
			</span>
		</div>
	</div>
	<!-- END FOOTER -->
	<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
	<!-- BEGIN CORE PLUGINS -->
	<script src="assets/plugins/jquery-1.10.1.min.js" type="text/javascript"></script>
	<script src="assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
	<script src="assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>      
	<script src="assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<!--[if lt IE 9]>
	<script src="assets/plugins/excanvas.min.js"></script>
	<script src="assets/plugins/respond.min.js"></script>  
	<![endif]-->   
	<script src="assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>  
	<script src="assets/plugins/jquery.cookie.min.js" type="text/javascript"></script>
	<script src="assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>
	<!-- END CORE PLUGINS -->
	<script src="assets/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript" ></script>
	<script src="assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript" ></script>
	<script src="assets/scripts/app.js"></script>
	<script src="assets/scripts/ui-modals.js"></script>
	<script src="assets/scripts/ui-jqueryui.js"></script>
	<script src="assets/scripts/createquery.js"></script>
	<script src="assets/scripts/table-managed.js"></script>
	<script type="text/javascript" src="assets/plugins/select2/select2.min.js"></script>
	<script type="text/javascript" src="assets/plugins/data-tables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="assets/plugins/data-tables/DT_bootstrap.js"></script>
	<script>
		jQuery(document).ready(function() {    
		   App.init();
		   UIModals.init();
		   UIJQueryUI.init();		     
		});        
	</script>
	<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>