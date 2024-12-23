<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content=" MD Rayhan Babu " />
    <title> ANCOVA Admin Panel </title>
    <link rel="icon" type="image/png" href="{{asset('images/ancovabr.png')}}">
  

    <link rel="stylesheet" href="{{asset('dashboardfornt/css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('dashboardfornt/css/dataTables.bootstrap5.min.css')}}">
    <link rel="stylesheet" href="{{asset('dashboardfornt/css/bootstrap-clockpicker.min.css')}}">
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

    <link rel='stylesheet'
     href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />


     
    <meta name="csrf-token" content="{{ csrf_token() }}">
    

    <script src="{{asset('dashboardfornt\js\jquery-3.5.1.js')}}"></script>
    <script src="{{asset('dashboardfornt\js\bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('dashboardfornt\js\jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('dashboardfornt\js\dataTables.bootstrap5.min.js')}}"></script>
    <script src="{{asset('dashboardfornt/js/sweetalert.min.js')}}"></script>
    <script src="{{asset('dashboardfornt/js/scripts.js')}}"></script>
    <script src="{{asset('dashboardfornt/js/bootstrap-clockpicker.min.js')}}"></script>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
      
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"  />
       <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" ></script>
  

     
    </head>
 
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-light bg-primary text-white">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3 text-white"  href="#" >ANCOVA </a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order order-lg-0 me-4 me-lg-0 text-white" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                      {{ teacher_info()['teacher_name']}}
                </div>
            </form>
            <!-- Navbar-->
           
           

          <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
               <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle text-white" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="{{ url('admin/password')}}">Password Change</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="{{ url('admin/logout')}}">Logout</a></li>
                    </ul>
                </li>
            </ul>
         </nav>


<div id="layoutSidenav">
  <div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
     <div class="sb-sidenav-menu">
       <div class="nav">
                           					   
       <a class="nav-link @yield('dashboard')" href="{{url('admin/dashboard')}}">
           <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
             Dashboard
        </a>

     @if(adminaccess())
     <a class="nav-link @yield('sleeve')  
       collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
         <div class="sb-nav-link-icon "><i class="fas fa-columns"></i></div>
              Setting
         <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
     </a>

  <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
          <nav class="sb-sidenav-menu-nested nav">
               <a class="nav-link @yield('collor')" href="{{url('/admin/collor_view')}}"> Contact View </a>
          </nav>
  </div>

       @if(teacher_login_access())
          <a class="nav-link @yield('teacher')" href="{{url('/admin/teacher_view')}}">
            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
               Manager 
           </a>
        @endif

        @if(payment_access())
        <a class="nav-link @yield('client')" href="{{url('/admin/client_view')}}">
           <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
               Client 
        </a>

        <a class="nav-link @yield('paymentview_select')" href="{{url('/admin/paymentview')}}">
            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Payment View 
        </a>
        @endif


        @if(product_access())
        <a class="nav-link @yield('notice_select')  
          collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsfour" aria-expanded="false" aria-controls="collapseLayouts">
          <div class="sb-nav-link-icon "><i class="fas fa-columns"></i></div>
            Product
          <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>

        <div class="collapse" id="collapseLayoutsfour" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
           <nav class="sb-sidenav-menu-nested nav">
                @foreach(product_category() as $row)                   
                 <a class="nav-link @yield('product/'.$row->id)" href="{{url('/admin/product/'.$row->id)}}">{{$row->week}} </a>                  
               @endforeach
           </nav>
        </div>
      @endif


        @if(member_access())
       <a class="nav-link @yield('sleeve')  
         collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts2" aria-expanded="false" aria-controls="collapseLayouts">
          <div class="sb-nav-link-icon "><i class="fas fa-columns"></i></div>
               Members
          <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
       </a>

       <div class="collapse" id="collapseLayouts2" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
          <nav class="sb-sidenav-menu-nested nav">
          @foreach(member_category() as $row)                   
                 <a class="nav-link @yield('Executive_select')" href="{{url('/admin/member_view/'.$row->id)}}">{{$row->week}} </a>                  
               @endforeach
          </nav>
       </div>
     @endif


     @if(event_access())
     <a class="nav-link @yield('notice_select')  
         collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutstwo" aria-expanded="false" aria-controls="collapseLayouts">
         <div class="sb-nav-link-icon "><i class="fas fa-columns"></i></div>
            News & Events
         <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
       </a>

      <div class="collapse" id="collapseLayoutstwo" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
           <nav class="sb-sidenav-menu-nested nav">
                @foreach(event_category() as $row)                   
                 <a class="nav-link @yield('Executive_select')" href="{{url('/admin/notice/'.$row->id)}}">{{$row->week}} </a>                  
               @endforeach
           </nav>
      </div>
    @endif


    @if(animal_access())
        <a class="nav-link @yield('almary')" href="{{url('/admin/almary_view')}}">
          <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
             Almary 
        </a>

        <a class="nav-link @yield('animal')" href="{{url('/admin/animal_view')}}">
          <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
             Animal 
        </a>

        @endif



        
    @if(duclub_access())
        <a class="nav-link @yield('dataview')" href="{{url('maintain/dataview')}}">
          <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
              Event Setting 
        </a>

        <a class="nav-link @yield('duclub_event')" href="{{url('/duclub/event')}}">
          <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
             Event Registration 
        </a>

        @endif


         


     
       @endif


      

    
  




   

    

  </div>
 </div>
                   
 
 
<div class="sb-sidenav-footer">
     <div class="small">Logged in as:</div>
          ANCOVA
      </div>
   </nav>
</div>



<div id="layoutSidenav_content">
<main>

<div class="container-fluid px-3">
      <div>
     @yield('content')
     </div>
</div>    

    </main>
               
            </div>
        </div> 

        
    
    </body>
</html>
