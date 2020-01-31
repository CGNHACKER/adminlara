<template> 
    <div>
        <div class="container">
                <div class="row mt-5" v-if="$gate.isAdminOrApprover()">
                <div class="col-12">
                    <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Department Lists</h3>

                        <div class="card-tools">
                            <button class="btn btn-primary"  @click="ModalCreateDepartment()">Create Department</button>
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
                                <th>สถานะ</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="department in departments.data" :key="department.id">
                            <td>{{department.id}}</td>
                            <td>{{department.name_th}}</td>
                            <td>{{department.name_en | upText}}</td>
                            <td v-if="department.is_active === '1'" style="color:green;">ใช้งาน</td>
                            <td v-else style="color:red;">ไม่ใช้งาน</td>
                            <td>
                                <a href="#" @click="ModalEditDepartment(department)">
                                    <i class="fas fa-edit"></i>
                                </a>
                                /
                                <a href="#" @click="DeleteDepartment(department.id)">
                                    <i class="fas fa-trash red"></i>
                                </a>
                            </td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="departments" @pagination-change-page="getResults"></pagination>
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
                  <h4 v-if="editmode" class="modal-title">Update Department</h4>
                  <h4 v-if="!editmode" class="modal-title">Create Department</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                  </button>
                  </div>
                  <form @submit.prevent="editmode ? EditDepartment() : CreateDepartment()">
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
        name : 'department',
        data() {
            return {
                editmode : false,
                departments : {},
                form : new Form({
                    id : 0,
                    name_th : '',
                    name_en : '',
                    is_active : '',
                })
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods :{
            getResults(page = 1){
                axios.get('api/department?page=' + page)
                    .then(response => {
                        this.departments = response.data;
                    });
            },
            EditDepartment(){
                this.$Progress.start(); 

                this.form.put('api/department/'+this.form.id)
                .then(() => {
                    $('#modal-default').modal('hide')

                    toast.fire({
                        icon : 'success',
                        title : "Update Role Success !"
                    });

                    this.$Progress.finish()
                    fire.$emit('aftercreate')
                })
                .catch(() => {
                    this.$Progress.fail(); 
                })
            },
            ModalCreateDepartment(){
                this.editmode = false
                this.form.reset()
                $('#modal-default').modal('show')
            },
            ModalEditDepartment(departments){
                this.editmode = true
                this.form.reset()
                $('#modal-default').modal('show')
                this.form.fill(departments)
            },
            CreateDepartment(){
                this.$Progress.start()

                this.form.post('api/department')
                .then(() =>{
                    fire.$emit('aftercreate')
                    $('#modal-default').modal('hide')

                    toast.fire({
                        icon : 'success',
                        title : "Create Department Success !"
                    });

                    this.$Progress.finish()
                })
                .catch(() => {
                    this.$Progress.fail(); 
                });
            },
            LoadDepartment(){
                if(this.$gate.isAdminOrApprover){
                    axios.get('api/department').then(response => {
                        this.departments = response.data
                    });
                }
            },

            DeleteDepartment(id){
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
                    this.form.delete('api/department/'+id).then(() => {
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

            this.LoadDepartment()
            fire.$on('aftercreate',() => {
                this.LoadDepartment()
            });
            // fetch data every 3 second
            // setInterval(() => this.LoadUsers(),3000)
        }
    }
</script>
