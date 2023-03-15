@extends('layouts.master')
@section('title')
@endsection
@section('content')
	<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
	    <div class="col">
	        <div class="card radius-10 border-start border-0 border-3 border-info">
	            <div class="card-body">
	                <div class="d-flex align-items-center">
	                    <div>
	                        <p class="mb-0 text-secondary">Total Experts</p>
	                        <h4 class="my-1 text-info">{{ \App\Models\Expert::count()}}</h4>
	                        <p class="mb-0 font-13"></p>
	                    </div>
	                    <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i
	                            class='bx bxs-group'></i>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="col">
	        <div class="card radius-10 border-start border-0 border-3 border-danger">
	            <div class="card-body">
	                <div class="d-flex align-items-center">
	                    <div>
	                        <p class="mb-0 text-secondary">Total Farmers</p>
	                        <h4 class="my-1 text-danger">{{ \App\Models\Farmer::count()}}</h4>
	                        <p class="mb-0 font-13"></p>
	                    </div>
	                    <div class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto"><i
	                            class='bx bxs-group'></i>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="col">
	        <div class="card radius-10 border-start border-0 border-3 border-success">
	            <div class="card-body">
	                <div class="d-flex align-items-center">
	                    <div>
	                        <p class="mb-0 text-secondary">Total Questions</p>
	                        <h4 class="my-1 text-success">{{ \App\Models\Question::count()}}</h4>
	                        <p class="mb-0 font-13"></p>
	                    </div>
	                    <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i
	                            class='bx bxs-bar-chart-alt-2'></i>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="col">
	        <div class="card radius-10 border-start border-0 border-3 border-warning">
	            <div class="card-body">
	                <div class="d-flex align-items-center">
	                    <div>
	                        <p class="mb-0 text-secondary">Total Crops</p>
	                        <h4 class="my-1 text-warning">{{ \App\Models\Crop::count()}}</h4>
	                        <p class="mb-0 font-13"></p>
	                    </div>
	                    <div class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto"><i
	                            class='bx bx-donate-blood'></i>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

	<div class="row">
	    <div class="col-12 col-lg-8">
	        <div class="card radius-10">
	            <div class="card-body">
	                <div class="d-flex align-items-center">
	                    <div>
	                        <h6 class="mb-0">Monthly Questions</h6>
	                    </div>
	                    <div class="dropdown ms-auto">
	                        <a class="dropdown-toggle dropdown-toggle-nocaret" href="#"
	                            data-bs-toggle="dropdown"><i
	                                class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
	                        </a>
	                        <ul class="dropdown-menu">
	                            <li><a class="dropdown-item" href="javascript:;">Action</a>
	                            </li>
	                            <li><a class="dropdown-item" href="javascript:;">Another action</a>
	                            </li>
	                            <li>
	                                <hr class="dropdown-divider">
	                            </li>
	                            <li><a class="dropdown-item" href="javascript:;">Something else here</a>
	                            </li>
	                        </ul>
	                    </div>
	                </div>
	                <div class="d-flex align-items-center ms-auto font-13 gap-2 my-3">
	                    <span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1"
	                            style="color: #14abef"></i>Questions</span>
	                    
	                </div>
	                <div class="chart-container-1">
	                    <canvas id="chart1"></canvas>
	                </div>
	            </div>
	           {{--  <div class="row row-cols-1 row-cols-md-3 row-cols-xl-3 g-0 row-group text-center border-top">
	                <div class="col">
	                    <div class="p-3">
	                        <h5 class="mb-0">24.15M</h5>
	                        <small class="mb-0">Overall Visitor <span> <i
	                                    class="bx bx-up-arrow-alt align-middle"></i> 2.43%</span></small>
	                    </div>
	                </div>
	                <div class="col">
	                    <div class="p-3">
	                        <h5 class="mb-0">12:38</h5>
	                        <small class="mb-0">Visitor Duration <span> <i
	                                    class="bx bx-up-arrow-alt align-middle"></i> 12.65%</span></small>
	                    </div>
	                </div>
	                <div class="col">
	                    <div class="p-3">
	                        <h5 class="mb-0">639.82</h5>
	                        <small class="mb-0">Pages/Visit <span> <i class="bx bx-up-arrow-alt align-middle"></i>
	                                5.62%</span></small>
	                    </div>
	                </div>
	            </div> --}}
	        </div>
	    </div>
	    <div class="col-12 col-lg-4">
	        <div class="card radius-10">
	            <div class="card-body">
	                <div class="d-flex align-items-center">
	                    <div>
	                        <h6 class="mb-0">Top Experts by Answers</h6>
	                    </div>
	                    <div class="dropdown ms-auto">
	                        <a class="dropdown-toggle dropdown-toggle-nocaret" href="#"
	                            data-bs-toggle="dropdown"><i
	                                class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
	                        </a>
	                        <ul class="dropdown-menu">
	                            <li><a class="dropdown-item" href="javascript:;">Action</a>
	                            </li>
	                            <li><a class="dropdown-item" href="javascript:;">Another action</a>
	                            </li>
	                            <li>
	                                <hr class="dropdown-divider">
	                            </li>
	                            <li><a class="dropdown-item" href="javascript:;">Something else here</a>
	                            </li>
	                        </ul>
	                    </div>
	                </div>
	                <div class="chart-container-2 mt-4">
	                    <canvas id="chart2"></canvas>
	                </div>
	            </div>
	           
	            <ul class="list-group list-group-flush">
	                {{-- <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
	                    Corn <span class="badge bg-success rounded-pill">25</span>
	                </li>
	                <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
	                    Wheat <span class="badge bg-danger rounded-pill">10</span>
	                </li> --}}
	                
	            </ul>
	        </div>
	    </div>
	</div>

	{{-- <div class="row row-cols-1 row-cols-lg-3">
	    <div class="col d-flex">
	        <div class="card radius-10 w-100">
	            <div class="card-body">
	                <p class="font-weight-bold mb-1 text-secondary">Weekly Revenue</p>
	                <div class="d-flex align-items-center mb-4">
	                    <div>
	                        <h4 class="mb-0">$89,540</h4>
	                    </div>
	                    <div class="">
	                        <p class="mb-0 align-self-center font-weight-bold text-success ms-2">4.4% <i
	                                class="bx bxs-up-arrow-alt mr-2"></i>
	                        </p>
	                    </div>
	                </div>
	                <div class="chart-container-0">
	                    <canvas id="chart3"></canvas>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="col d-flex">
	        <div class="card radius-10 w-100">
	            <div class="card-header bg-transparent">
	                <div class="d-flex align-items-center">
	                    <div>
	                        <h6 class="mb-0">Orders Summary</h6>
	                    </div>
	                    <div class="dropdown ms-auto">
	                        <a class="dropdown-toggle dropdown-toggle-nocaret" href="#"
	                            data-bs-toggle="dropdown"><i
	                                class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
	                        </a>
	                        <ul class="dropdown-menu">
	                            <li><a class="dropdown-item" href="javascript:;">Action</a>
	                            </li>
	                            <li><a class="dropdown-item" href="javascript:;">Another action</a>
	                            </li>
	                            <li>
	                                <hr class="dropdown-divider">
	                            </li>
	                            <li><a class="dropdown-item" href="javascript:;">Something else here</a>
	                            </li>
	                        </ul>
	                    </div>
	                </div>
	            </div>
	            <div class="card-body">
	                <div class="chart-container-1">
	                    <canvas id="chart4"></canvas>
	                </div>
	            </div>
	            <ul class="list-group list-group-flush">
	                <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
	                    Completed <span class="badge bg-gradient-quepal rounded-pill">25</span>
	                </li>
	                <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
	                    Pending <span class="badge bg-gradient-ibiza rounded-pill">10</span>
	                </li>
	                <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
	                    Process <span class="badge bg-gradient-deepblue rounded-pill">65</span>
	                </li>
	            </ul>
	        </div>
	    </div>
	    <div class="col d-flex">
	        <div class="card radius-10 w-100">
	            <div class="card-header bg-transparent">
	                <div class="d-flex align-items-center">
	                    <div>
	                        <h6 class="mb-0">Top Selling Categories</h6>
	                    </div>
	                    <div class="dropdown ms-auto">
	                        <a class="dropdown-toggle dropdown-toggle-nocaret" href="#"
	                            data-bs-toggle="dropdown"><i
	                                class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
	                        </a>
	                        <ul class="dropdown-menu">
	                            <li><a class="dropdown-item" href="javascript:;">Action</a>
	                            </li>
	                            <li><a class="dropdown-item" href="javascript:;">Another action</a>
	                            </li>
	                            <li>
	                                <hr class="dropdown-divider">
	                            </li>
	                            <li><a class="dropdown-item" href="javascript:;">Something else here</a>
	                            </li>
	                        </ul>
	                    </div>
	                </div>
	            </div>
	            <div class="card-body">
	                <div class="chart-container-0">
	                    <canvas id="chart5"></canvas>
	                </div>
	            </div>
	            <div class="row row-group border-top g-0">
	                <div class="col">
	                    <div class="p-3 text-center">
	                        <h4 class="mb-0 text-danger">$45,216</h4>
	                        <p class="mb-0">Clothing</p>
	                    </div>
	                </div>
	                <div class="col">
	                    <div class="p-3 text-center">
	                        <h4 class="mb-0 text-success">$68,154</h4>
	                        <p class="mb-0">Electronic</p>
	                    </div>
	                </div>
	            </div>
	            <!--end row-->
	        </div>
	    </div>
	</div> --}}
	<!--end row-->
@endsection
@section('script')

<script type="text/javascript">
	// chart 1
	@php
		$users = \App\Models\Question::select('id', 'created_at')
				->get()
				->groupBy(function($date) {
				    //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
				    return \Carbon\Carbon::parse($date->created_at)->format('m'); // grouping by months
				});

				$usermcount = [];
				$userArr = [];

				foreach ($users as $key => $value) {
				    $usermcount[(int)$key] = count($value);
				}

				for($i = 1; $i <= 12; $i++){
				    if(!empty($usermcount[$i])){
				        $userArr[$i] = $usermcount[$i];    
				    }else{
				        $userArr[$i] = 0;    
				    }
				}

	@endphp

	 var users =  {{ Js::from($userArr) }};
	 var arr = $.map(users, function(value, key){
		    return value
		})
  var ctx = document.getElementById("chart1").getContext('2d');
   
  var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke1.addColorStop(0, '#6078ea');  
      gradientStroke1.addColorStop(1, '#17c5ea'); 
   
  var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke2.addColorStop(0, '#ff8359');
      gradientStroke2.addColorStop(1, '#ffdf40');

      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          datasets: [{
            label: 'Questions',
            data: arr,
            borderColor: gradientStroke1,
            backgroundColor: gradientStroke1,
            hoverBackgroundColor: gradientStroke1,
            pointRadius: 0,
            fill: false,
            borderWidth: 0
          }]
        },
		
		options:{
		  maintainAspectRatio: false,
		  legend: {
			  position: 'bottom',
              display: false,
			  labels: {
                boxWidth:8
              }
            },
			tooltips: {
			  displayColors:false,
			},	
		  scales: {
			  xAxes: [{
				barPercentage: .5
			  }]
		     }
		}
      });
	  

	  @php
	  	$data = \App\Models\Answer::select('expert_id')->get()->groupBy('expert_id');
	  	
	  	$label = [];
	  	$count = [];

	  	foreach ($data as $key => $value) {
	  		$expert = \App\Models\Expert::where('id', $key)->first();

	  		if ($expert->expert_answer != null) {
	  			$count[] = $expert->expert_answer->count();
	  		}
	  		$label[] = $expert->name;	
	  	}

	  @endphp

	 var label =  {{ Js::from($label) }};
	 var count =  {{ Js::from($count) }};

// chart 2

 var ctx = document.getElementById("chart2").getContext('2d');

  var gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke1.addColorStop(0, '#fc4a1a');
      gradientStroke1.addColorStop(1, '#f7b733');

  var gradientStroke2 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke2.addColorStop(0, '#4776e6');
      gradientStroke2.addColorStop(1, '#8e54e9');


  var gradientStroke3 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke3.addColorStop(0, '#ee0979');
      gradientStroke3.addColorStop(1, '#ff6a00');
	  
	var gradientStroke4 = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStroke4.addColorStop(0, '#42e695');
      gradientStroke4.addColorStop(1, '#3bb2b8');

      var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: label,
          datasets: [{
            backgroundColor: [
              gradientStroke1,
              gradientStroke2,
              gradientStroke3,
              gradientStroke4
            ],
            hoverBackgroundColor: [
              gradientStroke1,
              gradientStroke2,
              gradientStroke3,
              gradientStroke4
            ],
            data: count,
			// borderWidth: [1, 1, 1, 1]
          }]
        },
        options: {
			maintainAspectRatio: false,
			cutoutPercentage: 75,
            legend: {
			  position: 'bottom',
              display: false,
			  labels: {
                boxWidth:8
              }
            },
			tooltips: {
			  displayColors:false,
			}
        }
      });

	 
</script>
@endsection
