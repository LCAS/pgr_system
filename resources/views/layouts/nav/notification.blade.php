<!--

<li class="dropdown messages-menu">
  {{-- Menu toggle button --}}
  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-calendar-check-o"></i>
    <span class="label label-success">4</span>
  </a>
  <ul class="dropdown-menu">
    <li class="header">You have 4 messages</li>
    <li>
      {{-- inner menu: contains the messages --}}
      <ul class="menu">
        {{-- <li>start message --}}
          <a href="#">
            <div class="pull-left">
              {{-- User Image --}}
              <img src="{{ Auth::user()->avatar(40) }}" class="img-circle" alt="User Image">
            </div>
            {{-- Message title and timestamp --}}
            <h4>
            Support Team
            <small><i class="fa fa-clock-o"></i> 5 mins</small>
            </h4>
            {{-- The message --}}
            <p>Why not buy a new awesome theme?</p>
          </a>
        </li>
        {{-- end message --}}
      </ul>
      {{-- /.menu --}}
    </li>
    <li class="footer"><a href="#">See All Messages</a></li>
  </ul>
</li>
{{-- /.messages-menu --}}
{{-- ======================================== --}}
{{-- Notifications Menu --}}
<li class="dropdown notifications-menu">
  {{-- Menu toggle button --}}
  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-calendar-plus-o"></i>
    <span class="label label-warning">2</span>
  </a>
  <ul class="dropdown-menu">
    <li class="header">You have 10 notifications</li>
    <li>
      <ul class="menu">
        {{-- <li>start notification --}}
          <a href="#">
            <i class="fa fa-users text-aqua"></i> 5 new members joined today
          </a>
        </li>
        
      </li>
    </ul>
    <li class="footer">
      <a href="#">
        View all
      </a>
    </li>
  </ul>
</li>
{{-- Tasks Menu --}}
<li class="dropdown tasks-menu">
  {{-- Menu Toggle Button --}}
  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-calendar-times-o"></i>
    <span class="label label-danger">9</span>
  </a>
  <ul class="dropdown-menu">
    <li class="header">You have 9 tasks</li>
    <li>
      {{-- Inner menu: contains the tasks --}}
      <ul class="menu">
        {{-- <li>Task item --}}
          <a href="#">
            {{-- Task title and progress text --}}
            <h3>
            Design some buttons
            <small class="pull-right">20%</small>
            </h3>
            {{-- The progress bar --}}
            <div class="progress xs">
              {{-- Change the css width attribute to simulate progress --}}
              <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                <span class="sr-only">20% Complete</span>
              </div>
            </div>
          </a>
        </li>
        {{-- end task item --}}
      </ul>
    </li>
    <li class="footer">
      <a href="#">View all tasks</a>
    </li>
  </ul>
</li>

-->