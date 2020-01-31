<template>
    <div>
        <div class="container">
                <div class="row mt-5" v-if="$gate.isAdminOrApprover()">
                <div class="col-12">
                    <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Holiday Lists</h3>

                        <div class="card-tools">
                            <button class="btn btn-primary"  @click="ModalCreateHoliday()">Create Holiday</button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>รหัส</th>
                                <th>ชื่อภาษาไทย</th>
                                <th>ชื่อภาษาอังกฤษ</th>
                                <th>วัน</th>
                                <th>สถานะ</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="holiday in holidays.data" :key="holiday.id">
                            <td>{{holiday.id}}</td>
                            <td>{{holiday.name_th}}</td>
                            <td>{{holiday.name_en | upText}}</td>
                            <td>{{holiday.holiday_date | myDate}}</td>
                            <td v-if="holiday.is_active === '1'" style="color:green;">ใช้งาน</td>
                            <td v-else style="color:red;">ไม่ใช้งาน</td>
                            <td>
                                <a href="#" @click="ModalEditHoliday(holiday)">
                                    <i class="fas fa-edit"></i>
                                </a>
                                /
                                <a href="#" @click="DeleteHoliday(holiday.id)">
                                    <i class="fas fa-trash red"></i>
                                </a>
                            </td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="holidays" @pagination-change-page="getResults"></pagination>
                    </div>
                    </div>
                    <!-- /.card -->
                </div>
                </div>
        </div>

         <div class="modal fade" id="modal-default" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                  <h4 v-if="editmode" class="modal-title">Update Holiday</h4>
                  <h4 v-if="!editmode" class="modal-title">Create Holiday</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                  </button>
                  </div>
                  <form @submit.prevent="editmode ? EditHoliday() : CreateHoliday()">
                    <div class="modal-body">

                      <div class="form-group">
                          <label>Name TH</label>
                          <input v-model="form.name_th" type="text" name="name_th"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('name_th') }">
                          <has-error :form="form" field="name_th"></has-error>
                        </div>

                        <div class="form-group">
                          <label>Name EN</label>
                          <input v-model="form.name_en" type="text" name="name_en"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('name_en') }">
                          <has-error :form="form" field="name_en"></has-error>
                        </div>

                        <div class="form-group">
                          <label>Holiday</label>
                          <input type="date" name="holiday_date" id="holiday_date" v-model="form.holiday_date" class="form-control" :class="{ 'is_invalid' : form.errors.has('holiday_date')}">
                          <has-error :form="form" field="holiday_date"></has-error>
                        </div>

                        <div class="form-group">
                          <label>Active</label>
                          <select name="is_active" id="is_active" v-model="form.is_active" class="form-control" :class="{ 'is_invalid' : form.errors.has('is_active')}">
                            <option value="1">Active</option>
                            <option value="0">Not Active</option>
                          </select>
                          <has-error :form="form" field="is_active"></has-error>
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
    export default {
        name : 'holiday',
        data() {
            return {
                editmode : false,
                holidays : {},
                form : new Form({
                    id : 0,
                    name_th : '',
                    name_en : '',
                    holiday_date : '',
                    is_active : '',
                })
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods :{
            getResults(page = 1){
                axios.get('api/holiday?page=' + page)
                    .then(response => {
                        this.holidays = response.data;
                    });
            },
            EditHoliday(){
                this.$Progress.start(); 

                this.form.put('api/holiday/'+this.form.id)
                .then(() => {
                    $('#modal-default').modal('hide')

                    toast.fire({
                        icon : 'success',
                        title : "Update Holiday Success !"
                    });

                    this.$Progress.finish()
                    fire.$emit('aftercreate')
                })
                .catch(() => {
                    this.$Progress.fail(); 
                })
            },
            ModalCreateHoliday(){
                this.editmode = false
                this.form.reset()
                $('#modal-default').modal('show')
            },
            ModalEditHoliday(holidays){
                this.editmode = true
                this.form.reset()
                $('#modal-default').modal('show')
                this.form.fill(holidays)
            },
            CreateHoliday(){
                this.$Progress.start()

                this.form.post('api/holiday')
                .then(() =>{
                    fire.$emit('aftercreate')
                    $('#modal-default').modal('hide')

                    toast.fire({
                        icon : 'success',
                        title : "Create Holiday Success !"
                    });

                    this.$Progress.finish()
                })
                .catch(() => {
                    this.$Progress.fail(); 
                });
            },
            LoadHoliday(){
                if(this.$gate.isAdminOrApprover){
                    axios.get('api/holiday').then(response => {
                        this.holidays = response.data
                    });
                }
            },

            DeleteHoliday(id){
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if(result.value){
                    this.form.delete('api/holiday/'+id).then(() => {
                            swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                        fire.$emit('aftercreate')
                    }).catch(() => {
                        swal.fire({
                            icon : 'warning',
                            title : 'Delete Fail'
                        })
                    });
                    }
                }).catch(() => {
                    swal.fire({
                        icon : 'warning',
                        title : 'Delete Fail'
                    })
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

            this.LoadHoliday()
            fire.$on('aftercreate',() => {
                this.LoadHoliday()
            });
            // fetch data every 3 second
            // setInterval(() => this.LoadUsers(),3000)
        }
    }
</script>
