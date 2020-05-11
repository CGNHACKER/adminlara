<template>
    <div>
    <div class="container">
        <div class="row mt-5" v-if="$gate.isAdminOrApprover()">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Member Lists</h3>

                <div class="card-tools">
                    <button class="btn btn-primary"  @click="ModalCreateUser()">Create Member</button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Nickname</th>
                      <th>Position</th>
                      <th>Department</th>
                      <th>Role</th>
                      <th>Created</th>
                      <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>

                    <tr v-if="loading">
                      <td colspan="8" align="center"> Loading...</td>
                    </tr>

                    <tr v-if="users" v-for="user in users.data" :key="user.id">
                      <td>{{user.name}}</td>
                      <td>{{user.email}}</td>
                      <td>{{user.nickname}}</td>
                      <td><span class="tag tag-success">{{user.position | upText}}</span></td>
                      <td>{{user.name_th}}</td>
                      <td>{{user.role_name_th}}</td>
                      <td>{{user.created | MyDate}}</td>
                      <td>
                          <a href="#" @click="ModalEditUser(user)">
                              <i class="fas fa-edit"></i>
                          </a>
                          /
                          <a href="#" @click="DeleteUser(user.id)">
                              <i class="fas fa-trash red"></i>
                          </a>
                      </td>
                    </tr>

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <pagination :data="users" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
    </div>

    <div v-if="!$gate.isAdminOrApprover()">
      <not-found></not-found>
    </div>

        <div class="modal fade" id="modal-default" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                  <h4 v-if="editmode" class="modal-title">Update Member</h4>
                  <h4 v-if="!editmode" class="modal-title">Create Member</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                  </button>
                  </div>
                  <form @submit.prevent="editmode ? EditUser() : CreateUser()">
                    <div class="modal-body">

                      <div class="form-group">
                          <label>Name</label>
                          <input v-model="form.name" type="text" name="name"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                          <has-error :form="form" field="name"></has-error>
                        </div>

                        <div class="form-group">
                          <label>Email</label>
                          <input v-model="form.email" type="text" name="email"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                          <has-error :form="form" field="email"></has-error>
                        </div>

                        <div class="form-group">
                          <label>Password</label>
                          <input v-model="form.password" type="text" name="password"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                          <has-error :form="form" field="password"></has-error>
                        </div>

                        <div class="form-group">
                          <label>Nickname</label>
                          <input v-model="form.nickname" type="text" name="nickname"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('nickname') }">
                          <has-error :form="form" field="nickname"></has-error>
                        </div>

                        <div class="form-group">
                          <label>Start Work</label>
                          <input v-model="form.start_work" type="date" name="start_work"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('start_work') }">
                          <has-error :form="form" field="start_work"></has-error>
                        </div>

                        <div class="form-group">
                          <label>Department</label>
                          <select name="department_id" id="department_id" v-model="form.department_id" class="form-control" :class="{ 'is_invalid' : form.errors.has('department_id')}">
                            <option v-for="department in departments" :value="department.id">{{department.name_th}}</option>
                          </select>
                          <has-error :form="form" field="department_id"></has-error>
                        </div>

                        <div class="form-group">
                          <label>Role</label>
                          <select name="role_id" id="role_id" v-model="form.role_id" class="form-control" :class="{ 'is_invalid' : form.errors.has('role_id')}">
                            <option v-for="role in roles" :value="role.id">{{role.role_name_th}}</option>
                          </select>
                          <has-error :form="form" field="role_id"></has-error>
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

import { Form, HasError, AlertError } from 'vform'

    export default {
      name : 'member',
      data() {
        return {
            loading : false,
            editmode : false,
            users : {},
            departments : {},
            roles : {},
            form : new Form({
              id : 0,
              name : '',
              start_work : '',
              email : '',
              password : '',
              nickname : '',
              department_id : 0,
              role_id : 0
            })
        }
      },
      methods :{
        getResults(page = 1){
          axios.get('api/user?page=' + page)
            .then(response => {
              this.users = response.data;
            });
        },
        EditUser(){
          this.$Progress.start(); 

          this.form.put('api/user/'+this.form.id)
          .then(() => {
            $('#modal-default').modal('hide')
            toast.fire({
              icon : 'success',
              title : "Update User Success !"
            });
            this.$Progress.finish()
            fire.$emit('aftercreate')
          })
          .catch(() => {
            this.$Progress.fail(); 
          })

        },
        ModalCreateUser(){
          this.editmode = false
          this.form.reset()
          $('#modal-default').modal('show')
        },
        ModalEditUser(user){
          this.editmode = true
          this.form.reset()
          $('#modal-default').modal('show')
          this.form.fill(user)
        },
        CreateUser(){
          this.$Progress.start()

          this.form.post('api/user')
          .then(() =>{
            fire.$emit('aftercreate')
            $('#modal-default').modal('hide')

            toast.fire({
              icon : 'success',
              title : "Create User Success !"
            });

            this.$Progress.finish()
          })
          .catch(() => {
            this.$Progress.fail(); 
          });
        },
        LoadUsers(){
          if(this.$gate.isAdminOrApprover){
            this.loading = true
            axios.get('api/user').then(response => {
              this.loading = false
              this.users = response.data.user
              this.departments = response.data.department
              this.roles = response.data.role
            });
          }
        },

        DeleteUser(id){
          swal.fire({
            title: 'ลบข้อมูล',
            text: "ยืนยันที่จะลบข้อมูลหรือไม่?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
          }).then((result) => {
            if(result.value){
              this.form.delete('api/user/'+id).then(() => {
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

        this.LoadUsers()
        fire.$on('aftercreate',() => {
          this.LoadUsers()
        });
        // fetch data every 3 second
        // setInterval(() => this.LoadUsers(),3000)
      }
    }
</script>
