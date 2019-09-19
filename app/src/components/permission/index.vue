<template>
  <div class="">
    <section class="content-header">
      <h1>
        Phân quyền
        <small>Danh sách</small>
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header clearfix">
                <button  type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#permission-add">Thêm mới</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-hover">
                <thead>
                    <tr>
                      <th>STT</th>
                      <th>Tên</th>
                      <th>Dự án</th>
                      <th>Ngày tạo</th>
                      <th>Tác vụ</th>
                    </tr>
                </thead>
                <tbody class="table-product-body">
                    <tr v-for="(item, stt) in data">
                        <td>{{ stt+1 }}</td>
                        <td>{{ item.title }}</td>
                        <td>{{ item.project.name }}</td>
                        <td>{{ item.created_at }}</td>
                        <td>
                          <span class="label label-primary" data-toggle="modal" data-target="#permission-edit" @click="component.permission_edit.id = item.id">
                            <i class="fa fa-edit"></i> Sửa
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
    <permissionAdd 
      @reload="getData"
    />
    <permissionEdit 
      @reload="getData"
      :id.sync="component.permission_edit.id"
    />
  </div>
</template>

<script>
import PermissionRepository from '@/repositories/PermissionRepository'

export default {
  metaInfo: {
    title: 'Phân quyền - Danh sách | ID Gobig',
  },
  data: () => ({
    data : [],
    component: {
      permission_edit: {
        id: 0
      }
    }
  }),
  components: {
    permissionAdd: ()=> import('./add'),
    permissionEdit: ()=> import('./edit')
  },
  watch: {},
  created() {
    this.getData();
  },
  methods: {
    getData() {
      PermissionRepository.getByfilter()
      .then(response=> {
        this.data = response;
      })
    }
  }
}

</script>