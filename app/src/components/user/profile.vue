<template>
  <div class="">
    <section class="content-header">
      <h1>
        Người dùng
        <small>Profile</small>
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header clearfix">
              <button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#user-change-password">Đổi mật khẩu</button>
            </div>
            <div class="box-body">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Họ và tên:</label>
                  <input v-model="data.fullname" type="text" class="form-control" />
                </div>
                <div class="form-group">
                  <label>Email:</label>
                  <input v-model="data.email" disabled="" type="text" class="form-control" />
                </div>
                <div class="form-group">
                    <label for="">Chức vụ:</label>
                    <input v-model="data.position_name" disabled="" type="text" class="form-control" />
                </div>
                <div class="form-group">
                    <label for="">Quyền thao tác:</label>
                    <input v-for="item in data.permission" :value="item.project.name +' - '+ item.title" disabled="" type="text" class="form-control" />
                </div>
                <div class="clearfix">
                  <span @click="submit" class="btn btn-primary">Cập nhật</span>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
    <changePassword @reload="getData" />
  </div>
</template>
<script>
import UserRepository from '@/repositories/UserRepository'
import PermissionRepository from '@/repositories/PermissionRepository'

export default {
  metaInfo: {
    title: 'Thành viên - Profile | ID Gobig',
  },
  data: () => ({
    data : {
      fullname: null,
      position_name: null,
      permission: []
    },
    component: {
      positions: []
    }
  }),
  components: {
    changePassword: ()=> import('./change_password'),
  },
  created() {
    this.getData();
  },
  methods: {
    getData() {
      UserRepository.profile()
        .then(response=> {
           this.data.fullname = response.fullname;
           this.data.email = response.email;
           this.data.position_name = response.position.name;
           this.data.permission = response.permission;
        })
    },
    submit() {
      UserRepository.updateProfile(this.data)
      .then(response=> {
        switch(response.status) {
            case 1: 
                this.$notify({
                    text: 'Cập nhật thông tin thành công',
                    type: 'success'
                });
            break;
            case 0:
                response.messages.list.map(value=> {
                    this.$notify({
                        text: value,
                        type: 'error'
                    })
                });
            break;
        }
      })
    }
  }
}

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
