<template>
  <div>
    <section class="content-header">
      <h1>
        Dự án
        <small>Danh sách</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Simple</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header clearfix">
                <div class="input-group input-group-sm pull-left" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">
                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
                <button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#project-add">Thêm mới</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-hover">
                <thead>
                                    <tr>
                                      <th>STT</th>
                                      <th>Code</th>
                                      <th>Tên</th>
                                      <th>Ngày tạo</th>
                                      <th>Tác vụ</th>
                                    </tr>
                                </thead>
                                <tbody class="table-product-body">
                                    <tr v-for="item in data">
                                        <td></td>
                                        <td>{{ item.code }}</td>
                                        <td>
                                           <router-link 
                                            :to="{ 
                                              name: 'permissionModule',
                                              params: {project_id: item.id}
                                            }" 
                                            class="link"
                                            >
                                            {{ item.name }}
                                          </router-link>
                                        </td>
                                        <td>{{ item.created_at }}</td>
                                        <td></td>
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
    <projectAdd />
  </div>
</template>

<script>
import PermissionRepository from '@/repositories/PermissionRepository'

export default {
  data: () => ({
    data : []
  }),
  components: {
    projectAdd: ()=> import('./add')
  },
  watch: {},
  created() {
    this.getData();
  },
  methods: {
    getData() {
      PermissionRepository.getListProject()
      .then(response=> {
        this.data = response;
      })
    }
  }
}

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
