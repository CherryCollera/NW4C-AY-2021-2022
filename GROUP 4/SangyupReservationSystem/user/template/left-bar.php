<aside id="sidebar-left" class="sidebar-left">
				
	<div class="sidebar-header">
		<div class="sidebar-title">
			Navigation
		</div>
		<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
			<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
		</div>
	</div>

	<div class="nano">
		<div class="nano-content">
			<nav id="menu" class="nav-main" role="navigation">
				<ul class="nav nav-main">
					<li class="nav-active">
						<a href="../index.php">
							<i class="fa fa-home" aria-hidden="true"></i>
							<span>Home</span>
						</a>
					</li>
					<?php if((isset($_SESSION['isLoggedIn']) && $_SESSION['role'] == 2)){ ?>
					<li class="nav-parent">
						<a>
							<i class="fas fa-money-check-alt" aria-hidden="true"></i>
							<span>Appointments</span>
						</a>
						<ul class="nav nav-children">
							<li>
								<a href="bookings.php">
									<span class="pull-right label label-info">list</span>
									<i class="fas fa-list-ul" aria-hidden="true"></i>
									<span>Reservation</span>
								</a>
								<a href="deliveryy.php">
									<span class="pull-right label label-info">list</span>
									<i class="fas fa-list-ul" aria-hidden="true"></i>
									<span>Pick-Up</span>
								</a>
							</li>
						</ul>
					</li>
					<?php } ?> 

					<?php if((isset($_SESSION['isLoggedIn']) && $_SESSION['role'] == 2)){ ?>
					<li class="nav-parent">
						
							<a href="../index.php">
							<span class="pull-right label label-primary">add</span>
							<span>New Booking</span></a>
							</a>
					</li>
					<?php } ?>
				</ul>
			</nav>

			<hr class="separator" />
		</div>

	</div>

</aside>