<template>
  <div id="index-product" class="">
  	<div class="bot-scene-content">
            <div class="folders-content">
                <div class="show_list">
                    <div class="list_title">
                        <label for=""><i class="icon ion-md-cart"></i> Danh Sách Sản Phẩm</label>
                        <div class="menu-bot-folder each-item-new" title="Create folder">
                          <router-link :to="{ name: 'productAdd'}" class="link">
                            <div class="text-ellipsis menu-item"><i class="icon ion-md-add"></i><span>Tạo sản phẩm</span></div>
                          </router-link>
                        </div>
                    </div>
                    <div class="list_style_option">
                    	  <div class="search">
                            <input type="text" class="form-control input-form" @change="searchProduct($event)" placeholder="Tìm kiếm người dùng...">
                            <button class="sr"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    <div class="panel panel-ui table-product">
                        <div class="col-md-12 padding-0">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên Sản Phẩm</th>
                                        <th>Mã Sản Phẩm</th>
                                        <th>Giá (đơn giá)</th>
                                        <th>Số Lượng</th>
                                        <th>SL Đặt Hàng</th>
                                        <th>SL Giao Hàng</th>
                                        <th>SL Hủy Hàng</th>
                                        <th>Sửa</th>
                                        <th>Xóa</th>
                                    </tr>
                                </thead>
                                <tbody class="table-product-body">
                                    <tr >
                                        
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="list_pagiration" v-if="data.paginate">
                         <span class="list_total">Có tổng sổ {{data.paginate.totalPage}} sản phẩm</span>
                        <ul class="pagination">
        
                            <li class="page-item"><a class="page-link" href="#"><</a></li>
                            <li class="page-item" v-for="item in data.paginate.total" @click="changePage(item)"><a class="page-link" href="#">{{item}}</a></li>
                            <!-- <li><router-link :to={name:productIndex,params:{page:2}}>2</router-link></li> -->
                            <li class="page-item"><a class="page-link" href="#">></a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
  </div>
</template>


<script>
import { mapGetters } from 'vuex'

export default {
  data: () => ({
    data : []
  }),
  components: {
  },
  computed: {
    // ...mapGetters({
    //   data: 'products',
    // })
  },
  watch: {
  },
  created() {
    
  },
  methods: {
      
  }
}

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
