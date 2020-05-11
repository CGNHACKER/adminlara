<template>
    <div>
        <div class="container">
                <!-- <div class="row mt-5" v-if="$gate.isAdminOrApprover()"> -->
                    <div class="col-12">
                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">จัดการการลา</h3>

                            <div class="card-tools">
                                <button class="btn btn-primary"  @click="ModalCreateLeave">เพิ่มการลา</button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>กลุ่มผู้อนุมัติ</th>
                                    <th>ผู้ขอลา</th>
                                    <th>จำนวนวันที่ลา</th>
                                    <th>ประเภทการลา</th>
                                    <th>วันเริ่มลา</th>
                                    <th>วันสิ้นสุดลา</th>
                                    <th>สถานะการอนุมัติ</th>
                                    <th>จัดการ</th>
                                </tr>
                            </thead>
                            <tbody v-if="datalength > 0">
                                <tr v-for="leave in leaves.data" :key="leave.id">
                                    <td>{{leave.role_name_th}}</td>
                                    <td>{{leave.name}}</td>
                                    <td>{{leave.date_of_leave}}</td>
                                    <td>{{leave.name_th}}</td>
                                    <td>{{leave.leave_start | myDate}}</td>
                                    <td>{{leave.leave_end | myDate}}</td>

                                    <td v-if="$gate.user.role_id !== leave.approve_by_role_id && leave.is_accept === '0'" style="color:blue;">รอการอนุมัติ</td>
                                    <td v-else-if="leave.is_accept === '0' " style="color:blue;cursor:pointer;"  @click="ConfirmLeave(leave.id)">รอการอนุมัติ</td>
                                    <td v-else-if="leave.is_accept === '1' " style="color:green;">อนุมัติแล้ว</td>
                                    <td v-else-if="leave.is_accept === '2' " style="color:red;">ไม่อนุมัติ</td>
                                    
                                    <td>
                                        <a href="#" @click="ModalEditLeave(leave)" v-if="leave.is_accept === '0'">
                                            <i class="fas fa-edit"></i>|
                                        </a>
                                        
                                        <a href="#" @click="DeleteLeave(leave.id)" v-if="leave.is_accept === '0'">
                                            <i class="fas fa-trash red"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>

                            <tbody v-else>
                                <tr align="center">
                                    <td colspan="8">ไม่มีข้อมูล</td>
                                </tr>
                            </tbody>

                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <pagination :data="leaves" @pagination-change-page="getResults"></pagination>
                        </div>
                        </div>
                        <!-- /.card -->
                    </div>
                <!-- </div> -->
        </div>

         <div class="modal fade" id="modal-default" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                  <h4 v-if="editmode" class="modal-title">Update Leave</h4>
                  <h4 v-if="!editmode" class="modal-title">Create Leave</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                  </button>
                  </div>
                  <form @submit.prevent="editmode ? EditLeave() : CreateLeave()">
                    <div class="modal-body">

                        <div class="form-group">
                          <label>Approve by role</label>
                          <select name="approve_by_role_id" id="approve_by_role_id" v-model="form.approve_by_role_id" class="form-control" :class="{ 'is-invalid' : form.errors.has('approve_by_role_id')}">
                            <option v-for="role in roles" :value="role.id">{{role.role_name_th}}</option>
                          </select>
                          <has-error :form="form" field="approve_by_role_id"></has-error>
                        </div>

                        <div class="form-group">
                          <label>Leave Reason</label>
                          <textarea class="form-control" name="reason_leave"  v-model="form.reason_leave" cols="30" rows="5" :class="{ 'is-invalid' : form.errors.has('reason_leave')}"></textarea>
                          <has-error :form="form" field="reason_leave"></has-error>
                        </div>
                        
                        <div class="form-group">
                          <label>Leave Category</label>
                          <select name="leave_category_id" v-model="form.leave_category_id" class="form-control" :class="{ 'is-invalid' : form.errors.has('leave_category_id')}">
                            <option v-for="leavecategory in leavecategorys" :value="leavecategory.id">{{leavecategory.name_th}}</option>
                          </select>
                          <has-error :form="form" field="leave_category_id"></has-error>
                        </div>
                        
                        <div class="form-group">
                          <label>Leave Start</label>
                          <datepicker  @selected="CheckDisableDate" :language="th" :format="customFormatter" :disabled-dates="disabledDates" v-model="form.leave_start" name="leave_start" :class="{ 'is-invalid' : form.errors.has('leave_start')}"></datepicker>
                          <has-error :form="form" field="leave_start"></has-error>
                        </div>

                        <div class="form-group">
                          <label>Leave End</label>
                          <datepicker  @selected="disableFrom" :language="th" :format="customFormatter" :disabled-dates="disabledDates" v-model="form.leave_end" name="leave_end" :class="{ 'is-invalid' : form.errors.has('leave_end')}"></datepicker>
                          <has-error :form="form" field="leave_end"></has-error>
                        </div>

                    </div>

                    <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button v-show="editmode" type="submit" class="btn btn-primary">Update</button>
                    <button v-show="!editmode" type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </form>
              </div>
            </div>
        </div>
    </div>
</template>

<script>
import Datepicker from 'vuejs-datepicker';
import moment from 'moment'
import {th} from 'vuejs-datepicker/dist/locale'
import { Form, HasError, AlertError } from 'vform'

    export default {
        name : 'leave',
        components : {
            Datepicker
        },
        data() {
            return {
                th: th,
                editmode : false,
                leaves : {},
                leavecategorys : {},
                roles : {},
                datalength : 0,
                form : new Form({
                    id : 0,
                    approve_by_role_id : 0,
                    user_id : 0,
                    reason_leave : '',
                    date_of_leave : '',
                    holiday_of_leave : '',
                    leave_category_id : 0,
                    leave_start : '',
                    leave_end : '',
                    is_active : 0,
                    is_accept_by_user_id : 0,
                    status_confirm_date : 0
                }),
                disabledDates: {},
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods :{
            ConfirmLeave(leave_id){
                swal.fire({
                    title: 'ยืนยัน',
                    text: "ต้องการอนุมัติการลาหรือไม่",
                    icon: 'question',
                    animation : false,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText :'ไม่อนุมัติ',
                    confirmButtonText: 'อนุมัติ',
                    footer: '<a href="#" onclick="swal.close();">ยกเลิก</a>'
                }).then((result) => {
                    if (result.value) {

                        axios.post('api/leaveconfirm',{id : leave_id,is_accept : '1'})
                        .then(() => {
                            toast.fire({
                                icon : 'success',
                                title : "อัพเดทสถานะเรียบร้อยแล้ว"
                            });
                        })
                        .catch(() => {
                            toast.fire({
                                icon : 'warning',
                                title : "ระบบมีปัญหา กรุณาลองใหม่อีกครั้ง"
                            });
                        })
                        fire.$emit('aftercreate')
                    }else if(result.dismiss){
                        axios.post('api/leaveconfirm',{id : leave_id,is_accept : '2'})
                        .then(() => {
                            toast.fire({
                                icon : 'success',
                                title : "อัพเดทสถานะเรียบร้อยแล้ว"
                            });
                        })
                        .catch(() => {
                            toast.fire({
                                icon : 'warning',
                                title : "ระบบมีปัญหา กรุณาลองใหม่อีกครั้ง"
                            });
                        })
                    }
                })

            },
            CheckHolidayDisable(event) {
                // axios.get('api/holiday')
                // .then((response) => {
                //     var date = '2020-01-31'
                //     this.disabledDates.dates = [new Date(2020,0,16)]
                //     console.log(moment(date).format());

                // })
            },
            CheckDisableDate(val) {
                if (typeof this.disabledDates.to === 'undefined') {
                    this.disabledDates = {
                        to: null,
                        daysOfMonth: this.disabledDates.daysOfMonth,
                        from:this.disabledDates.from,
                        dates : this.disabledDates.dates,
                        days : this.disabledDates.days
                    }
                }
                this.disabledDates.to = val
            },
            disableFrom (val) {
                // if (typeof this.disabledDates.from === 'undefined') {
                //     this.disabledDates = {
                //         to: this.disabledDates.to,
                //         daysOfMonth: this.disabledDates.daysOfMonth,
                //         from: null
                //     }
                // }
                // this.disabledDates.from = val
            },
            customFormatter(date) {
                moment.locale('th');
                return moment(date).format('MMMM Do YYYY');
            },
            getResults(page = 1){
                axios.get('api/leave?page=' + page)
                    .then(response => {
                        this.leaves = response.data;
                    });
            },
            EditLeave(){
                this.$Progress.start(); 

                this.form.put('api/leave/'+this.form.id)
                .then(() => {
                    $('#modal-default').modal('hide')

                    toast.fire({
                        icon : 'success',
                        title : "Update Leave Success !"
                    });

                    this.$Progress.finish()
                    fire.$emit('aftercreate')
                })
                .catch(() => {
                    this.$Progress.fail(); 
                })
            },
            ModalCreateLeave(){
                this.editmode = false
                this.form.reset()
                $('#modal-default').modal('show')
            },
            ModalEditLeave(leaves){
                this.editmode = true
                this.form.reset()
                $('#modal-default').modal('show')
                this.form.fill(leaves)
            },
            CreateLeave(){
                this.$Progress.start()

                this.form.post('api/leave')
                .then(() =>{
                    fire.$emit('aftercreate')
                    $('#modal-default').modal('hide')

                    toast.fire({
                        icon : 'success',
                        title : "Create Leave Success !"
                    });

                    this.$Progress.finish()
                })
                .catch(() => {
                    this.$Progress.fail(); 
                });
            },
            LoadLeave(){
                if(this.$gate.isAdminOrApprover){
                    axios.get('api/leave').then(response => {
                        this.leaves = response.data.leave
                        this.datalength = this.leaves.data.length
                        this.leavecategorys = response.data.leavecategory
                        this.roles = response.data.role
                        let HolidayLoop = Array()
                        for(var i=0;i < response.data.holidayconfig.length;i++){
                            HolidayLoop[i] = new Date(response.data.holidayconfig[i].holiday_date)
                        }

                        this.disabledDates = {
                            dates : HolidayLoop,
                            days: [6, 0],
                            to : new Date()
                        }
                    });
                }
            },
            DeleteLeave(id){
                swal.fire({
                    title: 'ลบข้อมูล',
                    text: "ยืนยันการลบข้อมูลหรือไม่",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if(result.value){
                    this.form.delete('api/leave/'+id).then(() => {

                        toast.fire({
                            icon : 'success',
                            title : "ลบข้อมูลเรียบร้อยแล้ว"
                        });

                        fire.$emit('aftercreate')
                    }).catch(() => {
                        toast.fire({
                            icon : 'warning',
                            title : "ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง"
                        });
                    });
                    }
                }).catch(() => {
                        toast.fire({
                            icon : 'warning',
                            title : "ไม่สามารถลบข้อมูลได้ กรุณาลองใหม่อีกครั้ง"
                        });
                });
            }
        },
        created() {
            fire.$on('Searching', () => {
            let query = this.$parent.search;

            axios.get('api/FindUser?q='+query)
                .then((response) => {
                    this.users = response.data
                })
                .catch(() => {

                });
            });

            this.LoadLeave()
            fire.$on('aftercreate',() => {
                this.LoadLeave()
            });
            // fetch data every 3 second
            // setInterval(() => this.LoadUsers(),3000)
        }
    }
</script>
