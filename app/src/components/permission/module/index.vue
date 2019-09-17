<template>
  <div class="">
    <section class="content-header">
      <h1>
        Module
        <small>Danh sách</small>
      </h1>
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
                <button type="button" class="btn btn-info btn-sm pull-right" data-toggle="modal" data-target="#module-add">Thêm mới</button>
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
                <template v-for="(item, stt) in data">
                  <tr>
                      <td>{{ stt+1 }}</td>
                      <td>{{ item.code }}</td>
                      <td>{{ item.name }}</td>
                      <td>{{ item.created_at }}</td>
                      <td></td>
                  </tr>
                  <tr v-for="(item, stt_2) in item.children">
                    <td>{{ stt+stt_2+1 }}</td>
                    <td>{{ item.code }}</td>
                    <td>-- {{ item.name }}</td>
                    <td>{{ item.created_at }}</td>
                    <td></td>
                  </tr>
                </template>
                  
              </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
    <moduleAdd 
      :project_id="project_id"
      :list_module="data"
      @reload="getData"
    />
  </div>
</template>

<script>
import PermissionRepository from '@/repositories/PermissionRepository'

export default {
  metaInfo: {
    title: 'Module - Danh sách | ID Gobig',
  },
  data: () => ({
  	project_id: 0,
    data : []
  }),
  components: {
    moduleAdd: ()=> import('./add')
  },
  watch: {},
  created() {
    this.project_id = parseInt(this.$route.params.project_id);
    this.getData();
  },
  methods: {
    getData() {
      PermissionRepository.getListModule(this.project_id)
      .then(response=> {
        this.data = response;
      })
    }
  }
}

</script>
