@extends('layouts.master')
@section('tittle')
Dashboard
@endsection

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="?orderedToday">Today</a></li>
                    <li><a class="dropdown-item" href="{{ route('dashboard')}}">This Month</a></li>
                    <li><a class="dropdown-item" href="?orderedLastMonth">Last Month</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Ordered <span>| {{ $orderedTilte }}</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $numberOrderedInMonth }}</h6>
                      {{-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> --}}

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="?revenueToday">Today</a></li>
                    <li><a class="dropdown-item" href="{{ route('dashboard') }}">This Month</a></li>
                    <li><a class="dropdown-item" href="?revenueLastMonth">Last Month</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Revenue <span>| {{ $revenueTitle }}</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $revenueInMonth }}</h6>
                      {{-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> --}}

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="{{ route('dashboard') }}">This Month</a></li>
                    <li><a class="dropdown-item" href="?customerLastMonth">Last Month</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Customers <span>| {{ $newUserTitle }}</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $newUserInMonth }}</h6>
                      {{-- <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span> --}}

                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->

            <!-- Reports -->
            <div class="col-12">
              <div class="card">

                <div class="card-body">
                  <h5 class="card-title">Reports <span>/This Year</span></h5>

                  <!-- Line Chart -->
                  <div id="reportsChart"></div>

                  <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      new ApexCharts(document.querySelector("#reportsChart"), {
                        series: [{
                          name: 'Customer',
                          data: [
                            <?php 
                              if (empty($newUsers)) {
                                  echo '0';
                              } else {
                                  foreach ($newUsers as $newUsersItem) {
                                      echo "'$newUsersItem',";
                                  }
                              }
                            ?>
                          ],
                        }, 
                        {
                          name: 'User',
                          data: [
                            <?php 
                              if (empty($newRoleUser)) {
                                  echo '0';
                              } else {
                                  foreach ($newRoleUser as $newRoleUserItem) {
                                      echo "'$newRoleUserItem',";
                                  }
                              }
                            ?>
                          ]
                        }, 
                        {
                          name: 'Travel Suplier',
                          data: [
                            <?php 
                              if (empty($newRoleTs)) {
                                  echo '0';
                              } else {
                                  foreach ($newRoleTs as $newRoleTsItem) {
                                      echo "'$newRoleTsItem',";
                                  }
                              }
                            ?>
                          ]
                        }
                      ],
                        chart: {
                          height: 350,
                          type: 'area',
                          toolbar: {
                            show: false
                          },
                        },
                        markers: {
                          size: 4
                        },
                        colors: ['#4154f1', '#2eca6a', '#ff771d'],
                        fill: {
                          type: "gradient",
                          gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.3,
                            opacityTo: 0.4,
                            stops: [0, 90, 100]
                          }
                        },
                        dataLabels: {
                          enabled: false
                        },
                        stroke: {
                          curve: 'smooth',
                          width: 2
                        },
                        xaxis: {
                          type: 'string',
                          categories:  [
                                            <?php
                                                if (empty($monthAvaiable)) {
                                                    echo '0';
                                                } else {
                                                    foreach ($monthAvaiable as $monthAvaiableItem) {
                                                        echo "'$monthAvaiableItem',";
                                                    }
                                                }
                                                ?>
                                        ],
                        },
                      }).render();
                    });
                  </script>
                  <!-- End Line Chart -->

                </div>

              </div>
            </div><!-- End Reports -->

            <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="{{ route('dashboard') }}">This Month</a></li>
                    <li><a class="dropdown-item" href="?recentOrderLastMonth">Last Month</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Recent Ordered <span>| {{ $recentOrderedTitle }}</span></h5>

                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Tour</th>
                        <th scope="col">Tickets</th>
                        <th scope="col">Price</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($orderedsInMonth as $key => $orderedInMonth)
                        <tr>
                          <th scope="row"><a href="#">{{$key + 1}}</a></th>
                          <td>{{ $orderedInMonth->user_name }}</td>
                          <td><a href="#" class="text-primary">{{ $orderedInMonth->tour_name }}</a></td>
                          <td>{{ $orderedInMonth->tickets }}</td>
                          <td>{{ ($orderedInMonth->tickets * $orderedInMonth->price) + 0 }}</td>
                        </tr>
                      @endforeach
                      {{ $orderedsInMonth->links() }}
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Recent Sales -->

            <!-- Top Selling -->
            <div class="col-12">
              <div class="card top-selling overflow-auto">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="{{ route('dashboard') }}">This Month</a></li>
                    <li><a class="dropdown-item" href="?topOwnerLastMonth">Last Month</a></li>
                  </ul>
                </div>

                <div class="card-body pb-0">
                  <h5 class="card-title">Top Owner Has Most Booked Tour <span>| {{ $topOwnerTitle }}</span></h5>

                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">User</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Order Quantity</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($topUserWithMostBookedTour as $key => $topUserWithMostBookedTourValue)
                        <tr>
                          <th scope="row"><a href="#">{{$key + 1}}</a></th>
                          <td> <img src="{{ $topUserWithMostBookedTourValue->owner_avatar }}"></td>
                          <td><a href="#" class="text-primary">{{ $topUserWithMostBookedTourValue->owner_name }}</a></td>
                          <td>{{ $topUserWithMostBookedTourValue->owner_email }}</td>
                          <td>{{ $topUserWithMostBookedTourValue->phone_number }}</td>
                          <td>{{ $topUserWithMostBookedTourValue->amount }}</td>
                        </tr>
                      @endforeach
                      {{ $topUserWithMostBookedTour->links() }}
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Top Selling -->

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

          <!-- Recent Activity -->
          <div class="card">

            <div class="card-body">
              <h5 class="card-title">Recent Activity <span>| Today</span></h5>

              <div class="activity">

                @foreach ($psTourStartToday as $psTourStartTodayItem)
                  <div class="activity-item d-flex">
                    <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                    <div class="activity-content">
                      {{ $psTourStartTodayItem->name }} của {{ $psTourStartTodayItem->owner_name }} bất đầu đi ngày hôm nay
                    </div>
                </div><!-- End activity item-->
                @endforeach

                @foreach ($psTourEndToday as $psTourEndTodayItem)
                  <div class="activity-item d-flex">
                    <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                    <div class="activity-content">
                      {{ $psTourEndTodayItem->name }} của {{ $psTourEndTodayItem->owner_name }} sẽ kết thúc hôm nay
                    </div>
                  </div><!-- End activity item-->
                @endforeach

                @foreach ($orderedToday as $orderedTodayItem)
                  <div class="activity-item d-flex">
                    <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                    <div class="activity-content">
                      {{ $orderedTodayItem->user_name }} đã đặt {{ $orderedTodayItem->tour_name }} {{ $orderedTodayItem->tickets }} vé
                    </div>
                  </div><!-- End activity item-->
                @endforeach

                {{-- <div class="activity-item d-flex">
                  <div class="activite-label">1 day</div>
                  <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                  <div class="activity-content">
                    Tempore autem saepe <a href="#" class="fw-bold text-dark">occaecati voluptatem</a> tempore
                  </div>
                </div><!-- End activity item--> --}}

              </div>

            </div>
          </div><!-- End Recent Activity -->

          <!-- Website Traffic -->
          <div class="card">
            <div class="card-body pb-0">
              <h5 class="card-title">User Type</h5>

              <div id="trafficChart" style="min-height: 400px;" class="echart"></div>

              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  echarts.init(document.querySelector("#trafficChart")).setOption({
                    tooltip: {
                      trigger: 'item'
                    },
                    legend: {
                      top: '5%',
                      left: 'center'
                    },
                    series: [{
                      name: 'Access From',
                      type: 'pie',
                      radius: ['40%', '70%'],
                      avoidLabelOverlap: false,
                      label: {
                        show: false,
                        position: 'center'
                      },
                      emphasis: {
                        label: {
                          show: true,
                          fontSize: '18',
                          fontWeight: 'bold'
                        }
                      },
                      labelLine: {
                        show: false
                      },
                      data: [{
                          value: {{ $numberOfUser }},
                          name: 'User'
                        },
                        {
                          value: {{ $numberOfTs }},
                          name: 'Travel Supplier'
                        },
                      ]
                    }]
                  });
                });
              </script>

            </div>
          </div><!-- End Website Traffic -->

        </div><!-- End Right side columns -->

      </div>
    </section>

  </main><!-- End #main -->
@endsection