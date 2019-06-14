<template>
  <div id="index-product" class="">
  	<div class="bot-scene-content">
            <div class="folders-content">
                <div class="show_list">
                    <div class="list_title">
                        <label for=""><i class="icon ion-md-cart"></i> Danh sách dự án</label>
                        <div class="menu-bot-folder each-item-new">
                            <div class="text-ellipsis menu-item" data-toggle="modal" data-target="#user-add">
                                <a href="javascript:;" >
                                    <i class="fa fa-plus"></i>
                                    <span>Thêm mới</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-ui table-product">
                        <div class="col-md-12 padding-0">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                      <td>STT</td>
                                      <td>Code</td>
                                      <td>Tên</td>
                                      <td>Ngày tạo</td>
                                      <td>Tác vụ</td>
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
                    </div>
                </div>
            </div>
        </div>
        <user-add 
	        @reload="getData"
        />
  </div>
</template>


<script>
import PermissionRepository from '@/repositories/PermissionRepository'

export default {
  data: () => ({
    data : []
  }),
  components: {
    userAdd: ()=> import('./add')
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
