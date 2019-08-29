<template>
  <div class="">
    <section class="content-header">
      <h1>
        Người dùng
        <small>Danh sách</small>
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header clearfix">
                <button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#user-add">Thêm mới</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>STT</th>
                    <th>Họ và tên</th>
                    <th>Email</th>
                    <th>Ngày tạo</th>
                    <th>Tác vụ</th>
                  </tr>
                </thead>
                <tbody class="table-product-body">
                  <tr v-for="(item, stt) in data">
                    <td>{{ stt+1 }}</td>
                    <td>{{ item.fullname }}</td>
                    <td>{{ item.email }}</td>
                    <td>{{ item.created_at }}</td>
                    <td>
                      <span class="label label-primary" data-toggle="modal" data-target="#user-add-child" @click="component.user_add_child.user_id = item.id">
                        <i class="fa fa-users"></i> Nhân viên
                      </span>
                      <span class="label label-primary" data-toggle="modal" data-target="#user-add-permission" @click="component.user_add_permission.user_id = item.id">
                        <i class="fa fa-get-pocket"></i> Quyền
                      </span>
                      <span class="label label-primary" data-toggle="modal" data-target="#user-edit" @click="component.user_edit.user_id = item.id">
                        <i class="fa fa-edit"></i> Cập nhật
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
    <userAdd @reload="getData" />
    <userAddChild 
      @reload="getData"
      :user_id="component.user_add_child.user_id"
    />
    <userEdit
      @reload="getData"
      :user_id="component.user_edit.user_id"
    />
    <userAddPermission
      @reload="getData"
      :user_id="component.user_add_permission.user_id"
    />
  </div>
</template>
<script>
import UserRepository from '@/repositories/UserRepository'

export default {
  metaInfo: {
    title: 'Thành viên - Danh sách | ID Gobig',
  },
  data: () => ({
    data : [],
    component: {
      user_add_child: {
        user_id: null
      },
      user_add_permission: {
        user_id: null
      },
      user_edit: {
        user_id: 0
      }
    }
  }),
  components: {
    userAdd: ()=> import('./add'),
    userEdit: ()=> import('./edit'),
    userAddChild: ()=> import('./add_child'),
    userAddPermission: ()=> import('./add_permission'),
  },
  watch: {},
  created() {
    this.getData();
  },
  methods: {
    getData() {
      UserRepository.getByFilter([])
      .then(response=> {
        this.data = response.users;
      })
    }
  }
}

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
