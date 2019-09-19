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
                <button v-if="$helper.user.permission('user.add|user.manager')" type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#user-add">Thêm mới</button>
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
                      <span class="label label-primary" data-toggle="modal" data-target="#user-children" @click="component.user_children.user_id = item.id">
                        <i class="fa fa-user-o"></i> Nhân viên
                      </span>
                      <span v-if="$helper.user.permission('user.update_permission|user.manager')" class="label label-primary" data-toggle="modal" data-target="#user-add-permission" @click="component.user_add_permission.user_id = item.id">
                        <i class="fa fa-get-pocket"></i> Quyền
                      </span>
                      <span v-if="$helper.user.permission('user.edit|user.manager')" class="label label-primary" data-toggle="modal" data-target="#user-edit" @click="component.user_edit.user_id = item.id">
                        <i class="fa fa-edit"></i> Cập nhật
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                     <paginate 
                        :page_total="component.paginate.page_total"
                        :page_current.sync="component.paginate.page_current"
                        :total_record="component.paginate.total_record"
                        />
                  </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
    <userAdd v-if="$helper.user.permission('user.add|user.manager')" @reload="getData" />
    <userEdit
      @reload="getData"
      v-if="$helper.user.permission('user.edit|user.manager')"
      :user_id="component.user_edit.user_id"
    />
    <userChildren :user_id="component.user_children.user_id" />
    <userAddPermission
      v-if="$helper.user.permission('user.update_permission|user.manager')"
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
      user_children: {
        user_id: null
      },
      user_add_permission: {
        user_id: null
      },
      user_edit: {
        user_id: 0
      },
      paginate: {
        page_total: 0,
        page_current: 0,
        total_record: 0
      }
    },
    params: {
      name: null,
      page: 1,
      per: 10
    }
  }),
  components: {
    userAdd: ()=> import('./add'),
    userEdit: ()=> import('./edit'),
    userChildren: ()=> import('./children'),
    userAddPermission: ()=> import('./add_permission'),
    paginate: ()=> import('@/components/templates/paginate.vue')
  },
  watch: {
    'component.paginate.page_current': function(value) {
        if(value !== this.params.page) {
            this.params.page = value;
            this.getData();
        }
    },
  },
  created() {
    this.getData();
  },
  methods: {
    async getData() {
      const response = await UserRepository.getByFilter({
        page: this.params.page,
        page_per: this.params.per,
      });
      this.data = response.users;
      this.component.paginate.page_total = response.paginate.total;
      this.component.paginate.page_current = response.paginate.current;
      this.component.paginate.total_record = response.paginate.total_record;
    }
  }
}

</script>