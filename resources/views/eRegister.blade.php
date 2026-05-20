<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">


<!-- Mirrored from themesbrand.com/velzon/html/default/forms-elements.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 02 Aug 2025 15:48:18 GMT -->
<head>

    <meta charset="utf-8" />
    <title>{{$intitution->institution_name}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Layout config Js -->
    <script src="{{asset('assets/js/layout.js')}}"></script>
    <!-- Bootstrap Css -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{asset('assets/css/custom.min.css')}}" rel="stylesheet" type="text/css" />


</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <!-- App Search-->
             
            </div>

         
        </div>
    </div>
</header>

<!-- removeNotificationModal -->
<div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
         
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                 <div class="container-fluid">

                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                           


                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{url('/')}}">
                                <i class="ri-honour-line"></i> <span data-key="t-widgets">Dashboard</span>
                            </a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link menu-link" href="{{url('registered')}}">
                                <i class="ri-honour-line"></i> <span data-key="t-widgets" style="color:white;">Registered institutions</span>
                            </a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link menu-link" href="{{url('defaulters')}}">
                                <i class="ri-honour-line"></i> <span data-key="t-widgets">Defaulters</span>
                            </a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link menu-link" href="{{url('disconnected')}}">
                                <i class="ri-honour-line"></i> <span data-key="t-widgets">Disconnected Institutions</span>
                            </a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link menu-link" href="{{url('bandwidth')}}">
                                <i class="ri-honour-line"></i> <span data-key="t-widgets">Bandwidth</span>
                            </a>
                        </li>


                    </ul>
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0"><span style="color:blue;">{{$intitution->institution_name}}</span> Details</h4>

                            

                            </div>
                        </div>
                    </div>
                    @include('flash-message')
                    <!-- end page title -->
                    <div class="row">
                            @if($intitution->defaulters_status===0)
                                <div class="col-xl-4">
                                    <div class="card">
                                        <div class="card-body p-0">
                                            <div class="alert alert-warning border-0 rounded-top rounded-0 m-0 d-flex align-items-center" role="alert">
                                                <i data-feather="alert-triangle" class="text-warning me-2 icon-sm"></i>
                                                <div class="flex-grow-1 text-truncate">
                                                    Default Status
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <a href="#" class="text-reset text-decoration-underline"><b>Defaulted</b></a>
                                                    
                                                    
                                                </div>
                                            </div>

                                            <div class="row align-items-end">
                                                <div class="col-sm-8">
                                                    <div class="p-3">
                                                        <div class="mt-3">
                                                            <a href="{{url('removeDefault',$intitution->id)}}" class="btn btn-info">Remove Default</a>
                                                            
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="px-3">
                                                        <img src="assets/images/user-illustarator-2.png" class="img-fluid" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- end card-body-->
                                    </div>
                                </div> <!-- end col-->
                            @else
                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-body p-0">
                                    <div class="alert alert-warning border-0 rounded-top rounded-0 m-0 d-flex align-items-center" role="alert">
                                        <i data-feather="alert-triangle" class="text-warning me-2 icon-sm"></i>
                                        <div class="flex-grow-1 text-truncate">
                                            Default Status
                                        </div>
                                        <div class="flex-shrink-0">
                                            
                                            <a href="p#" class="text-reset text-decoration-underline"><b>Okay</b></a>
                                            
                                        </div>
                                    </div>

                                    <div class="row align-items-end">
                                        <div class="col-sm-8">
                                            <div class="p-3">
                                                <div class="mt-3">
                                                    
                                                    <a href="{{url('default',$intitution->id)}}" class="btn btn-info">Default</a>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="px-3">
                                                <img src="assets/images/user-illustarator-2.png" class="img-fluid" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card-body-->
                            </div>
                        </div> <!-- end col-->
                        @endif
                        @if($intitution->connection_status===0)
                        <div class="col-xl-4">
                            <div class="card bg-primary">
                                <div class="card-body p-0">
                                    <div class="alert alert-danger rounded-top alert-solid alert-label-icon border-0 rounded-0 m-0 d-flex align-items-center" role="alert">
                                        <div class="flex-grow-1 text-truncate">
                                            Connection Status
                                        </div>
                                        <div class="flex-shrink-0">
                                            <a href="" class="text-reset text-decoration-underline"><b>Disconnected</b></a>
                                        </div>
                                    </div>

                                    <div class="row align-items-end">
                                        <div class="col-sm-8">
                                            <div class="p-3">
                                                <div class="mt-3">
                                                    <a href="{{url('connect',$intitution->id)}}" class="btn btn-danger">Connect</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="px-3">
                                                <img src="assets/images/user-illustarator-1.png" class="img-fluid" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card-body-->
                            </div>
                        </div> <!-- end col-->
                        @else
                          <div class="col-xl-4">
                            <div class="card bg-primary">
                                <div class="card-body p-0">
                                    <div class="alert alert-danger rounded-top alert-solid alert-label-icon border-0 rounded-0 m-0 d-flex align-items-center" role="alert">
                                        <div class="flex-grow-1 text-truncate">
                                            Connection Status
                                        </div>
                                        <div class="flex-shrink-0">
                                            <a href="" class="text-reset text-decoration-underline"><b>Connected</b></a>
                                        </div>
                                    </div>

                                    <div class="row align-items-end">
                                        <div class="col-sm-8">
                                            <div class="p-3">
                                                <div class="mt-3">
                                                    <a href="{{url('removeConnect',$intitution->id)}}" class="btn btn-danger">Disconnect</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="px-3">
                                                <img src="assets/images/user-illustarator-1.png" class="img-fluid" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card-body-->
                            </div>
                        </div> <!-- end col-->
                        @endif


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                            <form action="{{url('eInstitution')}}" method="post">
                                        @csrf
                                <div class="card-body">
                                    <div class="live-preview">
                                        <div class="row gy-4">
                                            <div class="col-xxl-3 col-md-6">
                                                <div>
                                                    <label for="basiInput" class="form-label">Institution Name</label>
                                                    <input type="text" name="institution_name" class="form-control" value="{{$intitution->institution_name}}">
                                                </div>
                                            </div>
                                             <div class="col-xxl-3 col-md-6">
                                                <div>
                                                    <label for="basiInput" class="form-label">Registration Fee</label>
                                                    <input type="text" name="registration_fee" class="form-control" value="{{$intitution->registration_fee}}">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-xxl-3 col-md-6">
                                                <div>
                                                    <label for="labelInput" class="form-label">Installation Fee</label>
                                                    <input type="text" name="instalation_fee" class="form-control" value="{{$intitution->instalation_fee}}">
                                                </div>
                                            </div>
                                            <!--end col-->
                                             <div class="col-xxl-3 col-md-6">
                                                <div>
                                                    <label for="labelInput" class="form-label">Montly Fee</label>
                                                    <input type="text" name="instalation_fee" class="form-control" value="{{$intitution->monthly_payment->amount}}">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-xxl-3 col-md-6">
                                                <div>
                                                    <label for="valueInput" class="form-label">No of Computers</label>
                                                    <input type="text" name="No_of_computers" class="form-control" value="{{$intitution->No_of_computers}}">
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-md-6">
                                                <div>
                                                    <label for="valueInput" class="form-label">Local Area Network(LAN) Nodes</label>
                                                    <input type="text" name="lan_nodes" class="form-control" value="{{$intitution->lan_nodes}}">
                                                </div>
                                            </div>
                                            
                                                <div class="col-12">
                                                    <a href="{{URL('register')}}"><button class="btn btn-primary" type="submit">Save</button></a>
                                                </div>
                                            <!--end col-->
                                          
                                    
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </div>
                                  
                                </div>
                            </form>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->

          <div class="row">
                      
                        <div class="col-xl-4 col-md-6">
                            <div class="card card-height-100">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Breakdown Cost for Installation</h4>
                                    <div class="flex-shrink-0">
                                        <button type="button" class="btn btn-soft-primary btn-sm">
                                            Export Report
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">

                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <h6 class="text-muted text-uppercase fw-semibold text-truncate fs-12 mb-3">Total Installation Cost  </h6>
                                            <h4 class="mb-0">Ksh 725,800</h4>
                                        </div><!-- end col -->
                                        <div class="col-6">
                                            <div class="text-center">
                                                <img src="assets/images/illustrator-1.png" class="img-fluid" alt="">
                                            </div>
                                        </div><!-- end col -->
                                    </div><!-- end row -->
                                    <div class="mt-3 pt-2">
                                        <div class="progress progress-lg rounded-pill">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 18%" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100"></div>
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 22%" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 16%" aria-valuenow="16" aria-valuemin="0" aria-valuemax="100"></div>
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 19%" aria-valuenow="19" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div><!-- end -->

                                    <div class="mt-3 pt-2">
                                        <div class="d-flex mb-2">
                                            <div class="flex-grow-1">
                                                <p class="text-truncate text-muted fs-14 mb-0"><i class="mdi mdi-circle align-middle text-primary me-2"></i>Registration Fee </p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <p class="mb-0">Ksh {{$intitution->registration_fee}}</p>
                                            </div>
                                        </div><!-- end -->
                                        <div class="d-flex mb-2">
                                            <div class="flex-grow-1">
                                                <p class="text-truncate text-muted fs-14 mb-0"><i class="mdi mdi-circle align-middle text-info me-2"></i>Installation Fee </p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <p class="mb-0">Ksh {{$intitution->instalation_fee}}</p>
                                            </div>
                                        </div><!-- end -->
                                        <div class="d-flex mb-2">
                                            <div class="flex-grow-1">
                                                <p class="text-truncate text-muted fs-14 mb-0"><i class="mdi mdi-circle align-middle text-success me-2"></i>Monthly Charge for Internet Service </p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <p class="mb-0">Ksh {{$intitution->monthly_payment->amount}}</p>
                                            </div>
                                        </div><!-- end -->
                                         <div class="d-flex mb-2">
                                            <div class="flex-grow-1">
                                                <p class="text-truncate text-muted fs-14 mb-0"><i class="mdi mdi-circle align-middle text-success me-2"></i>Discounted Price </p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <p class="mb-0">N/A</p>
                                            </div>
                                        </div><!-- end -->
                                        <div class="d-flex mb-2">
                                            <div class="flex-grow-1">
                                                <p class="text-truncate text-muted fs-14 mb-0"><i class="mdi mdi-circle align-middle text-warning me-2"></i>Overdue Fines </p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <p class="mb-0">N/A</p>
                                            </div>
                                        </div><!-- end -->
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-truncate text-muted fs-14 mb-0"><i class="mdi mdi-circle align-middle text-danger me-2"></i>Reconnection Fee </p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <p class="mb-0">N/A</p>
                                            </div>
                                        </div><!-- end -->
                                        <br>
                                          <div class="d-flex mb-2">
                                            <div class="flex-grow-1">
                                                <p class="text-truncate text-muted fs-14 mb-0"><i class="mdi mdi-circle align-middle text-warning me-2"></i>Personal Computer/s </p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <p class="mb-0">N/A</p>
                                            </div>
                                        </div><!-- end -->
                                          <div class="d-flex mb-2">
                                            <div class="flex-grow-1">
                                                <p class="text-truncate text-muted fs-14 mb-0"><i class="mdi mdi-circle align-middle text-warning me-2"></i> Local Area Network(LAN) Nodes  </p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <p class="mb-0">N/A</p>
                                            </div>
                                        </div><!-- end -->
                                    </div><!-- end -->

                                    <div class="mt-2 text-center">
                                        <a href="javascript:void(0);" class="text-muted text-decoration-underline">Show All</a>
                                    </div>

                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                    </div><!-- end row -->

        
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    


    <!--start back-to-top-->
  
    <!--end back-to-top-->

    <!--preloader-->


    <!-- JAVASCRIPT -->
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="assets/js/plugins.js"></script>

    <!-- prismjs plugin -->
    <script src="assets/libs/prismjs/prism.js"></script>

    <script src="assets/js/app.js"></script>

</body>


<!-- Mirrored from themesbrand.com/velzon/html/default/forms-elements.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 02 Aug 2025 15:48:18 GMT -->
</html>