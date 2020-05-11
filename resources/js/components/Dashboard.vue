<template>
    <div>
        <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard</h1>
            </div>
            <!-- <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard v1</li>
                </ol>
            </div> -->
            </div>
        </div>
        </div>

        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{leave_used}}/{{leave_all}}</h3>

                        <p>วันลากิจ</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-book"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{sick_leave_used}}/{{sick_leave_all}}</h3>

                        <p>วันลาป่วย</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-medkit"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{holiday_leave_used}}/{{holiday_leave_all}}</h3>

                        <p>วันลาพักร้อน</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-battery-quarter"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{waitforconfirm}}</h3>

                        <p>จำนวนการลารออนุมัติ</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-list"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-7 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                                กิจกรรมล่าสุด
                            </h3>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <ul class="todo-list" data-widget="todo-list" v-if="datalength > 0">
                                <li v-for="lastactivity in lastactivitys.data" :key="lastactivity.id">
                                    <span class="handle">
                                        <i class="fas fa-ellipsis-v"></i>
                                        <i class="fas fa-ellipsis-v"></i>
                                    </span>
                                    <span class="text">{{lastactivity.activity_description}}</span>
                                    <small v-if="lastactivity.activity_code === 2001 " class="badge badge-success"><i class="fa fa-clock"></i> {{lastactivity.created_at | formatdateago}}</small>
                                    <small v-else-if="lastactivity.activity_code === 2002 " class="badge badge-danger"><i class="fa fa-clock"></i> {{lastactivity.created_at | formatdateago}}</small>
                                    <div class="tools">
                                        <i class="fa fa-edit"></i>
                                        <i class="fa fa-trash-o"></i>
                                    </div>
                                </li>
                            </ul>
                            <ul v-else>
                                <li class="todo-list" data-widget="todo-list" align="center">
                                    ไม่มีการแจ้งเตือน
                                </li>
                            </ul>

                            <div class="card-footer">
                                <pagination :data="lastactivitys" @pagination-change-page="getResults"></pagination>
                            </div>

                        </div>
                    </div><!-- /.card-body -->
                    <!-- /.card -->

                </section>
                <!-- /.Left col -->
                <!-- right col (We are only adding the ID to make the widgets sortable)-->
                <section class="col-lg-5 connectedSortable">

                    <!-- Map card -->
                    <div class="card bg-gradient-primary">
                    <div class="card-header border-0">
                        <h3 class="card-title">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        อีเมล์ที่ได้รับ
                        </h3>
                        <!-- card tools -->
                        <div class="card-tools">
                        <button type="button"
                                class="btn btn-primary btn-sm daterange"
                                data-toggle="tooltip"
                                title="Date range">
                            <i class="fa fa-calendar-alt"></i>
                        </button>
                        <button type="button"
                                class="btn btn-primary btn-sm"
                                data-card-widget="collapse"
                                data-toggle="tooltip"
                                title="Collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <div class="card-body">
                        <div id="world-map" style="height: 250px; width: 100%;"></div>
                    </div>
                    <!-- /.card-body-->
                    <div class="card-footer bg-transparent">
                        <div class="row">
                        <div class="col-4 text-center">
                            <div id="sparkline-1"></div>
                            <div class="text-white">Visitors</div>
                        </div>
                        <!-- ./col -->
                        <div class="col-4 text-center">
                            <div id="sparkline-2"></div>
                            <div class="text-white">Online</div>
                        </div>
                        <!-- ./col -->
                        <div class="col-4 text-center">
                            <div id="sparkline-3"></div>
                            <div class="text-white">Sales</div>
                        </div>
                        <!-- ./col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    </div>
                    <!-- /.card -->

                    <!-- /.card -->

                    <!-- Calendar -->
                    <div class="card bg-gradient-success">
                    <div class="card-header border-0">

                        <h3 class="card-title">
                        <i class="far fa-calendar-alt"></i>
                        Calendar
                        </h3>
                        <!-- tools card -->
                        <div class="card-tools">
                        <!-- button with a dropdown -->
                        <div class="btn-group">
                            <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-bars"></i></button>
                            <div class="dropdown-menu float-right" role="menu">
                            <a href="#" class="dropdown-item">Add new event</a>
                            <a href="#" class="dropdown-item">Clear events</a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">View calendar</a>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body pt-0">
                        <!--The calendar -->
                        <div id="calendar" style="width: 100%"></div>
                    </div>
                    <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </section>
                <!-- right col -->
            </div>
            <!-- /.row (main row) -->
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return{
                sick_leave_all : 0,
                sick_leave_used : 0,
                leave_all : 0,
                leave_used : 0,
                holiday_leave_all : 0,
                holiday_leave_used : 0,
                waitforconfirm : 0,
                lastactivitys : {},
                datalength : 0
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods : {
            getResults(page = 1){
            axios.get('api/lastactivity?page=' + page)
                .then(response => {
                    this.lastactivitys = response.data.lastactivity;
                });
            },
            LoadDashboard(){
                axios.get('api/dashboard')
                    .then((response) => {
                        if(response.status == '200'){
                            this.leave_used = response.data.CountLeaveByUser.leave != null ? response.data.CountLeaveByUser.leave : 0
                            this.sick_leave_used = response.data.CountLeaveByUser.sick_leave != null ? response.data.CountLeaveByUser.sick_leave : 0
                            this.holiday_leave_used = response.data.CountLeaveByUser.holiday_leave != null ? response.data.CountLeaveByUser.holiday_leave : 0 
                            this.sick_leave_all = response.data.CountMaxLeave[0].leave_unit
                            this.leave_all = response.data.CountMaxLeave[2].leave_unit
                            this.holiday_leave_all = response.data.CountMaxLeave[1].leave_unit

                            this.waitforconfirm = response.data.CountWaitForConfirm

                        }else{
                            console.log('dddd')
                        }
                    })
                    .catch(() => {
                        console.log('sss')
                    });

            },
            LoadLastActivity(){
                axios.get('api/lastactivity')
                     .then((response) => {
                         this.lastactivitys = response.data.lastactivity
                         this.datalength = this.lastactivitys.data.length
                     })
                     .catch(() => {

                     })
            }
        },
        async created() {
            await this.LoadDashboard()
            await this.LoadLastActivity()
        }
    }
</script>
