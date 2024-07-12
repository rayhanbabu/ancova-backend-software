@extends('frontend.layout')
@section('page_title','Admin Panel')
@section('home','active')
@section('content')

       <!-- Hero start -->
       <div class="container-xxl py-5 bg-primary hero-header mb-5">
                <div class="container my-5 py-5 px-lg-5">
                    <div class="row g-5 py-5">
                        <div class="col-lg-6 text-center text-lg-start">
                            <h1 class="text-white mb-4 animated zoomIn">Sortware Development, Data Analaysis & Research Center</h1>
                            <p class="text-white pb-3 animated zoomIn">{{$title?$title[0]->short_desc:""}}</p>
                       
                            <a href="{{url('contact')}}" class="btn btn-outline-light py-sm-3 px-sm-5 rounded-pill animated slideInRight">Contact Us</a>
                        </div>
                        <div class="col-lg-6 text-center text-lg-start">
                            <img class="img-fluid" src="img/hero.png" alt="">
                        </div>
                    </div>
                </div>
           </div>

        <!-- Navbar & Hero End -->

  <!-- About Start -->
   <div class="container-xxl py-5">
            <div class="container px-lg-5">
                <div class="row g-5">
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="section-title position-relative mb-4 pb-2">
                            <h6 class="position-relative text-primary ps-4">About Us</h6>
                            <h2 class="mt-2">{{$about?$about[0]->title:""}}</h2>
                        </div>
                        <p class="mb-4">{{$about?$about[0]->short_desc:""}}</p>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <h6 class="mb-3"><i class="fa fa-check text-primary me-2"></i>Award Winning</h6>
                                <h6 class="mb-0"><i class="fa fa-check text-primary me-2"></i>Professional Staff</h6>
                            </div>
                            <div class="col-sm-6">
                                <h6 class="mb-3"><i class="fa fa-check text-primary me-2"></i>24/7 Support</h6>
                                <h6 class="mb-0"><i class="fa fa-check text-primary me-2"></i>Fair Prices</h6>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mt-4">
                            <a class="btn btn-primary rounded-pill px-4 me-3" href="">Read More</a>
                            <a class="btn btn-outline-primary btn-square me-3" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-primary btn-square me-3" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-primary btn-square me-3" href=""><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-outline-primary btn-square" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <img class="img-fluid wow zoomIn" data-wow-delay="0.5s" src="{{ asset('/uploads/admin/'.$about[0]->image) }}">
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->


        <!-- Newsletter Start -->
        <div class="container-xxl bg-primary newsletter my-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container px-lg-5">
                <div class="row align-items-center" style="height: 250px;">
                    <div class="col-12 col-md-6">
                        <h3 class="text-white">Ready to get started</h3>
                        <small class="text-white">Diam elitr est dolore at sanctus nonumy.</small>
                        <div class="position-relative w-100 mt-3">
                            <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="text" placeholder="Enter Your Email" style="height: 48px;">
                            <button type="button" class="btn shadow-none position-absolute top-0 end-0 mt-1 me-2"><i class="fa fa-paper-plane text-primary fs-4"></i></button>
                        </div>
                    </div>
                    <div class="col-md-6 text-center mb-n5 d-none d-md-block">
                        <img class="img-fluid mt-5" style="height: 250px;" src="{{asset('/frontend/img/newsletter.png')}}">
                    </div>
                </div>
            </div>
        </div>
        <!-- Newsletter End -->


        <!-- Service Start -->
        <div class="container-xxl py-5">
            <div class="container px-lg-5">
                <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="position-relative d-inline text-primary ps-4">Our Services</h6>
                    <h2 class="mt-2">What Solutions We Provide</h2>
                </div>

                <div class="row g-4">

                   @foreach($service as $row)
                      <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.1s">
                         <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                            <div class="service-icon flex-shrink-0">
                                <i class="fa fa-home fa-2x"></i>
                            </div>
                            <h5 class="mb-3"> {{$row->title}} </h5>
                            <p>{{$row->short_desc}}</p>
                            <a class="btn px-3 mt-auto mx-auto" href="{{$row->link}}"> Read More </a>
                         </div>
                     </div>
                    @endforeach
                 
                 
                </div>
            </div>
        </div>
        <!-- Service End -->


        <!-- Portfolio Start -->
        <div class="container-xxl py-5">
            <div class="container px-lg-5">
                <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="position-relative d-inline text-primary ps-4">Our Projects</h6>
                    <h2 class="mt-2">Recently Launched Projects</h2>
                </div>
                <div class="row mt-n2 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="col-12 text-center">
                
                    </div>
                </div>

          
        <div class="row g-4 container">
            @foreach($project as $row)
                    <div class="col-lg-4 col-md-6 portfolio-item  wow zoomIn" data-wow-delay="0.1s">
                        <div class="position-relative rounded overflow-hidden">
                            <img class="img-fluid w-100" src="{{ asset('/uploads/admin/'.$row->image) }}" alt="">
                            <div class="portfolio-overlay">
                                <a class="btn btn-light" href="{{ asset('/uploads/admin/'.$row->image) }}" data-lightbox="portfolio"><i class="fa fa-plus fa-2x text-primary"></i></a>
                                <div class="mt-auto">
                                    <small class="text-white"><i class="fa fa-folder me-2"></i> {{$row->title}} </small>
                                    <a class="h5 d-block text-white mt-1 mb-0" href="{{$row->link}}"> More Details </a>
                               </div>
                          </div>
                     </div>
                 </div>
              @endforeach     

                  
                   

                </div>
            </div>
        </div>
        <!-- Portfolio End -->

        <!-- Testimonial Start -->
        <div class="container-xxl bg-primary testimonial py-5 my-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container py-5 px-lg-5">
                <div class="owl-carousel testimonial-carousel">

                  
                 @foreach($testimonial as $row)
                     <div class="testimonial-item bg-transparent border rounded text-white p-4">
                         <i class="fa fa-quote-left fa-2x mb-3"></i>
                         <p> {{$row->short_desc}}</p>
                         <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded-circle" src="{{ asset('/uploads/admin/'.$row->image) }}" style="width: 50px; height: 50px;">
                            <div class="ps-3">
                                <h6 class="text-white mb-1">{{$row->title}}</h6>
                                <small>{{$row->link}}</small>
                            </div>
                          </div>
                       </div>
                   @endforeach   
                   
                </div>
            </div>
        </div>
        <!-- Testimonial End -->


      
@endsection 


