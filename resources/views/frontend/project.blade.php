@extends('frontend.layout')
@section('page_title','Admin Panel')
@section('project','active')
@section('content')

<div class="container-xxl py-5 bg-primary hero-header mb-5">
                <div class="container my-5 py-5 px-lg-5">
                    <div class="row g-5 py-5">
                        <div class="col-12 text-center">
                            <h1 class="text-white animated zoomIn">Project </h1>
                            <hr class="bg-white mx-auto mt-0" style="width: 90px;">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb justify-content-center">
                                    <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                                    <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                                    <li class="breadcrumb-item text-white active" aria-current="page">Project</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
         </div>

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


      

      
@endsection 


